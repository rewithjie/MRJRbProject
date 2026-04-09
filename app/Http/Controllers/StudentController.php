<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::paginate(10);
        return view('students.index', ['students' => $students]);
    }

    public function home()
    {
        return view('clientDashboard');
    }

    public function about()
    {
        return view('clientAboutUs');
    }

    public function create()
    {
        $degrees = \App\Models\Degree::all();
        return view('students.create', ['degrees' => $degrees]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|min:3|max:255',
            'mname' => 'required|string|max:1',
            'lname' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6|max:20',
            'contact_no' => 'required|string|max:20',
            'degree_id' => 'nullable|exists:degrees,id',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not be greater than 20 characters.',
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 3 characters.',
            'mname.required' => 'Middle initial is required.',
            'mname.max' => 'Middle initial must be a single letter.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 3 characters.',
            'contact_no.required' => 'Contact number is required.',
        ]);

        if ($validator->fails()) {
            Log::warning('Student create validation failed.', [
                'errors' => $validator->errors()->toArray(),
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $student = Student::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_no' => $request->contact_no,
            'degree_id' => $request->degree_id,
        ]);

        Log::info('Student created successfully.', [
            'student_id' => $student->id,
            'email' => $student->email,
            'ip' => $request->ip(),
        ]);

        ActivityLog::create([
            'action' => 'created',
            'entity_type' => 'Student',
            'entity_id' => $student->id,
            'user_email' => $student->email,
            'message' => "Student {$student->fname} {$student->lname} created successfully",
            'data' => [
                'fname' => $student->fname,
                'lname' => $student->lname,
                'email' => $student->email,
                'contact_no' => $student->contact_no,
            ],
            'ip_address' => $request->ip(),
            'status' => 'success',
        ]);

        return redirect()->route('students.index')
                        ->with('success', 'Student created successfully!');
    }

    public function show(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            Log::notice('Student view failed. Student not found.', ['student_id' => $id]);
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }
        
        return view('students.show', ['student' => $student]);
    }

    public function edit(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            Log::notice('Student edit failed. Student not found.', ['student_id' => $id]);
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        $degrees = \App\Models\Degree::all();
        return view('students.edit', ['student' => $student, 'degrees' => $degrees]);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            Log::notice('Student update failed. Student not found.', ['student_id' => $id]);
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|min:3|max:255',
            'mname' => 'required|string|max:1',
            'lname' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'nullable|string|min:6|max:20',
            'contact_no' => 'required|string|max:20',
            'degree_id' => 'nullable|exists:degrees,id',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.max' => 'Password must not be greater than 20 characters.',
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 3 characters.',
            'mname.required' => 'Middle initial is required.',
            'mname.max' => 'Middle initial must be a single letter.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 3 characters.',
            'contact_no.required' => 'Contact number is required.',
        ]);

        if ($validator->fails()) {
            Log::warning('Student update validation failed.', [
                'student_id' => $id,
                'errors' => $validator->errors()->toArray(),
                'email' => $request->input('email'),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payload = [
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'degree_id' => $request->degree_id,
        ];

        if ($request->filled('password')) {
            $payload['password'] = Hash::make($request->password);
        }

        $student->update($payload);

        Log::info('Student updated successfully.', [
            'student_id' => $student->id,
            'email' => $student->email,
            'password_updated' => $request->filled('password'),
            'ip' => $request->ip(),
        ]);

        ActivityLog::create([
            'action' => 'updated',
            'entity_type' => 'Student',
            'entity_id' => $student->id,
            'user_email' => $student->email,
            'message' => "Student {$student->fname} {$student->lname} updated successfully",
            'data' => [
                'fname' => $student->fname,
                'lname' => $student->lname,
                'email' => $student->email,
                'contact_no' => $student->contact_no,
                'password_updated' => $request->filled('password'),
            ],
            'ip_address' => $request->ip(),
            'status' => 'success',
        ]);

        return redirect()->route('students.show', $student->id)
                        ->with('success', 'Student updated successfully!');
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            Log::notice('Student delete failed. Student not found.', ['student_id' => $id]);
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        Log::info('Student deleted successfully.', [
            'student_id' => $student->id,
            'email' => $student->email,
        ]);

        ActivityLog::create([
            'action' => 'deleted',
            'entity_type' => 'Student',
            'entity_id' => $student->id,
            'user_email' => $student->email,
            'message' => "Student {$student->fname} {$student->lname} deleted successfully",
            'data' => [
                'fname' => $student->fname,
                'lname' => $student->lname,
                'email' => $student->email,
            ],
            'ip_address' => request()->ip(),
            'status' => 'success',
        ]);

        $student->delete();

        return redirect()->route('students.index')
                        ->with('success', 'Student deleted successfully!');
    }
}
