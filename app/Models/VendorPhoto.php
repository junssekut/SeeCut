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

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
