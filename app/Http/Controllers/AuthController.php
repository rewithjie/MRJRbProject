<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle student login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        $maxAttempts = 3;
        $lockoutSeconds = 10; // 10 seconds
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return redirect()->back()
                ->with('error', "Too many login attempts. Please try again in {$seconds} seconds.")
                ->withInput($request->only('email'));
        }

        $student = Student::with('userAccount')
            ->where('email', $request->email)
            ->orWhereHas('userAccount', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            RateLimiter::hit($throttleKey, $lockoutSeconds);
            $attempts = RateLimiter::attempts($throttleKey);
            $remaining = max($maxAttempts - $attempts, 0);

            Log::warning('Failed login attempt', [
                'email' => $request->email,
                'remaining_attempts' => $remaining,
                'timestamp' => now(),
            ]);

            return redirect()->back()
                ->with('error', "Invalid email or password. {$remaining} attempt(s) remaining.")
                ->withInput($request->only('email'));
        }

        RateLimiter::clear($throttleKey);

        $studentEmail = $student->email ?? $student->userAccount?->email ?? $request->email;

        // Store student info in session
        Session::put('student_id', $student->id);
        Session::put('student_name', $student->fname . ' ' . $student->mname . ' ' . $student->lname);
        Session::put('student_email', $studentEmail);

        Log::info('Student login successful', [
            'student_id' => $student->id,
            'email' => $studentEmail,
            'timestamp' => now(),
        ]);

        return redirect()->route('home')
            ->with('success', 'Welcome ' . $student->fname);
    }

    /**
     * Show student home dashboard/chat page.
     */
    public function homeDashboard()
    {
        if (!Session::has('student_id')) {
            return redirect()->route('student.login.show');
        }

        $student = Student::with(['degree', 'userAccount'])->find(Session::get('student_id'));

        if (!$student) {
            Session::flush();
            return redirect()->route('student.login.show');
        }

        $studentEmail = $student->email ?? $student->userAccount?->email ?? Session::get('student_email');
        Session::put('student_email', $studentEmail);

        return view('student.home', [
            'student' => $student,
            'studentEmail' => $studentEmail,
        ]);
    }

    /**
     * Show student account dashboard page.
     */
    public function dashboard()
    {
        if (!Session::has('student_id')) {
            return redirect()->route('student.login.show');
        }

        $student = Student::with(['degree', 'userAccount'])->find(Session::get('student_id'));

        if (!$student) {
            Session::flush();
            return redirect()->route('student.login.show');
        }

        $studentEmail = $student->email ?? $student->userAccount?->email ?? Session::get('student_email');
        Session::put('student_email', $studentEmail);

        return view('student.dashboard', [
            'student' => $student,
            'studentEmail' => $studentEmail,
        ]);
    }

    /**
     * Change student password.
     */
    public function changePassword(Request $request)
    {
        if (!Session::has('student_id')) {
            return redirect()->route('student.login.show')
                ->with('error', 'Please login to continue.');
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password|confirmed',
        ], [
            'old_password.required' => 'Old password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 6 characters.',
            'new_password.different' => 'New password must be different from old password.',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ]);

        $student = Student::find(Session::get('student_id'));

        if (!$student) {
            Session::flush();
            return redirect()->route('student.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        if (!$student->password || !Hash::check($request->old_password, $student->password)) {
            return redirect()->route('student.dashboard')
                ->withErrors(['old_password' => 'Old password is incorrect.'])
                ->withInput();
        }

        $student->password = $request->new_password;
        $student->save();

        Log::info('Student password changed', [
            'student_id' => $student->id,
            'timestamp' => now(),
        ]);

        return redirect()->route('student.home')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Handle student logout
     */
    public function logout()
    {
        Log::info('Student logout', [
            'student_id' => Session::get('student_id'),
            'email' => Session::get('student_email'),
            'timestamp' => now(),
        ]);

        Session::flush();
        return redirect()->route('student.login.show')
            ->with('success', 'You have been logged out successfully');
    }
}
