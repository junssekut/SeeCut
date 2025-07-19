<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorHairstylist extends Model
{
    //
    protected $table = 'vendor_hairstylists';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function vendorPhoto() {
        return $this->belongsTo(VendorPhoto::class, 'image_id');
    }
}
