<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;

class PageController extends Controller
{
    public function userProfile()
    {
        $user = User::with('profile')->find(1);
        return response($user?->profile?->bio ?? 'No bio yet.');
    }

    public function userPosts()
    {
        $user = User::with('posts')->find(1);

        if (!$user) {
            return response('No user found.');
        }

        if ($user->posts->isEmpty()) {
            return response('No posts found.');
        }

        $output = $user->posts
            ->map(fn ($post) => "{$post->title}<br>" . ($post->content ?? 'No content.') . "<br>")
            ->implode('<br>');

        return response($output);   
    }

    public function studentCourse() {
        $student = Student::find(1);
        
        if (!$student) {
            return response('No student found.');
        }
        
        $output = '';
        foreach ($student->courses as $course) {
            $output .= "{$student->fname} {$student->lname} is enrolled in: {$course->course_name}<br>";
        }
        
        return response($output ?: 'No courses enrolled.');
    }

    public function enrolledStudents() {
        // Display all courses with their enrolled students from real data
        $courses = Course::with('students')->get();
        
        if ($courses->isEmpty()) {
            return response('No courses found in database.');
        }
        
        $output = '<h2>Course Enrollment</h2>';
        foreach ($courses as $course) {
            $output .= "<b>{$course->course_name}</b> (ID: {$course->id})<br>";
            
            if ($course->students->isEmpty()) {
                $output .= "&nbsp;&nbsp;- No students enrolled<br>";
            } else {
                foreach ($course->students as $student) {
                    $output .= "&nbsp;&nbsp;- {$student->fname} {$student->lname} (ID: {$student->id})<br>";
                }
            }
            $output .= "<br>";
        }
        
        return response($output);
    }

    public function setupTestData() {
    
        }
    }