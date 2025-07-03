<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReviewPhoto extends Model
{
    //
    protected $table = 'vendor_review_photos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function review() {
        return $this->belongsTo(VendorReview::class);
    }
}
