from flask import Flask, request, jsonify
from flask_cors import CORS
import os
import base64
from PIL import Image
import io
import time
import threading
from dotenv import load_dotenv
from hair_ai_service import HairRecommendationService

# Load environment variables
load_dotenv()

app = Flask(__name__)
CORS(app)  # Enable CORS for Laravel integration

# Configuration
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024  # 16MB max file size
UPLOAD_FOLDER = 'uploads'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

# Progress tracking
progress_store = {}
progress_lock = threading.Lock()

def update_progress(session_id, step, message, percentage=0, result=None, error=None):
    """Update progress for a session"""
    with progress_lock:
        progress_data = {
            'step': step,
            'message': message,
            'percentage': percentage,
            'timestamp': time.time()
        }
        
        # Store result if provided
        if result is not None:
            progress_data['result'] = result
            
        # Store error message if provided
        if error is not None:
            progress_data['error'] = error
        elif step == 'error':
            # If step is error but no explicit error message, use the message
            progress_data['error'] = message
            
        progress_store[session_id] = progress_data
    print(f"📊 Progress [{session_id}]: {step} - {message} ({percentage}%)")

def get_progress(session_id):
    """Get current progress for a session"""
    with progress_lock:
        return progress_store.get(session_id, {
            'step': 'waiting',
            'message': 'Menunggu...',
            'percentage': 0,
            'timestamp': time.time()
        })

def clear_progress(session_id):
    """Clear progress for a session"""
    with progress_lock:
        if session_id in progress_store:
            del progress_store[session_id]

# Initialize services
aws_access_key = os.getenv('AWS_ACCESS_KEY_ID')
aws_secret_key = os.getenv('AWS_SECRET_ACCESS_KEY')
aws_region = os.getenv('AWS_DEFAULT_REGION', 'us-east-1')

# Support multiple Gemini API keys for quota fallback - automatically detect all available keys
gemini_api_keys = []

# Method 1: Check for numbered keys (GEMINI_API_KEY_1, GEMINI_API_KEY_2, etc.)
i = 1
while True:
    key = os.getenv(f'GEMINI_API_KEY_{i}')
    if key:
        gemini_api_keys.append(key)
        print(f"✓ Gemini API key #{i} loaded from GEMINI_API_KEY_{i}")
        i += 1
    else:
        break

# Method 2: Check for legacy single key (GEMINI_API_KEY)
legacy_key = os.getenv('GEMINI_API_KEY')
if legacy_key and legacy_key not in gemini_api_keys:
    gemini_api_keys.append(legacy_key)
    print(f"✓ Legacy Gemini API key loaded from GEMINI_API_KEY")

# Method 3: Check for alternative naming patterns (GEMINI_KEY_1, GOOGLE_AI_KEY_1, etc.)
for prefix in ['GEMINI_KEY', 'GOOGLE_AI_KEY', 'GOOGLE_GEMINI_KEY']:
    i = 1
    while True:
        key = os.getenv(f'{prefix}_{i}')
        if key and key not in gemini_api_keys:
            gemini_api_keys.append(key)
            print(f"✓ Gemini API key #{len(gemini_api_keys)} loaded from {prefix}_{i}")
            i += 1
        else:
            break

# Remove duplicates while preserving order
seen = set()
unique_keys = []
for key in gemini_api_keys:
    if key not in seen:
        seen.add(key)
        unique_keys.append(key)
gemini_api_keys = unique_keys

if not aws_access_key or not aws_secret_key:
    print("WARNING: AWS credentials not found. Face analysis will fail.")
    print("Please set AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY environment variables.")

if not gemini_api_keys:
    print("INFO: No Gemini API keys found. AI recommendations will use fallbacks.")
    print("To enable Gemini AI, set GEMINI_API_KEY_1, GEMINI_API_KEY_2, etc. environment variables.")
    print("Supported formats: GEMINI_API_KEY_1, GEMINI_KEY_1, GOOGLE_AI_KEY_1, GOOGLE_GEMINI_KEY_1")
else:
    print(f"✅ {len(gemini_api_keys)} unique Gemini API key(s) loaded for robust quota fallback support.")

# Initialize the hair recommendation service with multiple API keys
hair_service = HairRecommendationService(
    aws_access_key=aws_access_key,
    aws_secret_key=aws_secret_key,
    aws_region=aws_region,
    gemini_api_keys=gemini_api_keys  # Pass list of API keys
)

@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'AI Hair Analysis',
        'available_keys': len(gemini_api_keys) if gemini_api_keys else 0
    })

