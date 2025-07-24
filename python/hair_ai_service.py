import boto3
import json
from PIL import Image
import io
import base64
import requests
import time
import os
import subprocess
from datetime import datetime, timedelta
import google.generativeai as genai
from google import genai as genai_client
from google.genai import types
import threading
from concurrent.futures import ThreadPoolExecutor, TimeoutError
import signal

class AWSRekognitionService:
    def __init__(self, aws_access_key, aws_secret_key, region='us-east-1'):
        self.rekognition = boto3.client(
            'rekognition',
            aws_access_key_id=aws_access_key,
            aws_secret_access_key=aws_secret_key,
            region_name=region
        )
    
    def analyze_face(self, image_bytes):
        """
        Analyze face features using AWS Rekognition
        Returns detailed face analysis for haircut recommendations
        """
        try:
            response = self.rekognition.detect_faces(
                Image={'Bytes': image_bytes},
                Attributes=['ALL']
            )
            
            if not response['FaceDetails']:
                return None
                
            face = response['FaceDetails'][0]
            
            # Extract relevant features for haircut recommendation
            analysis = {
                'face_shape': self._determine_face_shape(face),
                'age_range': face.get('AgeRange', {}),
                'gender': face.get('Gender', {}).get('Value', 'Unknown'),
                'emotions': face.get('Emotions', []),
                'facial_hair': face.get('Beard', {}).get('Value', False),
                'confidence': face.get('Confidence', 0)
            }
            
            return analysis
            
        except Exception as e:
            print(f"AWS Rekognition error: {str(e)}")
            return None
    
    def _determine_face_shape(self, face_details):
        """
        Determine face shape based on facial landmarks and geometry
        """
        # Get bounding box dimensions
        bbox = face_details.get('BoundingBox', {})
        width = bbox.get('Width', 0)
        height = bbox.get('Height', 0)
        
        if height == 0:
            return 'oval'
            
        ratio = width / height
        
        # Simple face shape classification based on width/height ratio
        if ratio > 0.8:
            return 'round'
        elif ratio < 0.6:
            return 'long'
        elif 0.6 <= ratio <= 0.75:
            return 'oval'
        else:
            return 'square'


