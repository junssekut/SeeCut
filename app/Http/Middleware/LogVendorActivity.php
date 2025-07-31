<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VendorActivity;
use Illuminate\Support\Facades\Auth;

class LogVendorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log for authenticated vendor users
        if (Auth::check() && Auth::user()->profile && Auth::user()->profile->role === 'vendor') {
            $this->logActivity($request);
        }

        return $response;
    }

    private function logActivity(Request $request)
    {
        try {
            $user = Auth::user();
            $path = $request->path();
            $method = $request->method();
            
            // Skip logging for certain paths to avoid spam
            $skipPaths = [
                'livewire/message',
                'api/',
                'assets/',
                'vendor/',
                'storage/',
            ];
            
            foreach ($skipPaths as $skipPath) {
                if (str_starts_with($path, $skipPath)) {
                    return;
                }
            }

            // Determine activity based on the route
            $activityData = $this->getActivityData($path, $method, $request);
            
            if ($activityData) {
                VendorActivity::log(
                    $user->id,
                    $activityData['type'],
                    $activityData['description'],
                    $activityData['entity_type'] ?? null,
                    $activityData['entity_id'] ?? null,
                    [
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        'url' => $request->fullUrl(),
                        'method' => $method,
                        'route_name' => $request->route()?->getName(),
                    ]
                );
            }
        } catch (\Exception $e) {
            // Don't fail the request if logging fails
            \Log::error('Failed to log vendor activity in middleware: ' . $e->getMessage());
        }
    }

    private function getActivityData(string $path, string $method, Request $request): ?array
    {
        // Map common vendor paths to activities
        $pathMappings = [
            'vendor/profile' => [
                'type' => 'update',
                'description' => 'Mengakses halaman profil',
                'entity_type' => 'profile'
            ],
            'vendor/reservation' => [
                'type' => 'update',
                'description' => 'Mengelola reservasi pelanggan',
                'entity_type' => 'reservation'
            ],
            'vendor/services' => [
                'type' => 'update',
                'description' => 'Mengelola layanan barbershop',
                'entity_type' => 'service'
            ],
            'vendor/operating-hours' => [
                'type' => 'update',
                'description' => 'Mengatur jam operasional',
                'entity_type' => 'operating_hours'
            ],
            'vendor/hairstylists' => [
                'type' => 'update',
                'description' => 'Mengelola data hairstylist',
                'entity_type' => 'hairstylist'
            ]
        ];

        // Check if path matches any of our mappings
        foreach ($pathMappings as $mappedPath => $activity) {
            if (str_contains($path, $mappedPath)) {
                return $activity;
            }
        }

        // For login/logout, we'll handle these in the auth events instead
        return null;
    }
}
