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

    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = ['password'];
    public $timestamps = false;

    public function profile() {
        return $this->hasOne(Profile::class);
    }
}