class GeminiHairGeneration:
    def __init__(self, gemini_api_key=None, gemini_api_keys=None):
        # Support both single key (backwards compatibility) and multiple keys
        if gemini_api_keys:
            # Use the new multi-key system
            if isinstance(gemini_api_keys, list):
                self.api_keys = [key for key in gemini_api_keys if key]  # Filter out empty keys
            else:
                self.api_keys = [gemini_api_keys] if gemini_api_keys else []
        elif gemini_api_key:
            # Backwards compatibility: convert single key to list
            if isinstance(gemini_api_key, str):
                self.api_keys = [gemini_api_key] if gemini_api_key else []
            elif isinstance(gemini_api_key, list):
                self.api_keys = [key for key in gemini_api_key if key]  # Filter out empty keys
            else:
                self.api_keys = []
        else:
            # No keys provided, try to load from environment
            self.api_keys = self._load_api_keys_from_env()
        
        self.current_key_index = 0
        self.quota_exceeded_keys = set()  # Track which keys have exceeded quota
        
        # Initialize with first available key
        self._initialize_clients()
        
        # Initialize fallback token arrays for quota limit scenarios
        self._init_fallback_arrays()

    @staticmethod
    def _load_api_keys_from_env():
        """
        Load Gemini API keys from environment variables
        Supports multiple naming patterns and unlimited number of keys
        """
        api_keys = []
        
        # Method 1: Check for numbered keys (GEMINI_API_KEY_1, GEMINI_API_KEY_2, etc.)
        i = 1
        while True:
            key = os.getenv(f'GEMINI_API_KEY_{i}')
            if key:
                api_keys.append(key)
                i += 1
            else:
                break
        
        # Method 2: Check for legacy single key (GEMINI_API_KEY)
        legacy_key = os.getenv('GEMINI_API_KEY')
        if legacy_key and legacy_key not in api_keys:
            api_keys.append(legacy_key)
        
        # Method 3: Check for alternative naming patterns
        for prefix in ['GEMINI_KEY', 'GOOGLE_AI_KEY', 'GOOGLE_GEMINI_KEY']:
            i = 1
            while True:
                key = os.getenv(f'{prefix}_{i}')
                if key and key not in api_keys:
                    api_keys.append(key)
                    i += 1
                else:
                    break
        
        # Remove duplicates while preserving order
        seen = set()
        unique_keys = []
        for key in api_keys:
            if key not in seen:
                seen.add(key)
                unique_keys.append(key)
        
        if unique_keys:
            print(f"🔑 Auto-loaded {len(unique_keys)} Gemini API key(s) from environment variables")
        
        return unique_keys

    def _initialize_clients(self):
        """Initialize Gemini clients with current API key"""
        if self.api_keys and self.current_key_index < len(self.api_keys):
            current_key = self.api_keys[self.current_key_index]
            
            try:
                # Initialize both old and new Gemini clients
                genai.configure(api_key=current_key)
                self.client = genai_client.Client(api_key=current_key)
                
                # Use gemini-1.5-flash for text/vision tasks
                self.model = genai.GenerativeModel('gemini-1.5-flash')
                self.vision_model = genai.GenerativeModel('gemini-1.5-flash')
                
                # Image generation model name for new client
                self.image_model_name = "gemini-2.0-flash-preview-image-generation"
                
                print(f"✅ Initialized Gemini with API key #{self.current_key_index + 1}")
                return True
                
            except Exception as e:
                print(f"❌ Failed to initialize API key #{self.current_key_index + 1}: {str(e)}")
                return False
        else:
            print("WARNING: No valid Gemini API keys available. AI recommendations will use fallbacks.")
            self.model = None
            self.vision_model = None
            self.client = None
            self.image_model_name = None
            return False

    def _mark_current_key_as_quota_exceeded(self):
        """Mark the current API key as quota exceeded"""
        print(f"� Marking API key #{self.current_key_index + 1} as quota exceeded")
        self.quota_exceeded_keys.add(self.current_key_index)
        print(f"🔍 Quota exceeded keys: {self.quota_exceeded_keys}")
        print(f"🔍 Total keys available: {len(self.api_keys)}")
        
    def _switch_to_next_available_key(self):
        """Switch to the next available API key that hasn't exceeded quota"""
        original_key_index = self.current_key_index
        
        # Find next available key that hasn't exceeded quota
        for i in range(len(self.api_keys)):
            if i not in self.quota_exceeded_keys and i != original_key_index:
                print(f"🔄 Attempting to switch to API key #{i + 1}")
                old_index = self.current_key_index
                self.current_key_index = i
                
                if self._initialize_clients():
                    print(f"✅ Successfully switched from key #{old_index + 1} to key #{i + 1}")
                    return True
                else:
                    print(f"⚠️ Failed to initialize API key #{i + 1} (not quota-related)")
                    # Don't mark as quota exceeded, just continue to next key
                    continue
        
        # No more available keys
        print("🚫 No more available API keys. All keys either exhausted or failed.")
        print(f"📊 Final quota exceeded keys: {self.quota_exceeded_keys}")
        self.model = None
        self.vision_model = None
        self.client = None
        self.image_model_name = None
        return False

    def _find_next_untried_key(self, attempted_keys):
        """Find the next available key that hasn't been tried yet and isn't quota exceeded"""
        original_key_index = self.current_key_index
        
        for i in range(len(self.api_keys)):
            if i not in self.quota_exceeded_keys and i not in attempted_keys:
                print(f"🔍 Found untried key #{i + 1}")
                self.current_key_index = i
                
                if self._initialize_clients():
                    print(f"✅ Successfully switched to untried key #{i + 1}")
                    return True
                else:
                    print(f"⚠️ Failed to initialize key #{i + 1}")
                    self.current_key_index = original_key_index
                    
        print("❌ No more untried keys available")
        return False

    def _is_quota_error(self, error_msg):
        """Check if error indicates quota exceeded"""
        quota_indicators = [
            "429",  # HTTP 429 Too Many Requests
            "quota exceeded",
            "quota_exceeded", 
            "exceeded your current quota",
            "rate limit exceeded",
            "too many requests",
            "quota_metric",
            "resource_exhausted",  # gRPC error
            "quotaexceeded",  # Google API error (case insensitive)
            "ratelimitexceeded",  # Google API error (case insensitive)
            "userratelimitexceeded"  # Google API error (case insensitive)
        ]
        error_lower = error_msg.lower()
        
        # Check for specific quota-related patterns
        for indicator in quota_indicators:
            if indicator in error_lower:
                print(f"🔍 Detected quota error with indicator: '{indicator}' in error: {error_msg[:100]}...")
                return True
        
        # Additional check for Google API specific quota errors
        if "invalid_grant" not in error_lower and ("limit" in error_lower and ("request" in error_lower or "usage" in error_lower)):
            print(f"🔍 Detected potential quota error with 'limit' pattern: {error_msg[:100]}...")
            return True
            
        return False

    def check_api_key_quota_status(self, api_key, key_index):
        """
        Test if an API key is still working by making a minimal API call
        Returns: {'working': bool, 'error': str, 'quota_exceeded': bool}
        """
        print(f"🔍 Testing API key #{key_index + 1} quota status...")
        
        try:
            # Configure with the specific key
            genai.configure(api_key=api_key)
            model = genai.GenerativeModel('gemini-1.5-flash')
            
            # Make a minimal test request
            test_prompt = "Hello"
            response = model.generate_content(
                test_prompt,
                generation_config=genai.types.GenerationConfig(
                    max_output_tokens=5,
                    temperature=0.1
                )
            )
            
            # If we get here, the key is working
            print(f"✅ API key #{key_index + 1} is working (quota available)")
            return {
                'working': True,
                'error': None,
                'quota_exceeded': False,
                'response_sample': response.text[:50] if response.text else 'Empty response'
            }
            
        except Exception as e:
            error_msg = str(e)
            is_quota_error = self._is_quota_error(error_msg)
            
            if is_quota_error:
                print(f"❌ API key #{key_index + 1} quota exceeded: {error_msg[:100]}...")
                return {
                    'working': False,
                    'error': error_msg,
                    'quota_exceeded': True
                }
            else:
                print(f"⚠️ API key #{key_index + 1} has error (not quota): {error_msg[:100]}...")
                return {
                    'working': False,
                    'error': error_msg,
                    'quota_exceeded': False
                }

    def check_all_api_keys_quota(self):
        """
        Check quota status for all API keys
        Returns: list of quota status for each key
        """
        print(f"🔍 Checking quota status for all {len(self.api_keys)} API keys...")
        results = []
        
        for i, api_key in enumerate(self.api_keys):
            print(f"\n--- Testing API Key #{i + 1} ---")
            
            # Test the key
            status = self.check_api_key_quota_status(api_key, i)
            status['key_index'] = i
            status['key_preview'] = f"{api_key[:8]}...{api_key[-4:]}" if len(api_key) > 12 else api_key
            
            results.append(status)
            
            # Small delay between tests to avoid rate limiting
            time.sleep(0.5)
        
        # Summary
        working_keys = [r for r in results if r['working']]
        quota_exceeded_keys = [r for r in results if r['quota_exceeded']]
        error_keys = [r for r in results if not r['working'] and not r['quota_exceeded']]
        
        print(f"\n📊 Quota Check Summary:")
        print(f"   ✅ Working keys: {len(working_keys)}")
        print(f"   🚫 Quota exceeded: {len(quota_exceeded_keys)}")
        print(f"   ⚠️ Other errors: {len(error_keys)}")
        
        return results

    def get_google_cloud_quota_metrics(self, project_id=None):
        """
        Get detailed quota metrics from Google Cloud Service Usage API
        Requires gcloud CLI authentication and project ID
        """
        if not project_id:
            # Try to get project ID from environment or gcloud config
            project_id = os.getenv('GOOGLE_CLOUD_PROJECT')
            if not project_id:
                try:
                    result = subprocess.run(['gcloud', 'config', 'get-value', 'project'], 
                                          capture_output=True, text=True, timeout=10)
                    if result.returncode == 0:
                        project_id = result.stdout.strip()
                except Exception as e:
                    print(f"⚠️ Could not get project ID: {e}")
                    return None
        
        if not project_id:
            print("❌ No Google Cloud project ID available. Cannot check quota metrics.")
            return None
        
        print(f"🔍 Checking Google Cloud quota metrics for project: {project_id}")
        
        try:
            # Get access token
            token_result = subprocess.run(['gcloud', 'auth', 'print-access-token'], 
                                        capture_output=True, text=True, timeout=10)
            if token_result.returncode != 0:
                print(f"❌ Failed to get access token: {token_result.stderr}")
                return None
            
            access_token = token_result.stdout.strip()
            
            # Make API request to Service Usage API
            url = f"https://serviceusage.googleapis.com/v1/projects/{project_id}/services/generativelanguage.googleapis.com/consumerQuotaMetrics"
            headers = {
                'Authorization': f'Bearer {access_token}',
                'Content-Type': 'application/json'
            }
            
            print(f"🌐 Making request to: {url}")
            response = requests.get(url, headers=headers, timeout=30)
            
            if response.status_code == 200:
                quota_data = response.json()
                print("✅ Successfully retrieved quota metrics")
                
                # Parse and display quota information
                if 'quotaMetrics' in quota_data:
                    print(f"📊 Found {len(quota_data['quotaMetrics'])} quota metrics:")
                    
                    for metric in quota_data['quotaMetrics']:
                        metric_name = metric.get('name', 'Unknown')
                        display_name = metric.get('displayName', 'Unknown')
                        
                        print(f"   📈 {display_name} ({metric_name})")
                        
                        # Show quota limits and usage if available
                        if 'consumerQuotaLimits' in metric:
                            for limit in metric['consumerQuotaLimits']:
                                limit_name = limit.get('name', 'Unknown')
                                if 'quotaBuckets' in limit:
                                    for bucket in limit['quotaBuckets']:
                                        effective_limit = bucket.get('effectiveLimit', 'Unknown')
                                        default_limit = bucket.get('defaultLimit', 'Unknown')
                                        print(f"      💡 {limit_name}: {effective_limit} (default: {default_limit})")
                
                return quota_data
            else:
                print(f"❌ Failed to get quota metrics: {response.status_code} - {response.text}")
                return None
                
        except subprocess.TimeoutExpired:
            print("❌ Timeout while getting access token")
            return None
        except requests.RequestException as e:
            print(f"❌ Request error: {e}")
            return None
        except Exception as e:
            print(f"❌ Unexpected error: {e}")
            return None

    def run_comprehensive_quota_check(self, project_id=None):
        """
        Run comprehensive quota checking including both API key tests and Google Cloud metrics
        """
        print("🔍 Running comprehensive quota check...")
        print("=" * 60)
        
        # Part 1: Test all API keys individually
        print("PART 1: Testing individual API keys")
        print("-" * 40)
        api_key_results = self.check_all_api_keys_quota()
        
        # Part 2: Get Google Cloud quota metrics (if available)
        print("\nPART 2: Google Cloud quota metrics")
        print("-" * 40)
        quota_metrics = self.get_google_cloud_quota_metrics(project_id)
        
        # Summary report
        print("\n" + "=" * 60)
        print("COMPREHENSIVE QUOTA REPORT")
        print("=" * 60)
        
        working_keys = [r for r in api_key_results if r['working']]
        quota_exceeded_keys = [r for r in api_key_results if r['quota_exceeded']]
        
        print(f"📊 API Key Status:")
        print(f"   Total keys: {len(self.api_keys)}")
        print(f"   ✅ Working: {len(working_keys)}")
        print(f"   🚫 Quota exceeded: {len(quota_exceeded_keys)}")
        print(f"   ⚠️ Other issues: {len(api_key_results) - len(working_keys) - len(quota_exceeded_keys)}")
        
        if working_keys:
            print(f"\n✅ Working keys:")
            for result in working_keys:
                print(f"   - Key #{result['key_index'] + 1}: {result['key_preview']}")
        
        if quota_exceeded_keys:
            print(f"\n🚫 Quota exceeded keys:")
            for result in quota_exceeded_keys:
                print(f"   - Key #{result['key_index'] + 1}: {result['key_preview']}")
        
        if quota_metrics:
            print(f"\n📊 Google Cloud project quota available")
        else:
            print(f"\n⚠️ Google Cloud quota metrics unavailable (requires gcloud auth)")
        
        print("=" * 60)
        
        return {
            'api_key_results': api_key_results,
            'quota_metrics': quota_metrics,
            'working_keys_count': len(working_keys),
            'quota_exceeded_count': len(quota_exceeded_keys),
            'total_keys': len(self.api_keys)
        }

    def _init_fallback_arrays(self):
        """
        Initialize fallback arrays for when Gemini API quota is exceeded
        Contains pre-defined haircut styles, descriptions, and placeholder images
        """
        self.fallback_recommendations = {
            'male': {
                'round': ["Modern Fade", "Textured Crop", "Side Part", "Classic Crew Cut"],
                'oval': ["Quiff Style", "Undercut Fade", "Pompadour", "Side Swept"],
                'long': ["Buzz Cut", "Short Crop", "Crew Cut", "Low Fade"],
                'square': ["Textured Fringe", "Messy Top", "Soft Undercut", "Layered Cut"]
            },
            'female': {
                'round': ["Long Layers", "Side-Swept Bangs", "Asymmetrical Bob", "Pixie with Volume"],
                'oval': ["Layered Bob", "Beach Waves", "Straight Lob", "Curtain Bangs"],
                'long': ["Blunt Bob", "Chin-Length Cut", "Side-Swept Pixie", "Short Waves"],
                'square': ["Soft Layers", "Long Bob", "Side Part Waves", "Wispy Bangs"]
            }
        }
        
        self.fallback_descriptions = {
            "Modern Fade": "A contemporary fade with gradual length transition, perfect for professional and casual looks.",
            "Textured Crop": "Short textured cut that's easy to style and maintain, ideal for busy lifestyles.",
            "Side Part": "Classic side-parted style with modern touches, timeless and sophisticated.",
            "Classic Crew Cut": "Traditional short cut that's neat and professional, suitable for all occasions.",
            "Quiff Style": "Voluminous quiff with modern styling, adds height and character to your look.",
            "Undercut Fade": "Trendy undercut with fade sides, combines edge with professionalism.",
            "Pompadour": "Classic pompadour with contemporary flair, bold and stylish statement.",
            "Side Swept": "Smooth side-swept style that's versatile and easy to maintain.",
            "Buzz Cut": "Ultra-short buzz cut that's low maintenance and always sharp.",
            "Short Crop": "Clean short crop that emphasizes facial features beautifully.",
            "Crew Cut": "Military-inspired crew cut that's practical and timeless.",
            "Low Fade": "Subtle low fade that blends seamlessly for a clean finish.",
            "Textured Fringe": "Modern fringe with texture, adds softness to angular features.",
            "Messy Top": "Stylishly messy top that looks effortless yet put-together.",
            "Soft Undercut": "Gentle undercut variation that's subtle and professional.",
            "Layered Cut": "Multi-layered cut that adds movement and dimension.",
            "Long Layers": "Flowing long layers that add movement and reduce bulk.",
            "Side-Swept Bangs": "Elegant side-swept bangs that complement round faces.",
            "Asymmetrical Bob": "Modern asymmetrical bob that's edgy yet sophisticated.",
            "Pixie with Volume": "Volumized pixie cut that adds height and dimension.",
            "Layered Bob": "Classic bob with layers for texture and movement.",
            "Beach Waves": "Natural-looking waves that give a relaxed, effortless vibe.",
            "Straight Lob": "Sleek long bob that's modern and versatile.",
            "Curtain Bangs": "Face-framing curtain bangs that suit most face shapes.",
            "Blunt Bob": "Sharp blunt bob that creates a strong, confident silhouette.",
            "Chin-Length Cut": "Perfect chin-length cut that balances longer face shapes.",
            "Side-Swept Pixie": "Feminine pixie with side-swept styling.",
            "Short Waves": "Textured short waves that add softness and movement.",
            "Soft Layers": "Gentle layers that soften angular features.",
            "Long Bob": "Elongated bob that's sophisticated and timeless.",
            "Side Part Waves": "Classic side-parted waves with modern appeal.",
            "Wispy Bangs": "Light, wispy bangs that add softness to strong jawlines."
        }
        
        # Fallback image placeholders (base64 encoded small placeholder images)
        # In production, these could be actual styled images
        self.fallback_image_placeholder = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjI0MCIgdmlld0JveD0iMCAwIDIwMCAyNDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjQwIiBmaWxsPSIjMUExQTFBIi8+CjxjaXJjbGUgY3g9IjEwMCIgY3k9IjgwIiByPSI0MCIgZmlsbD0iIzNBM0EzQSIvPgo8cGF0aCBkPSJNNjAgMTIwaDgwdjgwSDYweiIgZmlsbD0iIzJBMkEyQSIvPgo8dGV4dCB4PSIxMDAiIHk9IjIwMCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iI0VDUlUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxMiI+U3R5bGUgUHJldmlldyE8L3RleHQ+Cjwvc3ZnPgo="

    def _call_gemini_with_timeout(self, func, *args, timeout=15, **kwargs):
        """
        Call Gemini API with timeout protection and automatic key rotation on quota exceeded
        """
        max_retries = len(self.api_keys)  # Try all available keys
        
        for attempt in range(max_retries):
            if not self.model:  # No more keys available
                break
                
            try:
                with ThreadPoolExecutor(max_workers=1) as executor:
                    future = executor.submit(func, *args, **kwargs)
                    try:
                        result = future.result(timeout=timeout)
                        
                        # Check if response was blocked by safety filters
                        if hasattr(result, 'candidates') and result.candidates:
                            candidate = result.candidates[0]
                            if hasattr(candidate, 'finish_reason') and candidate.finish_reason == 2:
                                print("Gemini response blocked by safety filters, using fallback")
                                return None
                        
                        # Success! Return the result
                        return result
                        
                    except TimeoutError:
                        print(f"Gemini API call timed out after {timeout} seconds (Key #{self.current_key_index + 1})")
                        # Don't switch keys for timeout, just return None
                        return None
                        
            except Exception as e:
                error_msg = str(e)
                print(f"Gemini API call error (Key #{self.current_key_index + 1}): {error_msg}")
                
                # Check for quota exceeded error
                if self._is_quota_error(error_msg):
                    print(f"🚫 API key #{self.current_key_index + 1} quota exceeded!")
                    
                    # Mark current key as quota exceeded
                    self._mark_current_key_as_quota_exceeded()
                    
                    # Try to switch to next available key
                    if self._switch_to_next_available_key():
                        print(f"� Retrying with API key #{self.current_key_index + 1}...")
                        continue  # Retry with new key
                    else:
                        print("❌ All API keys exhausted, using fallback")
                        return None
                else:
                    # Non-quota error, don't switch keys
                    print(f"❌ Non-quota error with key #{self.current_key_index + 1}: {error_msg[:100]}...")
                    return None
        
        # All attempts failed
        print("❌ All API key attempts failed")
        return None

    def generate_image_with_rotation(self, prompt, face_image_data=None):
        """
        Generate image with automatic API key rotation on quota exceeded.
        Follows the pattern: try -> fail with quota -> mark as exceeded -> switch -> retry
        """
        if not self.api_keys:
            print("❌ No API keys available for image generation")
            return None
            
        max_attempts = len(self.api_keys)
        attempted_keys = set()
        
        for attempt in range(max_attempts):
            current_key_idx = self.current_key_index
            
            # Skip if this key is already known to be quota-exceeded
            if current_key_idx in self.quota_exceeded_keys:
                print(f"⏭️ Skipping API key #{current_key_idx + 1} (already quota-exceeded)")
                if not self._switch_to_next_available_key():
                    break
                continue
                
            # Skip if we already attempted this key in this session
            if current_key_idx in attempted_keys:
                print(f"⏭️ Skipping API key #{current_key_idx + 1} (already attempted)")
                if not self._switch_to_next_available_key():
                    break
                continue
                
            attempted_keys.add(current_key_idx)
            print(f"🎯 Attempting image generation with API key #{current_key_idx + 1}")
            
            try:
                # Try to generate image with current key
                result = self._attempt_image_generation(prompt, face_image_data)
                
                if result is not None:
                    print(f"✅ Image generation successful with API key #{current_key_idx + 1}")
                    return result
                else:
                    print(f"⚠️ Image generation returned None with API key #{current_key_idx + 1}")
                    # Continue to next key without marking as quota-exceeded
                    if not self._switch_to_next_available_key():
                        break
                    continue
                    
            except Exception as e:
                error_msg = str(e)
                print(f"❌ Image generation error with API key #{current_key_idx + 1}: {error_msg}")
                
                if self._is_quota_error(error_msg):
                    print(f"🚫 API key #{current_key_idx + 1} quota exceeded! Marking and switching...")
                    
                    # Mark current key as quota exceeded
                    self._mark_current_key_as_quota_exceeded()
                    
                    # Switch to next available key
                    if not self._switch_to_next_available_key():
                        print("❌ No more API keys available after quota exceeded")
                        break
                    
                    print(f"🔄 Switched to API key #{self.current_key_index + 1}, retrying...")
                    continue
                else:
                    print(f"❌ Non-quota error with API key #{current_key_idx + 1}: {error_msg[:100]}...")
                    # For non-quota errors, try next key without marking current as exceeded
                    if not self._switch_to_next_available_key():
                        break
                    continue
        
        print("❌ All API keys exhausted or failed for image generation")
        return None
    
    def _attempt_image_generation(self, prompt, face_image_data=None):
        """
        Attempt image generation with the current API key
        """
        if not self.client or not self.image_model_name:
            return None
            
        try:
            print(f"🎯 Attempting image generation with API key #{self.current_key_index + 1}")
            
            # Convert face image data to PIL Image if provided
            if face_image_data:
                original_image = Image.open(io.BytesIO(face_image_data))
                original_image = self._resize_image(original_image, max_size=512)
            else:
                original_image = None
            
            # Prepare content for the API call
            contents = [prompt]
            if original_image:
                contents.append(original_image)
            
            # Direct API call without the old timeout wrapper
            response = self.client.models.generate_content(
                model=self.image_model_name,
                contents=contents,
                config=types.GenerateContentConfig(
                    response_modalities=['TEXT', 'IMAGE']
                )
            )
            
            if response:
                print(f"✅ Got response from Gemini image generation API")
                
                # Process the response as per official documentation
                if response.candidates and response.candidates[0].content.parts:
                    for part in response.candidates[0].content.parts:
                        if part.text is not None:
                            print(f"📝 Text response: {part.text[:100]}...")
                        elif part.inline_data is not None:
                            # Found the generated image!
                            print(f"🖼️ Found generated image data!")
                            
                            # Convert the image data to base64 for frontend
                            image_data = part.inline_data.data
                            if isinstance(image_data, bytes):
                                img_b64 = base64.b64encode(image_data).decode()
                            else:
                                img_b64 = image_data
                            
                            # Determine mime type
                            mime_type = getattr(part.inline_data, 'mime_type', 'image/jpeg')
                            
                            print(f"✅ Successfully generated real image!")
                            return f"data:{mime_type};base64,{img_b64}"
                
                # If we get here, there's a text response but no image
                # This could still be considered a successful response
                print("📝 Got text response without image data")
                return "text_response"
            else:
                print("❌ No response from Gemini API")
                return None
                
        except Exception as e:
            # Re-raise the exception so the calling method can handle it
            print(f"🔥 Exception in image generation: {str(e)}")
            raise e
        
    def _get_fallback_recommendations(self, face_analysis):
        """
        Enhanced fallback recommendations using comprehensive rule-based logic and fallback arrays
        """
        if not face_analysis:
            # Default fallback when no face analysis available
            return ["Modern Fade", "Textured Crop", "Side Part", "Classic Crew Cut"]
            
        face_shape = face_analysis.get('face_shape', 'oval')
        gender = face_analysis.get('gender', 'Male').lower()
        
        # Normalize gender
        if gender not in ['male', 'female']:
            gender = 'male'  # Default fallback
            
        # Get recommendations from fallback arrays
        gender_recommendations = self.fallback_recommendations.get(gender, {})
        shape_recommendations = gender_recommendations.get(face_shape, [])
        
        # If no specific recommendations for this face shape, use oval as default
        if not shape_recommendations:
            shape_recommendations = gender_recommendations.get('oval', [])
            
        # If still no recommendations, use generic fallback
        if not shape_recommendations:
            if gender == 'male':
                shape_recommendations = ["Blowout Taper", "Fringe Haircut", "Long Fringe", "Messy Fringe", "Taper", "Mid Fade", "Low Taper", "Modern Fade", "Textured Crop", "Side Part", "Classic Crew Cut"]
            else:
                shape_recommendations = ["Layered Bob", "Beach Waves", "Straight Lob", "Curtain Bangs"]
        
        # Ensure we have exactly 4 recommendations
        recommendations = shape_recommendations[:4]
        
        # If we don't have 4, pad with additional generic ones
        if len(recommendations) < 4:
            additional = ["Stylish Cut", "Modern Style", "Classic Look", "Trendy Cut"]
            for add_rec in additional:
                if add_rec not in recommendations and len(recommendations) < 4:
                    recommendations.append(add_rec)
        
        print(f"🔄 Using fallback recommendations for {gender} with {face_shape} face: {recommendations}")
        return recommendations[:4]  # Return exactly 4 recommendations
    
    def generate_haircut_recommendations(self, face_analysis):
        """
        Generate haircut recommendations based on face analysis using AI or fallback to rule-based logic
        """
        try:
            if not face_analysis:
                print("⚠️ No face analysis provided, using fallback recommendations")
                return self._get_fallback_recommendations(face_analysis)
            
            face_shape = face_analysis.get('face_shape', 'oval')
            gender = face_analysis.get('gender', 'Male')
            age_range = face_analysis.get('age_range', {})
            
            # Create AI prompt for personalized recommendations
            prompt = f"""
            Based on the following face analysis, recommend exactly 4 modern and trendy haircut styles:
            
            Face Shape: {face_shape}
            Gender: {gender}
            Age Range: {age_range.get('Low', 20)}-{age_range.get('High', 30)} years
            
            Please provide 4 haircut style names that would complement this face shape and are appropriate for someone of this gender and age.
            Only return the style names, separated by commas, nothing else.
            
            Examples of good style names: "Blowout Taper", "Modern Fade", "Textured Crop", "Side Part", "Long Fringe", "Beach Waves", "Layered Bob"
            """
            
            # Try to generate AI recommendations with rotation support
            print(f"🧠 Generating AI recommendations for {gender} with {face_shape} face...")
            
            try:
                # Use the existing AI generation with rotation logic
                response = self._call_gemini_with_timeout(
                    lambda: self.model.generate_content(prompt), 
                    timeout=10
                )
                
                if response and response.text:
                    # Parse the response to get style names
                    styles_text = response.text.strip()
                    styles = [style.strip().strip('"\'') for style in styles_text.split(',')]
                    styles = [style for style in styles if style and len(style) > 2]  # Filter valid styles
                    
                    if len(styles) >= 4:
                        print(f"✅ AI generated {len(styles)} recommendations: {styles[:4]}")
                        return styles[:4]
                    else:
                        print(f"⚠️ AI generated only {len(styles)} styles, using fallback")
                        fallbacks = self._get_fallback_recommendations(face_analysis)
                        # Combine AI suggestions with fallbacks
                        combined = styles + fallbacks
                        return list(dict.fromkeys(combined))[:4]  # Remove duplicates and limit to 4
                        
            except Exception as ai_error:
                print(f"❌ AI recommendation error: {ai_error}")
                # Continue to fallback
            
            # Fallback to rule-based recommendations
            print("🔄 Using fallback recommendations due to AI error")
            return self._get_fallback_recommendations(face_analysis)
            
        except Exception as e:
            print(f"❌ Error in generate_haircut_recommendations: {e}")
            return self._get_fallback_recommendations(face_analysis)
    
    def generate_style_variations(self, face_analysis, preferred_style):
        """
        Generate variations of a specific preferred haircut style using Gemini AI
        """
        # Check if any model is available (any API key not exhausted)
        if not self.model:
            print("🔄 Using fallback variations - all API keys exhausted")
            return self._get_fallback_style_variations(preferred_style)
            
        try:
            face_shape = face_analysis.get('face_shape', 'oval')
            gender = face_analysis.get('gender', 'Male').lower()
            age_range = face_analysis.get('age_range', {})
            avg_age = (age_range.get('Low', 25) + age_range.get('High', 35)) / 2
            
            # Specialized prompt for generating variations of the preferred style
            prompt = f"""
            Professional hairstylist creating variations of "{preferred_style}" for:
            - Face: {face_shape}
            - Gender: {gender}  
            - Age: {avg_age:.0f}
            
            List exactly 4 variations of "{preferred_style}" that would suit this person. Include different lengths, fades, and styling options.
            
            For example, if "{preferred_style}" is "Blowout Taper":
            - Low Taper Blowout
            - Mid Taper Blowout
            - High Taper Blowout
            - Textured Blowout Fade
            
            Or if "{preferred_style}" is "Fade":
            - Low Fade
            - Mid Fade  
            - High Fade
            - Skin Fade
            
            Provide one variation per line, no descriptions. Make them specific to "{preferred_style}".
            """
            
            print(f"Generating {preferred_style} variations with Gemini (Key #{self.current_key_index + 1})...")
            
            # Use timeout wrapper with automatic key rotation
            response = self._call_gemini_with_timeout(
                self.model.generate_content,
                prompt,
                generation_config=genai.types.GenerationConfig(
                    max_output_tokens=150,  # Slightly more tokens for variations
                    temperature=0.7
                ),
                safety_settings={
                    genai.types.HarmCategory.HARM_CATEGORY_HATE_SPEECH: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_HARASSMENT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_SEXUALLY_EXPLICIT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_DANGEROUS_CONTENT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                },
                timeout=20
            )
            
            if response and hasattr(response, 'text') and response.text:
                # Parse the response into a list
                variations = [line.strip().strip('"').strip("'") for line in response.text.strip().split('\n') if line.strip()]
                variations = [var for var in variations if var and not var.startswith('-')]  # Clean up
                
                # Ensure we have exactly 4 variations
                if len(variations) >= 4:
                    return variations[:4]
                else:
                    # Pad with fallback variations if needed
                    fallbacks = self._get_fallback_style_variations(preferred_style)
                    while len(variations) < 4:
                        for fallback in fallbacks:
                            if fallback not in variations:
                                variations.append(fallback)
                                break
                    return variations[:4]
            else:
                print("⚠️ No valid response from Gemini, using fallback variations")
                return self._get_fallback_style_variations(preferred_style)
            
        except Exception as e:
            print(f"❌ Error in generate_style_variations: {str(e)}")
            return self._get_fallback_style_variations(preferred_style)
    
    def _get_fallback_style_variations(self, preferred_style):
        """
        Generate fallback variations for a preferred style when AI is unavailable
        """
        style_lower = preferred_style.lower()
        
        # Define common variations for popular styles
        style_variations = {
            'blowout': ['Low Taper Blowout', 'Mid Taper Blowout', 'High Taper Blowout', 'Textured Blowout'],
            'taper': ['Low Taper', 'Mid Taper', 'High Taper', 'Skin Taper'],
            'fade': ['Low Fade', 'Mid Fade', 'High Fade', 'Skin Fade'],
            'fringe': ['Textured Fringe', 'Side Swept Fringe', 'Long Fringe', 'Choppy Fringe'],
            'undercut': ['Disconnected Undercut', 'Side Part Undercut', 'Slicked Back Undercut', 'Textured Undercut'],
            'pompadour': ['Classic Pompadour', 'Modern Pompadour', 'Side Part Pompadour', 'Textured Pompadour'],
            'crew': ['Classic Crew Cut', 'Ivy League', 'Butch Cut', 'Buzz Cut'],
            'quiff': ['Textured Quiff', 'Side Part Quiff', 'Modern Quiff', 'Voluminous Quiff'],
            'crop': ['Textured Crop', 'Caesar Crop', 'French Crop', 'Messy Crop'],
            'buzz': ['Buzz Cut #1', 'Buzz Cut #2', 'Buzz Cut #3', 'Induction Cut'],
            'mohawk': ['Classic Mohawk', 'Faux Hawk', 'Curly Mohawk', 'Fade Mohawk'],
            'bob': ['Classic Bob', 'Layered Bob', 'Angled Bob', 'Textured Bob'],
            'layers': ['Long Layers', 'Short Layers', 'Face Framing Layers', 'Choppy Layers'],
            'bangs': ['Straight Bangs', 'Side Bangs', 'Curtain Bangs', 'Wispy Bangs'],
            'waves': ['Beach Waves', 'Loose Waves', 'Tight Waves', 'Natural Waves']
        }
        
        # Find matching variations
        for key, variations in style_variations.items():
            if key in style_lower:
                return variations
        
        # If no specific variations found, create generic ones based on the preferred style
        return [
            f"Classic {preferred_style}",
            f"Modern {preferred_style}",
            f"Textured {preferred_style}",
            f"Styled {preferred_style}"
        ]
    
    def generate_haircut_description(self, haircut_style):
        """
        Generate brief description for a haircut using optimized Gemini with multi-key fallback
        """
        # Check if any model is available (any API key not exhausted)
        if not self.model:
            return self._get_fallback_description(haircut_style)
            
        try:
            # Simplified prompt for faster processing
            prompt = f"""
            Brief 1-sentence description for "{haircut_style}" haircut.
            Include style appeal and who it suits.
            Keep under 20 words.
            """
            
            # Use timeout wrapper with automatic key rotation
            response = self._call_gemini_with_timeout(
                self.model.generate_content,
                prompt,
                generation_config=genai.types.GenerationConfig(
                    max_output_tokens=50,  # Very short for speed
                    temperature=0.7
                ),
                safety_settings={
                    genai.types.HarmCategory.HARM_CATEGORY_HATE_SPEECH: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_HARASSMENT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_SEXUALLY_EXPLICIT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                    genai.types.HarmCategory.HARM_CATEGORY_DANGEROUS_CONTENT: genai.types.HarmBlockThreshold.BLOCK_NONE,
                },
                timeout=15
            )
            
            if response and hasattr(response, 'text') and response.text:
                return response.text.strip()
            else:
                print("⚠️ No valid response from Gemini, using fallback")
                
        except Exception as e:
            print(f"❌ Error in generate_haircut_description: {str(e)}")
        
        return self._get_fallback_description(haircut_style)
    
    def _get_fallback_description(self, haircut_style):
        """
        Enhanced fallback descriptions using comprehensive description array
        """
        # Try to get description from fallback array first
        if haircut_style in self.fallback_descriptions:
            return self.fallback_descriptions[haircut_style]
        
        # Try case-insensitive match
        for style, description in self.fallback_descriptions.items():
            if style.lower() == haircut_style.lower():
                return description
        
        # Try partial match
        for style, description in self.fallback_descriptions.items():
            if any(word in style.lower() for word in haircut_style.lower().split()):
                return description
        
        # Generic fallback based on keywords
        haircut_lower = haircut_style.lower()
        if any(word in haircut_lower for word in ['fade', 'cut']):
            return f"A stylish {haircut_style} that complements your face shape and personal style."
        elif any(word in haircut_lower for word in ['bob', 'lob']):
            return f"A modern {haircut_style} that's versatile and easy to style."
        elif any(word in haircut_lower for word in ['layer', 'wave']):
            return f"A textured {haircut_style} that adds movement and dimension to your look."
        elif any(word in haircut_lower for word in ['pixie', 'short']):
            return f"A chic {haircut_style} that's low maintenance yet stylish."
        else:
            return f"A contemporary {haircut_style} that suits your unique features and lifestyle."
    
    def generate_haircut_image_with_gemini(self, original_image_bytes, haircut_style, face_analysis=None):
        """
        Generate REAL haircut transformation image using Google Genai API with proper key rotation
        """
        # Check if any client is available (any API key not exhausted)
        if not self.client or not self.image_model_name:
            print("🔄 Using fallback image generation - no API keys available")
            return self._create_fallback_image(original_image_bytes, haircut_style)
            
        try:
            # Convert image bytes to PIL Image
            original_image = Image.open(io.BytesIO(original_image_bytes))
            original_image = self._resize_image(original_image, max_size=512)
            
            print(f"🎨 Starting REAL image transformation for: {haircut_style}")
            
            # Determine appropriate age from face analysis
            age_info = ""
            if face_analysis and 'age_range' in face_analysis:
                age_low = face_analysis['age_range'].get('Low', 25)
                age_high = face_analysis['age_range'].get('High', 35)
                avg_age = (age_low + age_high) // 2
                age_info = f" Make the haircut style appropriate for someone around {avg_age} years old."
            
            # Enhanced prompt that preserves facial features
            text_input = (
                f"OBJECTIVE: Change only the haircut to {haircut_style}. "
                
                f"PRESERVE EXACTLY: "
                f"Face shape, facial structure, eyes, nose, mouth, lips, eyebrows, "
                f"facial expressions, skin tone, any facial markings, background, "
                f"lighting, image composition, all objects in scene. "
                
                f"CHANGE ONLY: Haircut/hairstyle to {haircut_style}. "
                f"Make the new hairstyle look natural and realistic for this person. "
                f"Keep original hair color. Consider face shape. "
                
                f"{age_info} "
                
                f"QUALITY: Photorealistic result, seamless blending, "
                f"consistent lighting, professionally styled hair."
            )
            
            print(f"📝 Using enhanced prompt: {text_input[:100]}...")
            
            # Use the new rotation method for image generation
            result = self.generate_image_with_rotation(text_input, original_image_bytes)
            
            if result:
                # Try to parse the result as image data
                try:
                    # If the result contains image data, process it
                    if 'data:' in result:
                        print(f"✅ Successfully generated real image with API key #{self.current_key_index + 1}!")
                        return result
                    else:
                        # Result might be text, need to handle differently
                        print("📝 Got text response, using fallback image")
                        return self._create_fallback_image(original_image_bytes, haircut_style)
                except:
                    print("⚠️ Could not parse image result, using fallback")
                    return self._create_fallback_image(original_image_bytes, haircut_style)
            else:
                print("⚠️ No result from image generation, using fallback")
                return self._create_fallback_image(original_image_bytes, haircut_style)
            
        except Exception as e:
            error_msg = str(e)
            print(f"❌ Error in generate_haircut_image_with_gemini: {error_msg}")
            print("🔄 Falling back to placeholder image")
            return self._create_fallback_image(original_image_bytes, haircut_style)
            
    def _create_fallback_image(self, original_image_bytes, haircut_style):
        """
        Create a fallback image when quota is exceeded or API is unavailable
        """
        try:
            # Try to create an enhanced preview first
            preview = self._create_ai_enhanced_preview(original_image_bytes, haircut_style, f"Style Preview: {haircut_style}")
            if preview:
                return preview
        except Exception as e:
            print(f"Enhanced preview failed: {str(e)}")
        
        # Last resort: return a placeholder with style information
        return self.fallback_image_placeholder
    
    def _generate_image_from_prompt(self, prompt, original_image_bytes, haircut_style):
        """
        Generate actual image using the Gemini-created prompt
        """
        try:
            # Try multiple image generation methods
            
            # Method 1: Try Hugging Face text-to-image with the detailed prompt
            print("🎨 Attempting image generation with Hugging Face...")
            hf_result = self._try_huggingface_image_generation(prompt, haircut_style)
            if hf_result:
                return hf_result
            
            # Method 2: Try creating a more sophisticated preview with AI prompt
            print("🎨 Creating AI-enhanced style preview...")
            return self._create_ai_enhanced_preview(original_image_bytes, haircut_style, prompt)
            
        except Exception as e:
            print(f"Image generation error: {str(e)}")
            return None
    
    def _try_huggingface_image_generation(self, prompt, haircut_style):
        """
        Try to generate image using Hugging Face models
        """
        try:
            # List of working image generation models
            models_to_try = [
                "stabilityai/stable-diffusion-xl-base-1.0",
                "runwayml/stable-diffusion-v1-5",
                "CompVis/stable-diffusion-v1-4"
            ]
            
            headers = {
                "Authorization": f"Bearer {os.getenv('HUGGINGFACE_TOKEN', '')}",
                "Content-Type": "application/json"
            }
            
            # Enhanced prompt for better results
            enhanced_prompt = f"{prompt}, professional headshot, studio lighting, 4K quality, detailed hair texture"
            
            for model_id in models_to_try:
                try:
                    api_url = f"https://api-inference.huggingface.co/models/{model_id}"
                    
                    payload = {
                        "inputs": enhanced_prompt,
                        "parameters": {
                            "guidance_scale": 8.0,
                            "num_inference_steps": 30,
                            "width": 512,
                            "height": 512
                        }
                    }
                    
                    print(f"🔄 Trying {model_id}...")
                    response = requests.post(api_url, headers=headers, json=payload, timeout=60)
                    
                    if response.status_code == 200:
                        content_type = response.headers.get('content-type', '')
                        if 'image' in content_type:
                            # Convert to base64
                            img_b64 = base64.b64encode(response.content).decode()
                            print(f"✅ Successfully generated image with {model_id}")
                            return f"data:image/jpeg;base64,{img_b64}"
                    elif response.status_code == 503:
                        print(f"⏳ Model {model_id} loading, waiting...")
                        time.sleep(20)
                        response = requests.post(api_url, headers=headers, json=payload, timeout=80)
                        if response.status_code == 200 and 'image' in response.headers.get('content-type', ''):
                            img_b64 = base64.b64encode(response.content).decode()
                            return f"data:image/jpeg;base64,{img_b64}"
                    
                    print(f"❌ {model_id} failed: {response.status_code}")
                    
                except Exception as model_error:
                    print(f"❌ {model_id} error: {str(model_error)[:50]}...")
                    continue
            
            print("❌ All Hugging Face models failed")
            return None
            
        except Exception as e:
            print(f"Hugging Face generation error: {str(e)}")
            return None
    
    def _create_ai_enhanced_preview(self, original_image_bytes, haircut_style, ai_prompt):
        """
        Create a sophisticated preview that shows the AI's vision of the haircut
        """
        try:
            from PIL import ImageDraw, ImageFont, ImageFilter, ImageEnhance
            
            # Open original image
            image = Image.open(io.BytesIO(original_image_bytes))
            image = self._resize_image(image, max_size=512)
            
            # Create a more dramatic transformation preview
            preview_image = image.copy()
            
            # Apply more noticeable enhancements to suggest transformation
            enhancer = ImageEnhance.Contrast(preview_image)
            preview_image = enhancer.enhance(1.2)  # More contrast
            
            enhancer = ImageEnhance.Sharpness(preview_image)
            preview_image = enhancer.enhance(1.3)  # Sharper
            
            enhancer = ImageEnhance.Color(preview_image)
            preview_image = enhancer.enhance(1.1)  # Slightly more vibrant
            
            draw = ImageDraw.Draw(preview_image)
            
            # Add sophisticated text overlay showing AI analysis
            try:
                title_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 20)
                subtitle_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 12)
                detail_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 10)
            except:
                title_font = ImageFont.load_default()
                subtitle_font = ImageFont.load_default() 
                detail_font = ImageFont.load_default()
            
            # Create multi-line text layout
            title_text = f"{haircut_style.title()}"
            subtitle_text = "🤖 AI-Analyzed Transformation"
            
            # Extract key details from AI prompt for display
            prompt_words = ai_prompt.lower().split()
            key_features = []
            feature_keywords = ['short', 'long', 'layered', 'textured', 'modern', 'classic', 'fade', 'undercut', 'bob', 'pixie', 'waves']
            for keyword in feature_keywords:
                if keyword in prompt_words:
                    key_features.append(keyword.title())
            
            detail_text = f"Features: {', '.join(key_features[:3])}" if key_features else "Professional Styling"
            
            # Calculate positions
            title_bbox = draw.textbbox((0, 0), title_text, font=title_font)
            subtitle_bbox = draw.textbbox((0, 0), subtitle_text, font=subtitle_font)
            detail_bbox = draw.textbbox((0, 0), detail_text, font=detail_font)
            
            max_width = max(title_bbox[2] - title_bbox[0], subtitle_bbox[2] - subtitle_bbox[0], detail_bbox[2] - detail_bbox[0])
            total_height = (title_bbox[3] - title_bbox[1]) + (subtitle_bbox[3] - subtitle_bbox[1]) + (detail_bbox[3] - detail_bbox[1]) + 25
            
            x = (image.width - max_width) // 2
            y = image.height - total_height - 30
            
            # Create premium AI-themed background
            padding = 25
            bg_x1 = x - padding
            bg_y1 = y - padding  
            bg_x2 = x + max_width + padding
            bg_y2 = y + total_height + padding
            
            # Draw AI-themed background
            overlay = Image.new('RGBA', image.size, (0, 0, 0, 0))
            overlay_draw = ImageDraw.Draw(overlay)
            
            # Gradient background with AI theme
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y2], fill=(15, 23, 42, 200))  # Dark slate
            
            # AI accent bars (purple/blue theme)
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y1 + 3], fill=(139, 92, 246, 255))  # Purple
            overlay_draw.rectangle([bg_x1, bg_y2 - 3, bg_x2, bg_y2], fill=(59, 130, 246, 255))   # Blue
            
            # Corner accents 
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x1 + 3, bg_y1 + 15], fill=(139, 92, 246, 255))
            overlay_draw.rectangle([bg_x2 - 3, bg_y1, bg_x2, bg_y1 + 15], fill=(139, 92, 246, 255))
            
            # Composite the overlay
            preview_image = Image.alpha_composite(preview_image.convert('RGBA'), overlay)
            preview_image = preview_image.convert('RGB')
            draw = ImageDraw.Draw(preview_image)
            
            # Draw text with AI theme
            title_x = x + (max_width - (title_bbox[2] - title_bbox[0])) // 2
            draw.text((title_x, y), title_text, font=title_font, fill=(255, 255, 255))
            
            subtitle_x = x + (max_width - (subtitle_bbox[2] - subtitle_bbox[0])) // 2
            subtitle_y = y + (title_bbox[3] - title_bbox[1]) + 8
            draw.text((subtitle_x, subtitle_y), subtitle_text, font=subtitle_font, fill=(139, 92, 246))
            
            detail_x = x + (max_width - (detail_bbox[2] - detail_bbox[0])) // 2
            detail_y = subtitle_y + (subtitle_bbox[3] - subtitle_bbox[1]) + 6
            draw.text((detail_x, detail_y), detail_text, font=detail_font, fill=(156, 163, 175))
            
            # Convert back to bytes
            img_buffer = io.BytesIO()
            preview_image.save(img_buffer, format='JPEG', quality=95)
            
            # Return as base64
            img_b64 = base64.b64encode(img_buffer.getvalue()).decode()
            return f"data:image/jpeg;base64,{img_b64}"
            
        except Exception as e:
            print(f"AI enhanced preview error: {str(e)}")
            return self._create_enhanced_style_preview(original_image_bytes, haircut_style, ai_prompt)
    
    def _create_enhanced_style_preview(self, original_image_bytes, haircut_style, ai_prompt):
        """
        Create an enhanced style preview with AI analysis
        """
        try:
            from PIL import ImageDraw, ImageFont, ImageFilter, ImageEnhance
            
            # Open original image
            image = Image.open(io.BytesIO(original_image_bytes))
            image = self._resize_image(image, max_size=512)
            
            # Create a copy to draw on
            preview_image = image.copy()
            
            # Apply a subtle enhancement to indicate AI analysis
            enhancer = ImageEnhance.Contrast(preview_image)
            preview_image = enhancer.enhance(1.1)  # Slightly more contrast
            
            enhancer = ImageEnhance.Sharpness(preview_image)
            preview_image = enhancer.enhance(1.1)  # Slightly sharper
            
            draw = ImageDraw.Draw(preview_image)
            
            # Add enhanced style text overlay
            try:
                title_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 24)
                subtitle_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 14)
                detail_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 12)
            except:
                title_font = ImageFont.load_default()
                subtitle_font = ImageFont.load_default()
                detail_font = ImageFont.load_default()
            
            # Create enhanced text layout
            title_text = haircut_style.title()
            subtitle_text = "AI-Analyzed Style"
            detail_text = "✨ Personalized Recommendation"
            
            # Calculate text dimensions
            title_bbox = draw.textbbox((0, 0), title_text, font=title_font)
            subtitle_bbox = draw.textbbox((0, 0), subtitle_text, font=subtitle_font)
            detail_bbox = draw.textbbox((0, 0), detail_text, font=detail_font)
            
            title_width = title_bbox[2] - title_bbox[0]
            title_height = title_bbox[3] - title_bbox[1]
            subtitle_width = subtitle_bbox[2] - subtitle_bbox[0]
            subtitle_height = subtitle_bbox[3] - subtitle_bbox[1]
            detail_width = detail_bbox[2] - detail_bbox[0]
            detail_height = detail_bbox[3] - detail_bbox[1]
            
            # Position with enhanced layout
            max_width = max(title_width, subtitle_width, detail_width)
            total_height = title_height + subtitle_height + detail_height + 20
            
            x = (image.width - max_width) // 2
            y = image.height - total_height - 25
            
            # Create premium background effect
            padding = 25
            bg_x1 = x - padding
            bg_y1 = y - padding
            bg_x2 = x + max_width + padding
            bg_y2 = y + total_height + padding
            
            # Draw enhanced background
            overlay = Image.new('RGBA', image.size, (0, 0, 0, 0))
            overlay_draw = ImageDraw.Draw(overlay)
            
            # Gradient-style background
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y2], 
                                 fill=(0, 0, 0, 190))
            
            # Premium accent bars
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y1 + 3], 
                                 fill=(34, 197, 94, 255))  # Green accent
            overlay_draw.rectangle([bg_x1, bg_y2 - 3, bg_x2, bg_y2], 
                                 fill=(34, 197, 94, 255))  # Green accent
            
            # Composite the overlay
            preview_image = Image.alpha_composite(preview_image.convert('RGBA'), overlay)
            preview_image = preview_image.convert('RGB')
            draw = ImageDraw.Draw(preview_image)
            
            # Draw enhanced text
            title_x = x + (max_width - title_width) // 2
            draw.text((title_x, y), title_text, font=title_font, fill=(255, 255, 255))
            
            subtitle_x = x + (max_width - subtitle_width) // 2
            subtitle_y = y + title_height + 8
            draw.text((subtitle_x, subtitle_y), subtitle_text, font=subtitle_font, fill=(34, 197, 94))
            
            detail_x = x + (max_width - detail_width) // 2
            detail_y = subtitle_y + subtitle_height + 6
            draw.text((detail_x, detail_y), detail_text, font=detail_font, fill=(200, 200, 200))
            
            # Convert back to bytes
            img_buffer = io.BytesIO()
            preview_image.save(img_buffer, format='JPEG', quality=95)
            
            # Return as base64
            img_b64 = base64.b64encode(img_buffer.getvalue()).decode()
            return f"data:image/jpeg;base64,{img_b64}"
            
        except Exception as e:
            print(f"Enhanced preview creation error: {str(e)}")
            return self._create_style_preview(original_image_bytes, haircut_style)
    
    def _create_ai_enhanced_preview(self, original_image_bytes, haircut_style, ai_description):
        """
        Create an enhanced preview with AI-generated styling description overlay
        """
        try:
            from PIL import ImageDraw, ImageFont, ImageFilter, ImageEnhance
            
            # Open and process the original image
            original_image = Image.open(io.BytesIO(original_image_bytes))
            original_image = self._resize_image(original_image, max_size=800)
            
            # Create enhanced version with better contrast and saturation
            enhancer = ImageEnhance.Contrast(original_image)
            enhanced = enhancer.enhance(1.2)
            enhancer = ImageEnhance.Color(enhanced)
            enhanced = enhancer.enhance(1.1)
            
            # Add subtle blur to background areas (keeping face sharp)
            width, height = enhanced.size
            
            # Create overlay for styling information
            overlay = Image.new('RGBA', (width, height), (0, 0, 0, 0))
            draw = ImageDraw.Draw(overlay)
            
            # Style title
            title_text = f"AI-Styled: {haircut_style}"
            
            # Try to load a font, fallback to default
            try:
                title_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 28)
                desc_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 16)
            except:
                title_font = ImageFont.load_default()
                desc_font = ImageFont.load_default()
            
            # Calculate text positioning
            title_bbox = draw.textbbox((0, 0), title_text, font=title_font)
            title_width = title_bbox[2] - title_bbox[0]
            title_x = (width - title_width) // 2
            
            # Draw semi-transparent background for text
            padding = 15
            bg_y = height - 120
            draw.rectangle(
                [0, bg_y, width, height],
                fill=(0, 0, 0, 140)
            )
            
            # Draw title text
            draw.text(
                (title_x, bg_y + padding),
                title_text,
                font=title_font,
                fill=(255, 255, 255, 255)
            )
            
            # Draw AI description (truncated)
            desc_text = ai_description[:150] + "..." if len(ai_description) > 150 else ai_description
            desc_lines = []
            words = desc_text.split()
            current_line = []
            max_width = width - 40
            
            for word in words:
                test_line = ' '.join(current_line + [word])
                test_bbox = draw.textbbox((0, 0), test_line, font=desc_font)
                if test_bbox[2] - test_bbox[0] <= max_width:
                    current_line.append(word)
                else:
                    if current_line:
                        desc_lines.append(' '.join(current_line))
                        current_line = [word]
                    if len(desc_lines) >= 3:  # Limit to 3 lines
                        break
            
            if current_line and len(desc_lines) < 3:
                desc_lines.append(' '.join(current_line))
            
            # Draw description lines
            for i, line in enumerate(desc_lines):
                draw.text(
                    (20, bg_y + padding + 35 + i * 18),
                    line,
                    font=desc_font,
                    fill=(200, 200, 200, 255)
                )
            
            # Composite the overlay
            result = Image.alpha_composite(enhanced.convert('RGBA'), overlay)
            result = result.convert('RGB')
            
            # Convert to base64
            output_buffer = io.BytesIO()
            result.save(output_buffer, format='JPEG', quality=85, optimize=True)
            img_bytes = output_buffer.getvalue()
            img_b64 = base64.b64encode(img_bytes).decode()
            
            return f"data:image/jpeg;base64,{img_b64}"
            
        except Exception as e:
            print(f"Enhanced preview creation error: {str(e)}")
            # Return original image if enhancement fails
            img_b64 = base64.b64encode(original_image_bytes).decode()
            return f"data:image/jpeg;base64,{img_b64}"
    
    def generate_haircut_image(self, original_image_bytes, haircut_style):
        """
        Generate haircut image using Hugging Face free API
        """
        try:
            print(f"Generating image for haircut: {haircut_style}")
            
            # Use the only working model we confirmed
            result = self._try_text_to_image_model("stabilityai/stable-diffusion-xl-base-1.0", haircut_style)
            if result:
                print(f"Successfully generated with stable-diffusion-xl-base-1.0")
                return result
            
            print(f"AI generation failed for {haircut_style}, using fallback")
            return None
            
        except Exception as e:
            print(f"Hair generation error: {str(e)}")
            return None
    
    def _try_hair_editing_model(self, image_bytes, haircut_style):
        """
        Try the instruct-pix2pix model for hair editing
        """
        try:
            # Skip if no token available
            if not self.hf_token:
                print("Skipping hair editing model - no HuggingFace token available")
                return None
                
            model_id = self.models['hair_editing']
            api_url = self.hf_api_url + model_id
            
            # Convert image to base64
            image_b64 = base64.b64encode(image_bytes).decode()
            
            # Create specific instruction for hair editing
            instruction = f"Change this person's hairstyle to a {haircut_style}. Keep the face and everything else exactly the same, only modify the hair. Make it look natural and professional."
            
            payload = {
                "inputs": {
                    "image": image_b64,
                    "prompt": instruction
                },
                "parameters": {
                    "guidance_scale": 7.5,
                    "image_guidance_scale": 1.2,
                    "num_inference_steps": 25
                }
            }
            
            print(f"Sending hair editing request: {instruction}")
            response = requests.post(api_url, headers=self.headers, json=payload, timeout=90)
            
            print(f"Hair editing response: {response.status_code}")
            
            if response.status_code == 200:
                content_type = response.headers.get('content-type', '')
                if 'image' in content_type:
                    return response.content
            elif response.status_code == 503:
                print("Hair editing model loading, waiting...")
                time.sleep(20)
                response = requests.post(api_url, headers=self.headers, json=payload, timeout=120)
                if response.status_code == 200 and 'image' in response.headers.get('content-type', ''):
                    return response.content
            
            print(f"Hair editing failed: {response.status_code} - {response.text[:200]}")
            return None
            
        except Exception as e:
            print(f"Hair editing model error: {str(e)}")
            return None
    
    def _try_text_to_image_model(self, model_id, haircut_style):
        """
        Try text-to-image models for haircut generation
        """
        try:
            # Skip if no token available
            if not self.hf_token:
                print(f"Skipping {model_id} - no HuggingFace token available")
                return None
                
            api_url = self.hf_api_url + model_id
            
            # Create specialized prompts based on the model
            if "hairClip" in model_id:
                # More specific prompt for hair models
                prompt = f"A person with a {haircut_style}, professional haircut, realistic hair texture, clean styling, modern barbershop quality"
            else:
                # General prompt for other models
                prompt = f"Professional headshot portrait of a person with {haircut_style} haircut, realistic lighting, detailed hair texture, high quality photography, studio portrait, clean background, 4k"
            
            payload = {
                "inputs": prompt,
                "parameters": {
                    "guidance_scale": 7.5,
                    "num_inference_steps": 30,
                    "width": 512,
                    "height": 512
                }
            }
            
            print(f"Trying API: {api_url}")
            print(f"Prompt: {prompt}")
            
            response = requests.post(api_url, headers=self.headers, json=payload, timeout=90)
            
            print(f"Response status: {response.status_code}")
            
            if response.status_code == 200:
                content_type = response.headers.get('content-type', '')
                print(f"Content type: {content_type}")
                if 'image' in content_type:
                    return response.content
                else:
                    print(f"Expected image but got: {response.text[:200]}")
            elif response.status_code == 503:
                print("Model loading, waiting 20 seconds...")
                time.sleep(20)
                response = requests.post(api_url, headers=self.headers, json=payload, timeout=120)
                if response.status_code == 200 and 'image' in response.headers.get('content-type', ''):
                    return response.content
            else:
                print(f"API Error {response.status_code}: {response.text[:200]}")
                    
            return None
            
        except Exception as e:
            print(f"Text-to-image model error for {model_id}: {str(e)}")
            return None
    
    def _resize_image(self, image, max_size=512):
        """
        Resize image while maintaining aspect ratio
        """
        width, height = image.size
        
        if max(width, height) <= max_size:
            return image
            
        if width > height:
            new_width = max_size
            new_height = int(height * (max_size / width))
        else:
            new_height = max_size
            new_width = int(width * (max_size / height))
            
        return image.resize((new_width, new_height), Image.Resampling.LANCZOS)
    
    def _create_style_preview(self, original_image_bytes, haircut_style):
        """
        Create a professional style preview by adding styled text overlay to the original image
        """
        try:
            from PIL import ImageDraw, ImageFont, ImageFilter, ImageEnhance
            
            # Open original image
            image = Image.open(io.BytesIO(original_image_bytes))
            image = self._resize_image(image, max_size=512)
            
            # Create a copy to draw on
            preview_image = image.copy()
            
            # Apply a subtle filter to indicate it's a preview
            enhancer = ImageEnhance.Brightness(preview_image)
            preview_image = enhancer.enhance(1.1)  # Slightly brighter
            
            draw = ImageDraw.Draw(preview_image)
            
            # Add style text overlay with better design
            try:
                # Try to use a nice font if available
                title_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 28)
                subtitle_font = ImageFont.truetype("/System/Library/Fonts/Helvetica.ttc", 16)
            except:
                # Fallback to default font
                title_font = ImageFont.load_default()
                subtitle_font = ImageFont.load_default()
            
            # Create stylish text layout
            title_text = haircut_style.title()
            subtitle_text = "Style Preview"
            
            # Calculate text dimensions
            title_bbox = draw.textbbox((0, 0), title_text, font=title_font)
            subtitle_bbox = draw.textbbox((0, 0), subtitle_text, font=subtitle_font)
            
            title_width = title_bbox[2] - title_bbox[0]
            title_height = title_bbox[3] - title_bbox[1]
            subtitle_width = subtitle_bbox[2] - subtitle_bbox[0]
            subtitle_height = subtitle_bbox[3] - subtitle_bbox[1]
            
            # Position at bottom with better spacing
            max_width = max(title_width, subtitle_width)
            total_height = title_height + subtitle_height + 10
            
            x = (image.width - max_width) // 2
            y = image.height - total_height - 30
            
            # Create attractive background with gradient effect
            padding = 20
            bg_x1 = x - padding
            bg_y1 = y - padding
            bg_x2 = x + max_width + padding
            bg_y2 = y + total_height + padding
            
            # Draw semi-transparent background with rounded effect
            overlay = Image.new('RGBA', image.size, (0, 0, 0, 0))
            overlay_draw = ImageDraw.Draw(overlay)
            
            # Main background
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y2], 
                                 fill=(0, 0, 0, 180))
            
            # Add accent bar
            overlay_draw.rectangle([bg_x1, bg_y1, bg_x2, bg_y1 + 4], 
                                 fill=(59, 130, 246, 255))  # Blue accent
            
            # Composite the overlay
            preview_image = Image.alpha_composite(preview_image.convert('RGBA'), overlay)
            preview_image = preview_image.convert('RGB')
            draw = ImageDraw.Draw(preview_image)
            
            # Draw title text
            title_x = x + (max_width - title_width) // 2
            draw.text((title_x, y), title_text, font=title_font, fill=(255, 255, 255))
            
            # Draw subtitle text
            subtitle_x = x + (max_width - subtitle_width) // 2
            subtitle_y = y + title_height + 10
            draw.text((subtitle_x, subtitle_y), subtitle_text, font=subtitle_font, fill=(200, 200, 200))
            
            # Convert back to bytes
            img_buffer = io.BytesIO()
            preview_image.save(img_buffer, format='JPEG', quality=90)
            
            # Return as base64
            img_b64 = base64.b64encode(img_buffer.getvalue()).decode()
            return f"data:image/jpeg;base64,{img_b64}"
            
        except Exception as e:
            print(f"Style preview creation error: {str(e)}")
            # Fallback to simple text overlay
            try:
                from PIL import ImageDraw, ImageFont
                
                image = Image.open(io.BytesIO(original_image_bytes))
                image = self._resize_image(image, max_size=512)
                preview_image = image.copy()
                draw = ImageDraw.Draw(preview_image)
                
                # Simple fallback
                text = f"Style: {haircut_style.title()}"
                try:
                    font = ImageFont.truetype("/System/Library/Fonts/Arial.ttf", 20)
                except:
                    font = ImageFont.load_default()
                
                bbox = draw.textbbox((0, 0), text, font=font)
                text_width = bbox[2] - bbox[0]
                text_height = bbox[3] - bbox[1]
                
                x = (image.width - text_width) // 2
                y = image.height - text_height - 15
                
                # Simple background
                draw.rectangle([x - 10, y - 5, x + text_width + 10, y + text_height + 5], 
                             fill=(0, 0, 0, 200))
                draw.text((x, y), text, font=font, fill=(255, 255, 255))
                
                img_buffer = io.BytesIO()
                preview_image.save(img_buffer, format='JPEG', quality=85)
                img_b64 = base64.b64encode(img_buffer.getvalue()).decode()
                return f"data:image/jpeg;base64,{img_b64}"
                
            except:
                return None


