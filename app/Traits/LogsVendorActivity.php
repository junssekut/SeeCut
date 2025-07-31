<?php

namespace App\Traits;

use App\Models\VendorActivity;
use Illuminate\Support\Facades\Auth;

trait LogsVendorActivity
{
    /**
     * Log a vendor activity
     *
     * @param string $activityType The type of activity (update, create, confirm, upload, etc.)
     * @param string $description Human readable description of the activity
     * @param string|null $entityType The type of entity being acted upon (profile, service, photo, etc.)
     * @param int|null $entityId The ID of the entity being acted upon
     * @param array $metadata Additional metadata about the activity
     * @param int|null $vendorId Override vendor ID (if not using current user)
     * @return VendorActivity|null
     */
    public function logVendorActivity(
        string $activityType,
        string $description,
        ?string $entityType = null,
        ?int $entityId = null,
        array $metadata = [],
        ?int $vendorId = null
    ): ?VendorActivity {
        try {
            // If no vendor ID provided, try to get from current user
            if (!$vendorId) {
                $user = Auth::user();
                if (!$user || !$user->profile || $user->profile->role !== 'vendor') {
                    return null; // Only log for vendor users
                }
                $vendorId = $user->id;
            }

            // Add request metadata
            $defaultMetadata = [
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
            ];

            $finalMetadata = array_merge($defaultMetadata, $metadata);

            return VendorActivity::log(
                $vendorId,
                $activityType,
                $description,
                $entityType,
                $entityId,
                $finalMetadata
            );
        } catch (\Exception $e) {
            // Log the error but don't fail the main operation
            \Log::error('Failed to log vendor activity: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Predefined activity types for consistency
     */
    public const ACTIVITY_UPDATE = 'update';
    public const ACTIVITY_CREATE = 'create';
    public const ACTIVITY_CONFIRM = 'confirm';
    public const ACTIVITY_UPLOAD = 'upload';
    public const ACTIVITY_DELETE = 'delete';
    public const ACTIVITY_LOGIN = 'login';
    public const ACTIVITY_LOGOUT = 'logout';

    /**
     * Predefined entity types for consistency
     */
    public const ENTITY_PROFILE = 'profile';
    public const ENTITY_SERVICE = 'service';
    public const ENTITY_PHOTO = 'photo';
    public const ENTITY_RESERVATION = 'reservation';
    public const ENTITY_PAYMENT = 'payment';
    public const ENTITY_SCHEDULE = 'schedule';
    public const ENTITY_HAIRSTYLIST = 'hairstylist';
    public const ENTITY_OPERATING_HOURS = 'operating_hours';
    public const ENTITY_PROMOTION = 'promotion';
    public const ENTITY_DOCUMENT = 'document';
}
