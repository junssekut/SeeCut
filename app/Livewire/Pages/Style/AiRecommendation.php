<?php

namespace App\Livewire\Pages\Style;

use App\Services\HairRecommendationService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AiRecommendation extends Component
{
    use WithFileUploads;

    public $uploadedImage;
    public $previewImage = null;
    public $analysisResult = null;
    public $selectedHaircut = null;
    public $selectedColor = null;
    public $showModal = false;
    public $processing = false;
    public $error = null;
    public $success = null;
    public $preferredStyle = '';
    public $progressStatus = '';
    public $currentStep = '';
    public $progressPercentage = 0;
    public $sessionId = null;
    public $enablePolling = false; // Control polling state
    public $uploadStartTime = null; // Track when upload started

    protected $rules = [
        'uploadedImage' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB max
    ];

    protected $messages = [
        'uploadedImage.required' => 'Silakan pilih foto untuk dianalisis.',
        'uploadedImage.image' => 'File harus berupa gambar.',
        'uploadedImage.mimes' => 'Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.',
        'uploadedImage.max' => 'Ukuran file terlalu besar. Maksimal 2MB.',
    ];

    public function mount()
    {
        $this->resetStates();
    }

    public function updatedUploadedImage()
    {
        Log::info('File upload triggered');
        
        $this->resetErrorBag();
        $this->resetStates();

        if (!$this->uploadedImage) {
            Log::info('No file uploaded');
            return;
        }

        try {
            // Check file size before validation (convert to MB for user-friendly message)
            $fileSizeInMB = $this->uploadedImage->getSize() / 1024 / 1024;
            $maxSizeInMB = 2; // 2MB limit
            
            Log::info('File upload attempt', [
                'original_name' => $this->uploadedImage->getClientOriginalName(),
                'size_bytes' => $this->uploadedImage->getSize(),
                'size_mb' => round($fileSizeInMB, 2),
                'mime_type' => $this->uploadedImage->getMimeType()
            ]);

                        // Early size check with user-friendly error
            if ($fileSizeInMB > $maxSizeInMB) {
                notyf()
                    ->duration(5000)
                    ->ripple(true)
                    ->addError('File "' . $this->uploadedImage->getClientOriginalName() . '" terlalu besar (' . round($fileSizeInMB, 1) . 'MB). Maksimal 2MB.');
                    
                Log::warning('File too large', [
                    'size_mb' => round($fileSizeInMB, 2),
                    'max_mb' => $maxSizeInMB
                ]);
                $this->resetUpload();
                return;
            }

            // Check file type
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($this->uploadedImage->getMimeType(), $allowedMimes)) {
                notyf()
                    ->duration(4000)
                    ->ripple(true)
                    ->addError('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    
                Log::warning('Invalid file type', [
                    'mime_type' => $this->uploadedImage->getMimeType()
                ]);
                $this->resetUpload();
                return;
            }
            
            // Validate with Laravel rules
            $this->validate();
            
            Log::info('File validation passed');
            
            // Generate preview URL
            $this->previewImage = $this->uploadedImage->temporaryUrl();
            
            Log::info('Preview URL generated: ' . $this->previewImage);
            
            // Start processing immediately with proper state
            $this->processing = true;
            $this->enablePolling = true; // Enable polling immediately
            $this->progressStatus = 'Memulai analisis...';
            $this->progressPercentage = 5;
            $this->currentStep = 'validation';
            $this->error = null; // Clear any previous errors
            $this->success = null; // Clear any previous success messages
            $this->uploadStartTime = time(); // Track upload time
            
            // Generate session ID for progress tracking
            $this->sessionId = uniqid('hair_', true);
            
            Log::info('Starting AI processing with session ID: ' . $this->sessionId);
            
            // Dispatch processing started event immediately
            $this->dispatch('processing-started', ['sessionId' => $this->sessionId]);
            
            // Start AI processing directly instead of deferring
            $this->processWithAI();
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = 'File validation failed: ' . collect($e->errors())->flatten()->first();
            
            notyf()
                ->duration(4000)
                ->ripple(true)
                ->addError($errorMessage);
                
            Log::error('File validation error: ' . $errorMessage);
            $this->resetUpload();
        } catch (\Exception $e) {
            $errorMessage = 'Upload error: ' . $e->getMessage();
            
            notyf()
                ->duration(4000)
                ->ripple(true)
                ->addError($errorMessage);
                
            Log::error('Image upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->resetUpload();
        }
    }

    public function processWithAI()
    {
        Log::info('🚀 processWithAI() called', [
            'session_id' => $this->sessionId,
            'preferred_style' => $this->preferredStyle,
            'processing' => $this->processing,
            'uploadedImage_exists' => $this->uploadedImage ? 'yes' : 'no'
        ]);
        
        // Processing state should already be set from updatedUploadedImage
        if (!$this->processing) {
            Log::warning('processWithAI called but processing not set');
            $this->processing = true;
            $this->enablePolling = true;
        }

        if (!$this->uploadedImage) {
            Log::error('processWithAI called but no uploaded image');
            $this->error = 'Tidak ada gambar yang diupload';
            return;
        }

        try {
            // Instead of making a blocking call, trigger async processing
            $this->startAsyncProcessing();
            
            Log::info('✅ Async AI processing triggered successfully');
            
        } catch (\Exception $e) {
            $this->progressStatus = 'Terjadi kesalahan';
            $this->currentStep = 'error';
            $this->error = 'Koneksi ke server bermasalah. Coba lagi nanti.';
            
            Log::error('❌ AI processing error', [
                'error' => $e->getMessage(),
                'session_id' => $this->sessionId,
                'trace' => $e->getTraceAsString()
            ]);
            
            notyf()
                ->duration(5000)
                ->ripple(true)
                ->addError('Koneksi ke server bermasalah. Coba lagi nanti.');
                
            $this->dispatch('processing-error', ['message' => $this->error]);
                
        } finally {
            // Don't set processing to false here - let pollProgress handle it
            // when it sees 'complete' or 'error' step
            Log::info('AI processing method completed (async)');
            
            // Don't dispatch completion event here - it will be handled by polling
        }
    }

    /**
     * Start async processing using the new two-step approach
     */
    private function startAsyncProcessing()
    {
        if (!$this->uploadedImage) {
            throw new \Exception('No uploaded image found');
        }
        
        $uploadedFilePath = $this->uploadedImage->getRealPath();
        $sessionId = $this->sessionId;
        $preferredStyle = $this->preferredStyle ?? '';
        
        // Verify the file exists and is readable
        if (!$uploadedFilePath || !file_exists($uploadedFilePath)) {
            Log::error('Uploaded file not found or not readable', [
                'path' => $uploadedFilePath,
                'session_id' => $sessionId
            ]);
            throw new \Exception('Uploaded file not accessible');
        }
        
        Log::info('🚀 Starting new two-step analysis approach', [
            'session_id' => $sessionId,
            'file_path' => $uploadedFilePath,
            'file_exists' => file_exists($uploadedFilePath),
            'file_size' => file_exists($uploadedFilePath) ? filesize($uploadedFilePath) : 'N/A'
        ]);
        
        try {
            // Step 1: Send POST to start-analysis endpoint (Python will process in background)
            $response = Http::timeout(10)
                ->attach('image', file_get_contents($uploadedFilePath), basename($uploadedFilePath))
                ->post('http://localhost:5001/start-analysis', [
                    'session_id' => $sessionId,
                    'preferred_style' => $preferredStyle
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('✅ Analysis started successfully', [
                    'response' => $data,
                    'session_id' => $sessionId
                ]);
                
                // Update initial progress
                $this->progressStatus = 'Analisis dimulai...';
                $this->progressPercentage = 5;
                $this->currentStep = 'started';
                
                return true;
                
            } else {
                Log::error('❌ Failed to start analysis', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'session_id' => $sessionId
                ]);
                
                throw new \Exception('Gagal memulai analisis: ' . $response->body());
            }
            
        } catch (\Exception $e) {
            Log::error('❌ HTTP request error', [
                'error' => $e->getMessage(),
                'session_id' => $sessionId
            ]);
            
            throw new \Exception('Koneksi ke server bermasalah: ' . $e->getMessage());
        }
    }

    #[On('trigger-ai-processing')]
    public function triggerAIProcessing()
    {
        Log::info('AI processing triggered via JavaScript event');
        $this->processWithAI();
    }

    #[On('update-progress-status')]
    public function updateProgressStatus($status)
    {
        $this->progressStatus = $status;
        Log::info('Progress status updated', ['status' => $status]);
    }

    /**
     * Update progress from frontend JavaScript
     */
    public function updateProgressFromFrontend($data)
    {
        if (isset($data['message'])) {
            $this->progressStatus = $data['message'];
        }
        
        if (isset($data['step'])) {
            $this->currentStep = $data['step'];
        }
        
        if (isset($data['percentage'])) {
            $this->progressPercentage = $data['percentage'];
        }

        Log::info('Progress updated from frontend', [
            'message' => $data['message'] ?? null,
            'step' => $data['step'] ?? null,
            'percentage' => $data['percentage'] ?? null
        ]);
    }

    /**
     * Complete processing and close overlay
     */
    public function completeProcessing()
    {
        $this->processing = false;
        $this->enablePolling = false;
        $this->currentStep = '';
        $this->progressPercentage = 100;
        
        Log::info('Processing completed and overlay closed', [
            'session_id' => $this->sessionId
        ]);
    }

    /**
     * Poll for progress updates using Livewire
     */
    public function pollProgress()
    {
        Log::info('pollProgress called', [
            'enablePolling' => $this->enablePolling,
            'sessionId' => $this->sessionId,
            'processing' => $this->processing,
            'currentProgress' => $this->progressPercentage
        ]);
        
        if (!$this->enablePolling || !$this->sessionId) {
            Log::info('Polling disabled or no session ID', [
                'enablePolling' => $this->enablePolling,
                'sessionId' => $this->sessionId
            ]);
            return;
        }

        try {
            // Check for async results directly from Python API
            $this->checkAsyncResults();
            
        } catch (\Exception $e) {
            Log::error('Progress polling error', [
                'error' => $e->getMessage(),
                'session_id' => $this->sessionId
            ]);
            
            $this->currentStep = 'error';
            $this->error = 'Terjadi kesalahan saat memantau progress.';
            $this->processing = false;
            $this->enablePolling = false;
        }
    }

    /**
     * Check for async processing results using the new two-step approach
     */
    private function checkAsyncResults()
    {
        try {
            // Step 1: Check progress from Python API
            $progressResponse = Http::timeout(5)->get("http://localhost:5001/progress/{$this->sessionId}");
            
            if ($progressResponse->successful()) {
                $progressData = $progressResponse->json();
                
                Log::info('📊 Progress check response', [
                    'data' => $progressData,
                    'session_id' => $this->sessionId
                ]);
                
                // Process and normalize the progress data with proper logic
                $this->processProgressData($progressData);
                
                // Check if processing is complete
                if ($progressData['step'] === 'complete') {
                    Log::info('🎉 Analysis complete, fetching final result');
                    
                    // Step 2: Get the final result from get-result endpoint
                    $resultResponse = Http::timeout(10)->get("http://localhost:5001/get-result/{$this->sessionId}");
                    
                    if ($resultResponse->successful()) {
                        $resultData = $resultResponse->json();
                        
                        if ($resultData['success'] && isset($resultData['result'])) {
                            $this->handleAsyncComplete($resultData['result']);
                            return;
                        } else {
                            Log::error('❌ Failed to get final result', [
                                'response' => $resultData,
                                'session_id' => $this->sessionId
                            ]);
                            $this->handleAsyncError('Gagal mendapatkan hasil analisis');
                            return;
                        }
                    } else {
                        Log::error('❌ Failed to fetch result', [
                            'status' => $resultResponse->status(),
                            'body' => $resultResponse->body(),
                            'session_id' => $this->sessionId
                        ]);
                        $this->handleAsyncError('Gagal mengambil hasil analisis');
                        return;
                    }
                } elseif ($progressData['step'] === 'error') {
                    $errorMessage = $progressData['error'] ?? $progressData['message'] ?? 'Terjadi kesalahan pada analisis.';
                    $this->handleAsyncError($errorMessage);
                    return;
                }
                
            } else {
                Log::warning('⚠️ Progress check failed', [
                    'status' => $progressResponse->status(),
                    'body' => $progressResponse->body(),
                    'session_id' => $this->sessionId
                ]);
                
                // Don't immediately fail - the server might be busy
                // Just keep the current status
            }
            
        } catch (\Exception $e) {
            Log::error('❌ Progress check error', [
                'error' => $e->getMessage(),
                'session_id' => $this->sessionId
            ]);
            
            // Don't immediately fail on network errors - keep trying
            // Only stop polling if there's a critical error
        }
    }

    /**
     * Process and normalize progress data with proper backend logic
     */
    private function processProgressData($progressData)
    {
        // Define step mapping and minimum progress thresholds in PHP
        $stepMapping = [
            'error' => ['step' => 0, 'minProgress' => 0],
            'validation' => ['step' => 1, 'minProgress' => 5],
            'started' => ['step' => 1, 'minProgress' => 5],
            'upload' => ['step' => 1, 'minProgress' => 15],
            'analysis' => ['step' => 2, 'minProgress' => 30],
            'face_analysis' => ['step' => 2, 'minProgress' => 35],
            'recommendations' => ['step' => 3, 'minProgress' => 45],
            'image_generation_1' => ['step' => 4, 'minProgress' => 50],
            'generation' => ['step' => 4, 'minProgress' => 60],
            'image_generation' => ['step' => 4, 'minProgress' => 60],
            'image_generation_2' => ['step' => 4, 'minProgress' => 75],
            'image_generation_3' => ['step' => 4, 'minProgress' => 80],
            'image_generation_4' => ['step' => 4, 'minProgress' => 90],
            'finalizing' => ['step' => 5, 'minProgress' => 95],
            'complete' => ['step' => 5, 'minProgress' => 100]
        ];

        $currentStepName = $progressData['step'] ?? 'validation';
        $rawPercentage = $progressData['percentage'] ?? 0;
        
        // Get step info
        $stepInfo = $stepMapping[$currentStepName] ?? $stepMapping['validation'];
        
        // Ensure progress never goes backward - THIS IS THE KEY FIX
        $minAllowedProgress = max(
            $this->progressPercentage, // Never go below current progress
            $stepInfo['minProgress']    // Never go below step minimum
        );
        
        $normalizedProgress = max($rawPercentage, $minAllowedProgress);
        
        // Update progress values
        $this->progressPercentage = $normalizedProgress;
        $this->currentStep = $currentStepName;
        
        // Update status message with better UX
        if (isset($progressData['message'])) {
            $this->progressStatus = $progressData['message'];
        } else {
            // Fallback messages based on step
            $stepMessages = [
                'error' => 'Terjadi kesalahan...',
                'validation' => 'Memvalidasi gambar...',
                'started' => 'Memulai proses analisis...',
                'upload' => 'Mengunggah gambar...',
                'analysis' => 'Menganalisis wajah...',
                'face_analysis' => 'Mendeteksi fitur wajah...',
                'generating_recommendations' => 'Membuat rekomendasi...',
                'recommendations' => 'Menyempurnakan rekomendasi...',
                'generation' => 'Memulai pembuatan pratinjau...',
                'image_generation' => 'Membuat pratinjau gaya...',
                'image_generation_1' => 'Membuat pratinjau gaya (1/4)...',
                'image_generation_2' => 'Membuat pratinjau gaya (2/4)...',
                'image_generation_3' => 'Membuat pratinjau gaya (3/4)...',
                'image_generation_4' => 'Membuat pratinjau gaya (4/4)...',
                'finalizing' => 'Menyelesaikan analisis...',
                'complete' => 'Analisis selesai!'
            ];
            
            $this->progressStatus = $stepMessages[$currentStepName] ?? 'Memproses...';
        }
        
        // Handle waiting state with better UX
        if ($currentStepName === 'waiting' && $normalizedProgress <= 10) {
            $waitTime = time() - ($this->uploadStartTime ?? time());
            if ($waitTime > 30) {
                Log::warning('⚠️ Analysis seems stuck in waiting state', [
                    'wait_time' => $waitTime,
                    'session_id' => $this->sessionId
                ]);
                $this->progressStatus = 'Analisis membutuhkan waktu lebih lama...';
            } else {
                $this->progressStatus = 'Memulai proses analisis...';
                $this->progressPercentage = max(5, $this->progressPercentage);
            }
        }
        
        Log::info('🔄 Progress processed in PHP', [
            'step' => $currentStepName,
            'raw_percentage' => $rawPercentage,
            'normalized_percentage' => $normalizedProgress,
            'min_allowed' => $minAllowedProgress,
            'status' => $this->progressStatus
        ]);
    }

    /**
     * Handle async processing completion
     */
    private function handleAsyncComplete($result)
    {
        Log::info('Handling async completion', [
            'result_keys' => is_array($result) ? array_keys($result) : 'not_array',
            'session_id' => $this->sessionId
        ]);
        
        $this->analysisResult = $result;
        $this->progressStatus = 'Analisis selesai!';
        $this->progressPercentage = 100;
        $this->currentStep = 'complete';
        $this->enablePolling = false;
        $this->processing = false;
        
        $successMessage = !empty($this->preferredStyle) 
            ? "Analisis berhasil! Rekomendasi {$this->preferredStyle} sudah siap."
            : 'Analisis berhasil! Lihat rekomendasi di bawah.';
            
        $this->success = $successMessage;
        
        // Show success notification
        notyf()
            ->duration(4000)
            ->ripple(true)
            ->addSuccess($successMessage);

        // Auto-select first haircut
        if (!empty($result['generated_images'])) {
            $this->selectedHaircut = $result['generated_images'][0];
            Log::info('Auto-selected first haircut from async result');
        }
        
        // Dispatch analysis updated for frontend refresh
        $this->dispatch('analysis-updated');
        $this->dispatch('processing-completed');
    }

    /**
     * Handle async processing error
     */
    private function handleAsyncError($errorMessage)
    {
        Log::error('Handling async error', [
            'error' => $errorMessage,
            'session_id' => $this->sessionId
        ]);
        
        $this->progressStatus = 'Analisis gagal';
        $this->currentStep = 'error';
        $this->error = $errorMessage;
        $this->enablePolling = false;
        $this->processing = false;
        
        notyf()
            ->duration(5000)
            ->ripple(true)
            ->addError($errorMessage);
            
        $this->dispatch('processing-error', ['message' => $errorMessage]);
    }

    public function getProgressStatus()
    {
        if (!$this->sessionId) {
            return ['step' => 'waiting', 'message' => 'Menunggu...', 'percentage' => 0];
        }

        try {
            $hairService = app(HairRecommendationService::class);
            return $hairService->getProgressStatus($this->sessionId);
        } catch (\Exception $e) {
            Log::error('Progress status error', ['error' => $e->getMessage()]);
            return ['step' => 'waiting', 'message' => 'Menunggu...', 'percentage' => 0];
        }
    }

    public function selectHaircut($index)
    {
        if (isset($this->analysisResult['generated_images'][$index])) {
            $this->selectedHaircut = $this->analysisResult['generated_images'][$index];
            
            // Show modal if image is available and not fallback
            if (!empty($this->selectedHaircut['image']) && !($this->selectedHaircut['is_fallback'] ?? false)) {
                $this->showModal = true;
            }
        }
    }

    public function selectColor($colorData)
    {
        $this->selectedColor = $colorData;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetUpload()
    {
        $this->uploadedImage = null;
        $this->resetStates();
        
        // Clear any validation errors
        $this->resetErrorBag();
        
        // Emit event to clear file input in frontend
        $this->dispatch('clear-file-input');
    }

    private function resetStates()
    {
        $this->previewImage = null;
        $this->analysisResult = null;
        $this->selectedHaircut = null;
        $this->selectedColor = null;
        $this->processing = false;
        $this->error = null;
        $this->success = null;
        $this->showModal = false;
        $this->progressStatus = '';
        $this->sessionId = null;
        $this->enablePolling = false;
        $this->uploadStartTime = null;
        // Note: preferredStyle is kept intentionally so user doesn't lose their input
    }

    public function getHaircutDescription($style)
    {
        $descriptions = [
            'crew cut' => 'Gaya rambut klasik dengan potongan pendek yang rapi dan mudah dirawat.',
            'quiff' => 'Gaya modern dengan volume di bagian depan yang memberikan kesan stylish.',
            'side part' => 'Potongan klasik dengan belahan samping yang cocok untuk acara formal.',
            'fade' => 'Potongan gradual dari pendek ke panjang yang memberikan tampilan clean.',
            'undercut' => 'Potongan kontras dengan bagian samping pendek dan atas panjang.',
            'buzz cut' => 'Potongan sangat pendek yang praktis dan mudah dirawat.',
            'textured crop' => 'Potongan bertekstur yang memberikan volume dan gerakan alami.',
            'pompadour' => 'Gaya vintage dengan volume tinggi di bagian depan.',
            'default' => 'Gaya rambut yang sesuai dengan bentuk wajah dan preferensi Anda.'
        ];

        $key = collect($descriptions)
            ->keys()
            ->first(fn($k) => str_contains(strtolower($style ?? ''), strtolower($k)));

        return $descriptions[$key] ?? $descriptions['default'];
    }

    public function getRecommendedColors()
    {
        $faceAnalysis = $this->analysisResult['face_analysis'] ?? null;

        // Basic color recommendations
        $colors = [
            [
                'name' => 'Natural',
                'hex' => '#4A3C1A',
                'description' => 'Warna alami yang cocok untuk semua jenis kulit'
            ],
            [
                'name' => 'Dark Brown',
                'hex' => '#2C1810',
                'description' => 'Coklat gelap yang memberikan kesan elegan'
            ],
            [
                'name' => 'Light Brown',
                'hex' => '#8B6914',
                'description' => 'Coklat terang yang cerah dan modern'
            ],
            [
                'name' => 'Black',
                'hex' => '#000000',
                'description' => 'Hitam klasik yang timeless dan sophisticated'
            ]
        ];

        // Add specific recommendations based on analysis
        if ($faceAnalysis) {
            if (isset($faceAnalysis['age_range']['Low']) && $faceAnalysis['age_range']['Low'] < 30) {
                $colors[] = [
                    'name' => 'Ash Blonde',
                    'hex' => '#C4A869',
                    'description' => 'Pirang abu yang trendy untuk anak muda'
                ];
            }

            if (isset($faceAnalysis['gender']) && $faceAnalysis['gender'] === 'Male') {
                $colors = array_filter($colors, fn($c) => !str_contains($c['name'], 'Blonde'));
            }
        }

        return array_slice($colors, 0, 4);
    }

    /**
     * Compress image if it's between 2MB and 5MB
     */
    private function compressImageIfNeeded($uploadedFile)
    {
        $fileSizeInMB = $uploadedFile->getSize() / 1024 / 1024;
        
        // If file is already under 2MB, no compression needed
        if ($fileSizeInMB <= 2) {
            return $uploadedFile;
        }
        
        // If file is over 5MB, reject it
        if ($fileSizeInMB > 5) {
            throw new \Exception("File terlalu besar (" . round($fileSizeInMB, 1) . "MB). Maksimal 5MB.");
        }
        
        Log::info('Starting image compression', [
            'original_size_mb' => round($fileSizeInMB, 2),
            'target_size_mb' => 2
        ]);
        
        try {
            // Check if GD extension is available
            if (!extension_loaded('gd')) {
                throw new \Exception("GD extension tidak tersedia. Tidak dapat mengkompresi gambar.");
            }
            
            // Get file path and create temporary compressed file
            $originalPath = $uploadedFile->getRealPath();
            
            if (!$originalPath || !file_exists($originalPath)) {
                throw new \Exception("File asli tidak dapat diakses");
            }
            
            $compressedPath = sys_get_temp_dir() . '/compressed_' . uniqid() . '.jpg';
            
            // Check if temp directory is writable
            if (!is_writable(sys_get_temp_dir())) {
                throw new \Exception("Direktori temporary tidak dapat ditulis");
            }
            
            // Determine image type and create image resource
            $imageInfo = @getimagesize($originalPath);
            if (!$imageInfo) {
                throw new \Exception("File bukan gambar yang valid atau rusak");
            }
            
            $mimeType = $imageInfo['mime'];
            
            Log::info('Processing image for compression', [
                'mime_type' => $mimeType,
                'dimensions' => $imageInfo[0] . 'x' . $imageInfo[1],
                'original_path' => $originalPath,
                'compressed_path' => $compressedPath
            ]);
            
            $image = null;
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = @imagecreatefromjpeg($originalPath);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($originalPath);
                    break;
                default:
                    throw new \Exception("Tipe gambar tidak didukung: " . $mimeType . ". Gunakan JPEG atau PNG.");
            }
            
            if (!$image) {
                $lastError = error_get_last();
                throw new \Exception("Gagal membuat resource gambar: " . ($lastError['message'] ?? 'Unknown error'));
            }
            
            // Get original dimensions
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);
            
            if (!$originalWidth || !$originalHeight) {
                imagedestroy($image);
                throw new \Exception("Dimensi gambar tidak valid");
            }
            
            Log::info('Original image dimensions', [
                'width' => $originalWidth,
                'height' => $originalHeight
            ]);
            
            // Calculate compression strategy
            $quality = 85; // Start with high quality
            $maxDimension = 1920; // Max width/height for large images
            
            // Resize if image is very large
            if ($originalWidth > $maxDimension || $originalHeight > $maxDimension) {
                $ratio = min($maxDimension / $originalWidth, $maxDimension / $originalHeight);
                $newWidth = round($originalWidth * $ratio);
                $newHeight = round($originalHeight * $ratio);
                
                $resizedImage = @imagecreatetruecolor($newWidth, $newHeight);
                
                if (!$resizedImage) {
                    imagedestroy($image);
                    throw new \Exception("Gagal membuat gambar baru untuk resize");
                }
                
                // Handle PNG transparency
                if ($mimeType === 'image/png') {
                    imagealphablending($resizedImage, false);
                    imagesavealpha($resizedImage, true);
                    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                    imagefill($resizedImage, 0, 0, $transparent);
                }
                
                $resizeResult = imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
                
                if (!$resizeResult) {
                    imagedestroy($image);
                    imagedestroy($resizedImage);
                    throw new \Exception("Gagal melakukan resize gambar");
                }
                
                imagedestroy($image);
                $image = $resizedImage;
                
                Log::info('Image resized', [
                    'original' => "{$originalWidth}x{$originalHeight}",
                    'new' => "{$newWidth}x{$newHeight}",
                    'ratio' => $ratio
                ]);
            }
            
            // Try different quality levels to achieve target size
            $attempts = 0;
            $maxAttempts = 5;
            $targetSizeMB = 2;
            
            do {
                // Save with current quality
                $saveResult = @imagejpeg($image, $compressedPath, $quality);
                
                if (!$saveResult) {
                    $lastError = error_get_last();
                    imagedestroy($image);
                    throw new \Exception("Gagal menyimpan gambar terkompresi: " . ($lastError['message'] ?? 'Unknown error'));
                }
                
                if (!file_exists($compressedPath)) {
                    imagedestroy($image);
                    throw new \Exception("File terkompresi tidak terbuat di: " . $compressedPath);
                }
                
                $compressedSize = filesize($compressedPath);
                $compressedSizeMB = $compressedSize / 1024 / 1024;
                
                Log::info('Compression attempt', [
                    'attempt' => $attempts + 1,
                    'quality' => $quality,
                    'size_mb' => round($compressedSizeMB, 2),
                    'target_mb' => $targetSizeMB
                ]);
                
                // If we're under target size, we're done
                if ($compressedSizeMB <= $targetSizeMB) {
                    break;
                }
                
                // If this is the last attempt, accept whatever we have
                if ($attempts >= $maxAttempts - 1) {
                    Log::warning('Reached max compression attempts', [
                        'final_size_mb' => round($compressedSizeMB, 2),
                        'final_quality' => $quality
                    ]);
                    break;
                }
                
                // Reduce quality for next attempt
                $quality -= 15;
                $attempts++;
                
            } while ($attempts < $maxAttempts && $quality > 30);
            
            imagedestroy($image);
            
            $finalSizeMB = filesize($compressedPath) / 1024 / 1024;
            
            // Verify the final file is readable
            if ($finalSizeMB <= 0) {
                throw new \Exception("File terkompresi kosong atau tidak valid");
            }
            
            Log::info('Image compression completed', [
                'original_size_mb' => round($fileSizeInMB, 2),
                'final_size_mb' => round($finalSizeMB, 2),
                'compression_ratio' => round((1 - $finalSizeMB / $fileSizeInMB) * 100, 1) . '%',
                'final_quality' => $quality,
                'attempts' => $attempts + 1
            ]);
            
            // Create a new UploadedFile instance with compressed data
            try {
                $compressedFile = new \Illuminate\Http\UploadedFile(
                    $compressedPath,
                    $uploadedFile->getClientOriginalName(),
                    'image/jpeg',
                    null,
                    true // test mode to avoid validation
                );
                
                // Verify the new file is accessible
                if (!$compressedFile->isValid()) {
                    throw new \Exception("File terkompresi tidak valid untuk upload");
                }
                
                return $compressedFile;
                
            } catch (\Exception $e) {
                // Clean up temp file
                if (file_exists($compressedPath)) {
                    @unlink($compressedPath);
                }
                throw new \Exception("Gagal membuat file upload terkompresi: " . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            Log::error('Image compression failed', [
                'error' => $e->getMessage(),
                'file_size_mb' => round($fileSizeInMB, 2),
                'mime_type' => $uploadedFile->getMimeType(),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Clean up any temporary files
            if (isset($compressedPath) && file_exists($compressedPath)) {
                @unlink($compressedPath);
            }
            
            // If compression fails and file is small enough, return original
            if ($fileSizeInMB <= 2) {
                Log::info('Compression failed but original file is under 2MB, using original');
                return $uploadedFile;
            }
            
            // Otherwise, throw descriptive error
            throw new \Exception("Gagal mengkompresi gambar (" . round($fileSizeInMB, 1) . "MB): " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.style.ai-recommendation')->layout('layouts.app');
    }
}