@app.route('/progress/<session_id>', methods=['GET'])
def get_progress_status(session_id):
    """Get progress status for a session"""
    progress = get_progress(session_id)
    
    # Add debug info
    debug_info = {
        'has_result': 'result' in progress,
        'result_served': progress.get('result_served', False),
        'keys_in_progress': list(progress.keys()),
    }
    
    # Log the progress check for debugging
    print(f"📊 Progress check for {session_id}: step={progress.get('step')}, percentage={progress.get('percentage')}, has_result={debug_info['has_result']}")
    
    # Add debug info to response in development
    response_data = progress.copy()
    response_data['debug'] = debug_info
    
    return jsonify(response_data)

@app.route('/start-analysis', methods=['POST'])
def start_analysis():
    """
    Start haircut analysis - accepts image and returns session_id
    Processes in background and client can poll /progress/<session_id>
    """
    try:
        # Get or generate session ID for progress tracking
        session_id = request.form.get('session_id', f"session_{int(time.time() * 1000)}")
        
        print(f"🚀 Starting analysis for session: {session_id}")
        update_progress(session_id, "validation", "Memvalidasi file...", 5)
        
        # Check if AI service is available
        if not hair_service:
            update_progress(session_id, "error", "Layanan AI tidak tersedia", 0)
            return jsonify({
                'success': False,
                'error': 'AI service not available. Please check AWS credentials.',
                'session_id': session_id
            }), 500

        # Check if image was uploaded
        if 'image' not in request.files:
            update_progress(session_id, "error", "File gambar tidak ditemukan", 0)
            return jsonify({
                'success': False,
                'error': 'No image file provided',
                'session_id': session_id
            }), 400

        file = request.files['image']
        
        if file.filename == '':
            update_progress(session_id, "error", "File gambar tidak dipilih", 0)
            return jsonify({
                'success': False,
                'error': 'No image file selected',
                'session_id': session_id
            }), 400

        print(f"📁 Received file: {file.filename}, size: {len(file.read())} bytes")
        file.seek(0)  # Reset file pointer after reading for size

        update_progress(session_id, "validation", "Memeriksa format file...", 10)

        # Validate file type
        if not allowed_file(file.filename):
            update_progress(session_id, "error", "Format file tidak valid", 0)
            return jsonify({
                'success': False,
                'error': 'Invalid file type. Please upload JPG, JPEG, or PNG images.',
                'session_id': session_id
            }), 400

        # Get preferred style
        preferred_style = request.form.get('preferred_style', '')
        
        # Read file data before starting thread (to avoid file closing issues)
        file_data = file.read()
        file.seek(0)  # Reset for any further use
        
        # Start background processing with file data instead of file object
        thread = threading.Thread(
            target=process_analysis_background, 
            args=(session_id, file_data, file.filename, preferred_style)
        )
        thread.daemon = True
        thread.start()
        
        # Return immediately with session ID
        return jsonify({
            'success': True,
            'session_id': session_id,
            'message': 'Analysis started. Poll /progress/{session_id} for updates.'
        }), 202  # 202 Accepted - processing started
        
    except Exception as e:
        session_id = request.form.get('session_id', 'unknown')
        error_msg = f"Error starting analysis: {str(e)}"
        print(f"❌ {error_msg}")
        update_progress(session_id, "error", error_msg, 0)
        return jsonify({
            'success': False,
            'error': error_msg,
            'session_id': session_id
        }), 500

def process_analysis_background(session_id, file_data, filename, preferred_style):
    """Background processing function for analysis"""
    try:
        print(f"🔄 Background processing started for session: {session_id}")
        update_progress(session_id, "upload", "Memproses file gambar...", 15)
        
        # Save uploaded file data to disk
        file_path = os.path.join(UPLOAD_FOLDER, f"{session_id}_{filename}")
        
        with open(file_path, 'wb') as f:
            f.write(file_data)
        
        print(f"💾 File saved: {file_path}")
        update_progress(session_id, "processing", "Menganalisis gambar...", 25)

        time.sleep(3)

        # Load and process the image
        try:
            image = Image.open(file_path)
            # Convert to RGB if necessary
            if image.mode != 'RGB':
                image = image.convert('RGB')
                print(f"🔄 Image converted to RGB mode")
        except Exception as e:
            print(f"❌ Error opening image: {e}")
            update_progress(session_id, "error", f"Gambar tidak valid: {str(e)}", 0)
            return

        update_progress(session_id, "analysis", "Menganalisis bentuk wajah...", 30)

        # Perform face analysis with image bytes instead of PIL image
        try:
            face_analysis = hair_service.rekognition_service.analyze_face(file_data)
            print(f"👤 Face analysis completed: {face_analysis}")
        except Exception as e:
            print(f"❌ Face analysis error: {e}")
            update_progress(session_id, "error", f"Gagal menganalisis wajah: {str(e)}", 0)
            return

        update_progress(session_id, "generation", "Menghasilkan rekomendasi...", 60)

        # Use the existing process_selfie_with_progress method which handles everything
        try:
            result = hair_service.process_selfie_with_progress(
                file_data, 
                session_id, 
                update_progress, 
                preferred_style
            )
            
            if result['success']:
                print(f"✅ Analysis completed successfully for session: {session_id}")
                
                # Ensure the result is properly stored with "complete" status
                # The process_selfie_with_progress should have already done this, but let's make sure
                progress = get_progress(session_id)
                if progress['step'] != 'complete':
                    print(f"📝 Final step was '{progress['step']}', updating to 'complete' with result")
                    update_progress(session_id, "complete", "Analisis selesai!", 100, result=result)
                else:
                    print(f"✅ Progress already marked as complete")
                    
            else:
                error_msg = result.get('error', 'Analisis gagal')
                print(f"❌ Analysis failed: {error_msg}")
                update_progress(session_id, "error", error_msg, 0)
                
        except Exception as e:
            print(f"❌ Hair service processing error: {e}")
            update_progress(session_id, "error", f"Gagal memproses analisis: {str(e)}", 0)
            return

        # Clean up uploaded file
        try:
            if os.path.exists(file_path):
                os.remove(file_path)
                print(f"🗑️ Cleaned up file: {file_path}")
        except Exception as e:
            print(f"⚠️ Could not clean up file {file_path}: {e}")

    except Exception as e:
        print(f"❌ Background processing error for {session_id}: {e}")
        update_progress(session_id, "error", f"Terjadi kesalahan: {str(e)}", 0)

