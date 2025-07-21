<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPhoto extends Model
{
    protected $table = 'vendor_photos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
        'vendor_id',
        'type',
        'category', 
        'source'
    ];

    public function vendor() {
        // Photo belongs to a vendor
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorsUsingAsThumbnail() {
        // Photos can be referenced as thumbnails by vendors
        return $this->hasMany(Vendor::class, 'thumbnail_id');
    }
    
    public function hairstylists() {
        // Photos can be used by hairstylists
        return $this->hasMany(VendorHairstylist::class, 'image_id');
    }
}
