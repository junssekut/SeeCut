<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $table = 'vendors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function photos() {
        return $this->hasMany(VendorPhoto::class);
    }

    public function openHours() {
        return $this->hasMany(VendorOpenHour::class);
    }

    public function reviews() {
        return $this->hasMany(VendorReview::class);
    }

    public function services() {
        return $this->hasMany(VendorService::class);
    }

    public function subscription() {
        return $this->hasOne(VendorSubscription::class)->latest();
    }

    public function subscriptions() {
        return $this->hasMany(VendorSubscription::class);
    }
}
