<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'fname', 
        'mname', 
        'lname', 
        'email', 
        'password',
        'contact_no', 
        'degree_id'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the degree for the student.
     */
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
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