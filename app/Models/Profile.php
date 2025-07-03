<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        return $this->hasOne(ProfileImage::class);
    }
}
