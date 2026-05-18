<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLogin()
    {
        return view('auth.admin_login');
    }

    /**
     * Handle admin login
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

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            Log::warning('Admin login failed', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);
            return redirect()->route('admin.login.show')
                ->with('error', 'Invalid email or password');
        }

        if (!$admin->is_active) {
            Log::warning('Inactive admin login attempt', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
            ]);
            return redirect()->route('admin.login.show')
                ->with('error', 'Your account has been deactivated');
        }

        Session::put('admin_id', $admin->id);
        Session::put('admin_email', $admin->email);
        Session::put('admin_name', $admin->name);
        Session::put('admin_role', $admin->role);

        Log::info('Admin login successful', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Login successful! Welcome back.');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $adminId = Session::get('admin_id');
        $admin = Admin::find($adminId);

        if (!$admin) {
            Session::flush();
            return redirect()->route('admin.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $activeStudents = Student::count();
        $activeTeachers = Teacher::where('is_active', true)->count();

        return view('admin.dashboard', [
            'admin' => $admin,
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'activeStudents' => $activeStudents,
            'activeTeachers' => $activeTeachers,
        ]);
    }

    /**
     * Show all students management page
     */
    public function manageStudents()
    {
        $students = Student::paginate(10);
        return view('admin.manage_students', ['students' => $students]);
    }

    /**
     * Show add student form
     */
    public function addStudentForm()
    {
        return view('admin.add_student');
    }

    /**
     * Store new student
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'fname' => 'required|min:2',
            'mname' => 'required|min:2',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:students,email',
            'contact_no' => 'required|digits:11',
            'password' => 'required|min:8|confirmed',
            'degree_id' => 'required|exists:degrees,id',
        ]);

        $student = Student::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'password' => $request->password,
            'degree_id' => $request->degree_id,
            'role' => 'student',
            'must_change_password' => true,
        ]);

        Log::info('Student created by admin', [
            'student_id' => $student->id,
            'admin_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.manage.students')
            ->with('success', 'Student added successfully!');
    }

    /**
     * Show all teachers management page
     */
    public function manageTeachers()
    {
        $teachers = Teacher::paginate(10);
        return view('admin.manage_teachers', ['teachers' => $teachers]);
    }

    /**
     * Show add teacher form
     */
    public function addTeacherForm()
    {
        return view('admin.add_teacher');
    }

    /**
     * Store new teacher
     */
    public function storeTeacher(Request $request)
    {
        $request->validate([
            'fname' => 'required|min:2',
            'mname' => 'required|min:2',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:teachers,email',
            'contact_no' => 'required|digits:11',
            'password' => 'required|min:8|confirmed',
            'specialty' => 'nullable|min:2',
            'department' => 'required|min:2',
        ]);

        $teacher = Teacher::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'password' => $request->password,
            'specialty' => $request->specialty,
            'department' => $request->department,
            'is_active' => true,
            'must_change_password' => true,
        ]);

        Log::info('Teacher created by admin', [
            'teacher_id' => $teacher->id,
            'admin_id' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.manage.teachers')
            ->with('success', 'Teacher added successfully!');
    }

    /**
     * Delete student
     */
    public function deleteStudent($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('admin.manage.students')
                ->with('error', 'Student not found.');
        }

        Log::info('Student deleted by admin', [
            'student_id' => $id,
            'admin_id' => Session::get('admin_id'),
        ]);

        $student->delete();

        return redirect()->route('admin.manage.students')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Delete teacher
     */
    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return redirect()->route('admin.manage.teachers')
                ->with('error', 'Teacher not found.');
        }

        Log::info('Teacher deleted by admin', [
            'teacher_id' => $id,
            'admin_id' => Session::get('admin_id'),
        ]);

        $teacher->delete();

        return redirect()->route('admin.manage.teachers')
            ->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Handle admin logout
     */
    public function logout()
    {
        Log::info('Admin logout', [
            'admin_id' => Session::get('admin_id'),
        ]);

        Session::flush();
        $request = request();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.show')
            ->with('success', 'Logged out successfully')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->header('Clear-Site-Data', '"cache"');
    }

    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $admin = Admin::find(Session::get('admin_id'));

        if (!$admin) {
            Session::flush();
            return redirect()->route('admin.login.show')
                ->with('error', 'Session expired. Please login again.');
        }

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->route('admin.dashboard')
                ->withErrors(['old_password' => 'Old password is incorrect.'])
                ->withInput();
        }

        $admin->password = $request->new_password;
        $admin->save();

        Log::info('Admin password changed', [
            'admin_id' => $admin->id,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Password changed successfully.');
    }
}
