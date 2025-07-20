<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPhoto extends Model
{
    //
    protected $table = 'vendor_photos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendors() {
        // Photos can be referenced as thumbnails by vendors
        return $this->hasMany(Vendor::class, 'thumbnail_id');
    }
    
    public function hairstylists() {
        // Photos can be used by hairstylists
        return $this->hasMany(VendorHairstylist::class, 'image_id');
    }
}
