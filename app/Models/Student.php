<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAccount;

class Student extends Model
{
    protected $fillable = [
        'fname', 
        'mname', 
        'lname', 
        'email',
        'password',
        'contact_no', 
        'degree_id',
        'user_account_id'
    ];

    protected $hidden = [
        'password',
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
     * Get the degree for the student.
     */
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * Linked login/account details for this student.
     */
    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class);
    }

    /**
     * Get the courses for the student.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_students', 'student_id', 'course_id');
    }

    public function degrees() {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
