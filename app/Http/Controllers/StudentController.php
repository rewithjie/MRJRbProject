<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $students = Student::paginate(10);
        } catch (\Throwable $e) {
            Log::error('Unable to load students list due to database connection issue.', [
                'error' => $e->getMessage(),
            ]);

            // Keep the page usable even when the DB server is temporarily unavailable.
            $students = new LengthAwarePaginator(
                collect(),
                0,
                10,
                (int) $request->query('page', 1),
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            return view('students.index', ['students' => $students])
                ->with('error', 'Database connection failed. Please start MySQL and try again.');
        }

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
        // $validated = $request->validate([
        //     'fname' => 'required|min:2',
        //     //'mname' => 'required|string|max:1',
        //     'lname' => 'required|min:2',
        //     'email' => 'required|email|unique:students,email',
        //     'contact_no' => 'required',
        //     'degree_id' => 'required'
        // ]);
    $validator = Validator::make($request->all(),[
            'fname' => 'required|min:2',
            //'mname' => 'required|string|max:1',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:students,email',
            'contact_no' => 'required|digits:11',
            'degree_id' => 'required'

        ]);

        if ($validator->fails()){
            return redirect ()->back()->withErrors($validator)->withInput();
        }

        $student = Student::create([
                'fname'=>$request->input('fname'),
                'mname'=>$request->input('mname'),
                'lname'=>$request->input('lname'),
                'email' => $request->input('email'),
                'contact_no'=>$request->input('contact_no'),
                'degree_id' => $request->input('degree_id'),
        ]);

        // Log the new student creation with degree information
        Log::info('Student created successfully', [
            'student_id' => $student->id,
            'student_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'email' => $student->email,
            'contact_no' => $student->contact_no,
            'degree' => $student->degree?->title ?? 'N/A',
            'degree_id' => $student->degree_id,
            'timestamp' => now(),
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        return view('students.show', ['student' => $student]);
    }

    public function edit(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
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
            return redirect('/students')->with('error', 'Student not found!');
        }

        $validator = Validator::make($request->all(), [
            'fname' => 'required|min:2',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:students,email,' . $id,
            'contact_no' => 'required|digits:11',
            'degree_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Capture old values before update for logging
        $oldDegree = $student->degree?->title ?? 'N/A';
        $oldName = $student->fname . ' ' . $student->mname . ' ' . $student->lname;
        $oldEmail = $student->email;
        $oldPhone = $student->contact_no;

        $student->update([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'contact_no' => $request->input('contact_no'),
            'degree_id' => $request->input('degree_id'),
        ]);

        // Log the student update with before/after details
        $student->refresh(); // Refresh to get updated degree relationship
        Log::info('Student updated successfully', [
            'student_id' => $student->id,
            'old_name' => $oldName,
            'new_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'old_email' => $oldEmail,
            'new_email' => $student->email,
            'old_phone' => $oldPhone,
            'new_phone' => $student->contact_no,
            'old_degree' => $oldDegree,
            'new_degree' => $student->degree?->title ?? 'N/A',
            'timestamp' => now(),
        ]);

        return redirect()->route('students.show', $student)->with('message', 'Student Updated Successfully');
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        // Capture student details before deletion for logging
        $deletedStudentData = [
            'student_id' => $student->id,
            'student_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'email' => $student->email,
            'contact_no' => $student->contact_no,
            'degree' => $student->degree?->title ?? 'N/A',
            'degree_id' => $student->degree_id,
        ];

        $student->delete();

        // Log the student deletion
        Log::warning('Student deleted', array_merge($deletedStudentData, [
            'timestamp' => now(),
        ]));

        return redirect()->route('students.index')
                        ->with('success', 'Student deleted successfully!');
    }
}