class HairRecommendationService:
    def __init__(self, aws_access_key, aws_secret_key, aws_region='us-east-1', gemini_api_key=None, gemini_api_keys=None):
        self.rekognition_service = AWSRekognitionService(aws_access_key, aws_secret_key, aws_region)
        
        # Support both single key (backwards compatibility) and multiple keys
        if gemini_api_keys:
            # Use the new multi-key system
            self.hair_generation = GeminiHairGeneration(gemini_api_keys=gemini_api_keys)
        elif gemini_api_key:
            # Backwards compatibility: convert single key to list
            self.hair_generation = GeminiHairGeneration(gemini_api_keys=[gemini_api_key])
        else:
            # No keys provided, auto-load from environment variables
            self.hair_generation = GeminiHairGeneration()
    
    def process_selfie_with_progress(self, image_bytes, session_id, progress_callback, preferred_style=None):
        """
        Optimized pipeline with progress tracking: Analyze face -> Generate recommendations -> Create images in parallel
        """
        try:
            # Step 1: Analyze face with AWS Rekognition
            progress_callback(session_id, "face_analysis", "Menganalisis wajah dengan AWS Rekognition...", 35)
            print("Analyzing face with AWS Rekognition...")
            face_analysis = self.rekognition_service.analyze_face(image_bytes)
            
            if not face_analysis:
                progress_callback(session_id, "error", "Tidak dapat mendeteksi wajah pada gambar", 0)
                return {
                    'success': False,
                    'error': 'Could not detect face in the image'
                }
            
            # Step 2: Generate haircut recommendations with preferred style
            if preferred_style:
                progress_callback(session_id, "recommendations", f"Membuat variasi {preferred_style}...", 45)
                print(f"Generating recommendations for preferred style: {preferred_style}")
                recommendations = self.hair_generation.generate_style_variations(face_analysis, preferred_style)
            else:
                progress_callback(session_id, "recommendations", "Membuat rekomendasi gaya rambut...", 45)
                print("Generating haircut recommendations...")
                recommendations = self.hair_generation.generate_haircut_recommendations(face_analysis)
            
            # Step 3: Generate images for all recommendations in parallel
            progress_callback(session_id, "image_generation", "Membuat pratinjau gaya (1/4)...", 50)
            print("Creating style previews in parallel...")
            
            def generate_single_style(index_and_style):
                """Generate a single style transformation with progress updates"""
                i, haircut_style = index_and_style
                
                # Update progress for each style
                progress_percentage = 50 + ((i + 1) * 10)  # 50% + 10% per style
                progress_callback(session_id, "image_generation", f"Membuat pratinjau gaya ({i+1}/4): {haircut_style}...", progress_percentage)
                print(f"Processing style {i+1}/4: {haircut_style}")
                
                try:
                    # Generate AI description
                    ai_description = self.hair_generation.generate_haircut_description(haircut_style)
                    
                    # Create AI transformation with face analysis for age-appropriate styling
                    transformed_image = self.hair_generation.generate_haircut_image_with_gemini(
                        image_bytes, haircut_style, face_analysis
                    )
                    
                    if transformed_image:
                        print(f"✓ Style {i+1} AI generation complete")
                        return {
                            'style': haircut_style,
                            'description': ai_description,
                            'image': transformed_image,
                            'ai_generated': True
                        }
                    else:
                        print(f"⚠ Style {i+1} fallback generation")
                        # Generate styled preview using local processing
                        styled_image = self.hair_generation.generate_haircut_image(image_bytes, haircut_style)
                        return {
                            'style': haircut_style,
                            'description': ai_description,
                            'image': styled_image,
                            'ai_generated': False
                        }
                        
                except Exception as e:
                    print(f"❌ Error generating style {i+1}: {str(e)}")
                    # Generate fallback styled preview
                    styled_image = self.hair_generation.generate_haircut_image(image_bytes, haircut_style)
                    return {
                        'style': haircut_style,
                        'description': f"Gaya {haircut_style} yang cocok untuk bentuk wajah Anda",
                        'image': styled_image,
                        'ai_generated': False
                    }
            
            # Execute parallel generation with progress tracking
            progress_callback(session_id, "image_generation", "Memproses semua gaya secara paralel...", 60)
            
            with ThreadPoolExecutor(max_workers=2) as executor:
                # Create indexed list for progress tracking
                indexed_recommendations = list(enumerate(recommendations))
                
                # Generate all styles
                results = list(executor.map(generate_single_style, indexed_recommendations))
            
            progress_callback(session_id, "finalizing", "Menyelesaikan hasil analisis...", 95)
            
            return {
                'success': True,
                'face_analysis': {
                    'face_shape': face_analysis.get('face_shape', 'oval'),
                    'age_range': face_analysis.get('age_range', {}),
                    'gender': face_analysis.get('gender', 'Unknown'),
                    'confidence': face_analysis.get('confidence', 0)
                },
                'recommendations': recommendations,  # Original AI recommendations
                'generated_images': results          # Generated images with styles
            }
            
        except Exception as e:
            error_msg = str(e)
            print(f"❌ Error in process_selfie_with_progress: {error_msg}")
            progress_callback(session_id, "error", f"Kesalahan: {error_msg}", 0)
            return {
                'success': False,
                'error': f'Processing failed: {error_msg}'
            }

    def process_selfie(self, image_bytes):
        """
        Optimized pipeline: Analyze face -> Generate recommendations -> Create images in parallel
        """
        try:
            # Step 1: Analyze face with AWS Rekognition
            print("Analyzing face with AWS Rekognition...")
            face_analysis = self.rekognition_service.analyze_face(image_bytes)
            
            if not face_analysis:
                return {
                    'success': False,
                    'error': 'Could not detect face in the image'
                }
            
            # Step 2: Generate haircut recommendations (faster with optimized prompts)
            print("Generating haircut recommendations...")
            recommendations = self.hair_generation.generate_haircut_recommendations(face_analysis)
            
            # Step 3: Generate images for all recommendations in parallel
            print("Creating style previews in parallel...")
            
            def generate_single_style(index_and_style):
                """Generate a single style transformation"""
                i, haircut_style = index_and_style
                print(f"Processing style {i+1}/4: {haircut_style}")
                
                try:
                    # Generate AI description
                    ai_description = self.hair_generation.generate_haircut_description(haircut_style)
                    
                    # Create AI transformation with face analysis for age-appropriate styling
                    transformed_image = self.hair_generation.generate_haircut_image_with_gemini(
                        image_bytes, haircut_style, face_analysis
                    )
                    
                    if transformed_image:
                        print(f"✓ Style {i+1} AI generation complete")
                        return {
                            'style': haircut_style,
                            'image': transformed_image,
                            'id': i + 1,
                            'is_ai_generated': True,
                            'description': ai_description
                        }
                    else:
                        # Quick fallback to style preview
                        style_preview = self.hair_generation._create_style_preview(image_bytes, haircut_style)
                        if style_preview:
                            print(f"✓ Style {i+1} preview complete")
                            return {
                                'style': haircut_style,
                                'image': style_preview,
                                'id': i + 1,
                                'is_preview': True,
                                'description': ai_description
                            }
                        else:
                            # Last resort: use original image with style overlay
                            original_b64 = base64.b64encode(image_bytes).decode()
                            print(f"⚠ Style {i+1} using fallback")
                            return {
                                'style': haircut_style,
                                'image': f"data:image/jpeg;base64,{original_b64}",
                                'id': i + 1,
                                'is_fallback': True,
                                'description': ai_description
                            }
                            
                except Exception as e:
                    print(f"❌ Error generating style {i+1}: {str(e)}")
                    # Return fallback
                    original_b64 = base64.b64encode(image_bytes).decode()
                    return {
                        'style': haircut_style,
                        'image': f"data:image/jpeg;base64,{original_b64}",
                        'id': i + 1,
                        'is_fallback': True,
                        'description': f"A {haircut_style} would suit your face shape well."
                    }
            
            # Process all 4 styles in parallel with ThreadPoolExecutor
            with ThreadPoolExecutor(max_workers=4) as executor:
                # Submit all tasks
                style_tasks = [(i, style) for i, style in enumerate(recommendations)]
                future_to_style = {
                    executor.submit(generate_single_style, task): task 
                    for task in style_tasks
                }
                
                generated_images = []
                # Collect results as they complete
                from concurrent.futures import as_completed
                
                for future in as_completed(future_to_style, timeout=180):  # 3 minute total timeout
                    try:
                        result = future.result()
                        generated_images.append(result)
                        print(f"✅ Completed style {result['id']}/4")
                    except Exception as e:
                        i, style = future_to_style[future]
                        print(f"❌ Style {i+1} failed: {str(e)}")
                        original_b64 = base64.b64encode(image_bytes).decode()
                        generated_images.append({
                            'style': style,
                            'image': f"data:image/jpeg;base64,{original_b64}",
                            'id': i + 1,
                            'is_fallback': True,
                            'description': f"A {style} style would work well for you."
                        })
            
            # Sort results by ID to maintain order
            generated_images.sort(key=lambda x: x['id'])
            
            print(f"✅ All {len(generated_images)} styles processing complete!")
            return {
                'success': True,
                'face_analysis': face_analysis,
                'recommendations': recommendations,
                'generated_images': generated_images
            }
            
        except Exception as e:
            print(f"Processing error: {str(e)}")
            return {
                'success': False,
                'error': f'Processing failed: {str(e)}'
            }
