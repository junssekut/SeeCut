<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    //
    protected $table = 'reservation_slots';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
