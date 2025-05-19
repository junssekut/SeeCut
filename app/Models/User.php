<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username', 'email', 'password', 'role', 'name', 'telephone'
    ];

    protected $hidden = ['password'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'user_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'user_id');
    }
}
