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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create();
        });
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function vendor() {
        return $this->hasOne(Vendor::class);
    }

    // public function getFilamentName(): string
    // {
    //     return "{$this->profile->first_name} {$this->profile->last_name}";
    // }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     switch ($panel->getId()) {
    //         case "vendor":
    //             return $this->profile->role == 'vendor';
    //         case "admin":
    //             break;
    //         default:
    //             break;
    //     }

    //     return false;
    // }
}
