<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorActivity extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id',
        'activity_type',
        'activity_description',
        'entity_type',
        'entity_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship with vendor (user)
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Helper method to log activities
    public static function log($vendorId, $activityType, $description, $entityType = null, $entityId = null, $metadata = [])
    {
        return self::create([
            'vendor_id' => $vendorId,
            'activity_type' => $activityType,
            'activity_description' => $description,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'metadata' => $metadata
        ]);
    }

    // Scope for recent activities
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Scope for specific activity types
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }
}
