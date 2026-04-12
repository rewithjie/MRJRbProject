<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        Student::create([
                'fname'=>$request->input('fname'),
                'mname'=>$request->input('mname'),
                'lname'=>$request->input('lname'),
                'email' => $request->input('email'),
                'contact_no'=>$request->input('contact_no'),
                'degree_id' => $request->input('degree_id'),
        ]);

        $msg = "Student is Added!";
        Log::info($msg);
        Log::notice($msg);
        Log::alert($msg);
        Log::emergency($msg);
        Log::critical($msg);
        Log::error($msg);
        Log::warning($msg);
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

        $student->update([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'contact_no' => $request->input('contact_no'),
            'degree_id' => $request->input('degree_id'),
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

        $student->delete();

        return redirect()->route('students.index')
                        ->with('success', 'Student deleted successfully!');
    }
}
