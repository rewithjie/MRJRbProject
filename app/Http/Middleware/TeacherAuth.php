<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeacherAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if teacher is logged in
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login.show')
                ->with('error', 'Please login to access the teacher dashboard');
        }

        return $next($request);
    }
}
