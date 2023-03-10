<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class password_reset extends Model
{
    protected $fillable = [
        'email', 'token'
    ];

    protected $hidden = [];
}
