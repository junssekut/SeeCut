<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    //
    protected $table = 'vendor_services';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
