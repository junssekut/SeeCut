<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    //
    protected $table = 'profile_images';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
