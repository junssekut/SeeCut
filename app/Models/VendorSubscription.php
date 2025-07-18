<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorSubscription extends Model
{
    protected $table = 'vendor_subscriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'vendor_id',
        'subscription_id', 
        'start_date',
        'end_date'
    ];
    
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}
