<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Teacher extends Model
{
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'contact_no',
        'password',
        'specialty',
        'department',
        'is_active',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'must_change_password' => 'boolean',
    ];

    /**
     * Mutator to hash password when setting it
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Get teacher's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->lname}, {$this->fname} {$this->mname}";
    }
}
