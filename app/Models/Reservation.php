<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function slot() {
        return $this->belongsTo(ReservationSlot::class, 'reservation_id');
    }
}