# Keep the original endpoint for backward compatibility
@app.route('/analyze-haircut', methods=['POST'])
def analyze_haircut():
    """
    Legacy endpoint - redirects to new start-analysis endpoint
    """
    return start_analysis()

@app.route('/get-result/<session_id>', methods=['GET'])
def get_result(session_id):
    """Get the final result for a completed analysis"""
    progress = get_progress(session_id)
    
    if progress['step'] == 'complete' and 'result' in progress:
        result = progress['result']
        
        print(f"📤 Serving final result for session: {session_id}")
        
        # Mark that result has been retrieved but don't clean up immediately
        # Add a flag to indicate result has been served
        with progress_lock:
            if session_id in progress_store:
                progress_store[session_id]['result_served'] = True
                progress_store[session_id]['served_at'] = time.time()
                print(f"✅ Marked result as served for {session_id}")
        
        # Schedule cleanup after a delay (e.g., 30 seconds) to allow for any retries
        import threading
        def delayed_cleanup():
            time.sleep(30)  # Wait 30 seconds
            with progress_lock:
                if session_id in progress_store:
                    del progress_store[session_id]
                    print(f"🗑️ Cleaned up progress data for {session_id} (delayed)")
        
        cleanup_thread = threading.Thread(target=delayed_cleanup)
        cleanup_thread.daemon = True
        cleanup_thread.start()
        
        return jsonify({
            'success': True,
            'result': result,
            'session_id': session_id
        })
    elif progress['step'] == 'error':
        return jsonify({
            'success': False,
            'error': progress.get('error', 'Analysis failed'),
            'session_id': session_id
        }), 400
    else:
        return jsonify({
            'success': False,
            'error': 'Analysis not complete yet',
            'session_id': session_id,
            'current_step': progress['step'],
            'percentage': progress['percentage']
        }), 202  # Still processing

def allowed_file(filename):
    """Check if the uploaded file is allowed"""
    ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif'}
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

def clear_progress(session_id):
    """Clear progress data for a session"""
    with progress_lock:
        if session_id in progress_store:
            del progress_store[session_id]
            print(f"Cleared progress for session: {session_id}")

@app.route('/test-recognition', methods=['POST'])
def test_recognition():
    """
    Test endpoint for AWS Rekognition only (without image generation)
    """
    try:
        if not hair_service:
            return jsonify({
                'success': False,
                'error': 'AI service not available'
            }), 500

        if 'image' not in request.files:
            return jsonify({
                'success': False,
                'error': 'No image file provided'
            }), 400

        file = request.files['image']
        image_data = file.read()
        
        # Only test face analysis
        face_analysis = hair_service.rekognition_service.analyze_face(image_data)
        recommendations = hair_service.hair_generation.generate_haircut_recommendations(face_analysis)
        
        return jsonify({
            'success': True,
            'face_analysis': face_analysis,
            'recommendations': recommendations
        }), 200

    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/check-quota', methods=['GET'])
