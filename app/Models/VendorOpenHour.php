<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorOpenHour extends Model
{
    //
    protected $table = 'vendor_open_hours';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
