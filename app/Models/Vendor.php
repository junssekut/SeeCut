<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $primaryKey = 'vendor_id';

    protected $fillable = [
        'name', 'telephone', 'description', 'location'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'vendor_id', 'vendor_id');
    }
}
