<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Show the teacher login form
     */
    public function showLogin()
    {
        return view('auth.teacher_login');
    }

    /**
     * Handle teacher login
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

        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            Log::warning('Teacher login failed', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);
            return redirect()->route('teacher.login.show')
                ->with('error', 'Invalid email or password');
        }

        if (!$teacher->is_active) {
            Log::warning('Inactive teacher login attempt', [
                'teacher_id' => $teacher->id,
                'email' => $teacher->email,
            ]);
            return redirect()->route('teacher.login.show')
                ->with('error', 'Your account has been deactivated');
        }

        Session::put('teacher_id', $teacher->id);
        Session::put('teacher_email', $teacher->email);
        Session::put('teacher_name', "{$teacher->fname} {$teacher->lname}");

        Log::info('Teacher login successful', [
            'teacher_id' => $teacher->id,
            'email' => $teacher->email,
        ]);

        return redirect()->route('teacher.home')
            ->with('success', 'Login successful! Welcome back.');
    }

    /**
     * Show teacher dashboard
     */
    public function dashboard()
    {
        $teacherId = Session::get('teacher_id');
        $teacher = Teacher::find($teacherId);

        if (!$teacher) {
            Session::flush();
            return redirect()->route('teacher.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        return view('teacher.dashboard', ['teacher' => $teacher]);
    }

    /**
     * Show teacher home page
     */
    public function homeDashboard()
    {
        $teacherId = Session::get('teacher_id');
        $teacher = Teacher::find($teacherId);

        if (!$teacher) {
            Session::flush();
            return redirect()->route('teacher.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        return view('teacher.home', ['teacher' => $teacher]);
    }

    /**
     * Handle teacher logout
     */
    public function logout()
    {
        Log::info('Teacher logout', [
            'teacher_id' => Session::get('teacher_id'),
        ]);

        Session::flush();

        return redirect()->route('teacher.login.show')
            ->with('success', 'Logged out successfully');
    }

    /**
     * Change teacher password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ]);

        $teacher = Teacher::find(Session::get('teacher_id'));

        if (!$teacher) {
            Session::flush();
            return redirect()->route('teacher.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        if (!Hash::check($request->old_password, $teacher->password)) {
            return redirect()->route('teacher.home')
                ->withErrors(['old_password' => 'Old password is incorrect.'])
                ->withInput();
        }

        $teacher->password = $request->new_password;
        $teacher->save();

        Log::info('Teacher password changed', [
            'teacher_id' => $teacher->id,
            'timestamp' => now(),
        ]);

        return redirect()->route('teacher.home')
            ->with('success', 'Password changed successfully.');
    }
}
