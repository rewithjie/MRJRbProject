<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_active'
    ];

    // // protected $hidden = [
    // //     'password',
    // ];
}
