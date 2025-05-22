<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'number',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
