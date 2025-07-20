<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    //
    protected $table = 'vendor_reviews';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function photos() {
        return $this->hasMany(VendorReviewPhoto::class, 'review_id');
    }
}
