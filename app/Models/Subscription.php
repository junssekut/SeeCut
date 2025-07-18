<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function subscriptions() {
        return $this->hasMany(VendorSubscription::class);
    }
}
