<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentAuth
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
        // Check if student is logged in
        if (!Session::has('student_id')) {
            return redirect()->route('student.login.show')
                ->with('error', 'Please login to access the dashboard');
        }

        return $next($request);
    }
}