def check_quota():
    """
    Check quota status for all Gemini API keys
    """
    try:
        if not hair_service:
            return jsonify({
                'success': False,
                'error': 'AI service not available'
            }), 500
        
        # Get project ID from query params if provided
        project_id = request.args.get('project_id')
        
        print("🔍 Starting quota check via API endpoint...")
        
        # Run comprehensive quota check
        results = hair_service.hair_generation.run_comprehensive_quota_check(project_id)
        
        return jsonify({
            'success': True,
            'quota_check': results,
            'timestamp': time.time(),
            'summary': {
                'total_keys': results['total_keys'],
                'working_keys': results['working_keys_count'],
                'quota_exceeded': results['quota_exceeded_count'],
                'has_cloud_metrics': results['quota_metrics'] is not None
            }
        }), 200
        
    except Exception as e:
        print(f"❌ Quota check error: {e}")
        return jsonify({
            'success': False,
            'error': f'Quota check failed: {str(e)}'
        }), 500

@app.route('/check-quota/keys-only', methods=['GET'])
def check_quota_keys_only():
    """
    Check quota status for API keys only (faster, no Google Cloud metrics)
    """
    try:
        if not hair_service:
            return jsonify({
                'success': False,
                'error': 'AI service not available'
            }), 500
        
        print("🔍 Starting API keys quota check...")
        
        # Check only API keys
        api_key_results = hair_service.hair_generation.check_all_api_keys_quota()
        
        working_keys = [r for r in api_key_results if r['working']]
        quota_exceeded_keys = [r for r in api_key_results if r['quota_exceeded']]
        
        return jsonify({
            'success': True,
            'api_key_results': api_key_results,
            'timestamp': time.time(),
            'summary': {
                'total_keys': len(api_key_results),
                'working_keys': len(working_keys),
                'quota_exceeded': len(quota_exceeded_keys),
                'working_key_indices': [r['key_index'] for r in working_keys],
                'quota_exceeded_indices': [r['key_index'] for r in quota_exceeded_keys]
            }
        }), 200
        
    except Exception as e:
        print(f"❌ API keys quota check error: {e}")
        return jsonify({
            'success': False,
            'error': f'API keys quota check failed: {str(e)}'
        }), 500

@app.route('/check-quota/cloud-metrics', methods=['GET'])
def check_quota_cloud_metrics():
    """
    Check Google Cloud quota metrics only (requires gcloud auth)
    """
    try:
        if not hair_service:
            return jsonify({
                'success': False,
                'error': 'AI service not available'
            }), 500
        
        # Get project ID from query params if provided
        project_id = request.args.get('project_id')
        
        print("🔍 Starting Google Cloud quota metrics check...")
        
        # Get Google Cloud quota metrics
        quota_metrics = hair_service.hair_generation.get_google_cloud_quota_metrics(project_id)
        
        if quota_metrics:
            return jsonify({
                'success': True,
                'quota_metrics': quota_metrics,
                'timestamp': time.time(),
                'project_id': project_id
            }), 200
        else:
            return jsonify({
                'success': False,
                'error': 'Could not retrieve Google Cloud quota metrics. Ensure gcloud is authenticated and project ID is set.',
                'project_id': project_id
            }), 400
        
    except Exception as e:
        print(f"❌ Cloud metrics check error: {e}")
        return jsonify({
            'success': False,
            'error': f'Cloud metrics check failed: {str(e)}'
        }), 500

@app.route('/quota-status', methods=['GET'])
def quota_status():
    """
    Get quick quota status summary
    """
    try:
        if not hair_service:
            return jsonify({
                'success': False,
                'error': 'AI service not available'
            }), 500
        
        hair_gen = hair_service.hair_generation
        
        return jsonify({
            'success': True,
            'status': {
                'total_api_keys': len(hair_gen.api_keys),
                'current_key_index': hair_gen.current_key_index,
                'quota_exceeded_keys': list(hair_gen.quota_exceeded_keys),
                'available_keys': len(hair_gen.api_keys) - len(hair_gen.quota_exceeded_keys),
                'current_key_working': hair_gen.model is not None,
                'current_key_preview': f"{hair_gen.api_keys[hair_gen.current_key_index][:8]}...{hair_gen.api_keys[hair_gen.current_key_index][-4:]}" if hair_gen.api_keys and hair_gen.current_key_index < len(hair_gen.api_keys) else None
            },
            'timestamp': time.time()
        }), 200
        
    except Exception as e:
        print(f"❌ Quota status error: {e}")
        return jsonify({
            'success': False,
            'error': f'Quota status failed: {str(e)}'
        }), 500

if __name__ == '__main__':
    port = int(os.getenv('FLASK_PORT', 5001))  # Use port 5001 by default
    print("Starting Hair AI Recommendation API...")
    print("Make sure to:")
    print("1. Set your AWS credentials in .env file")
    print("2. Install dependencies: pip install -r requirements.txt")
    print(f"3. Access the API at: http://localhost:{port}")
    
    app.run(
        host='0.0.0.0',
        port=port,
        debug=os.getenv('FLASK_DEBUG', 'False').lower() == 'true'
    )
