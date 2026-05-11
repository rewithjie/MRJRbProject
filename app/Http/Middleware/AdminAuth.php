<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
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
        // Check if admin is logged in
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login.show')
                ->with('error', 'Please login to access the admin dashboard');
        }

        return $next($request);
    }
}
