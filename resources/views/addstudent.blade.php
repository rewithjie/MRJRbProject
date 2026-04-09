*@extends('format.layout')

@section('title', 'Students - Student Management Dashboard')

@section('Content')
    <h1>Add Student</h1>
    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        First Name: <input type="text" name="fname"><br>
        Middle Name: <input type="text" name="mname"><br>
        Last Name: <input type="text" name="lname"><br>
        Email: <input type="email" name="email"><br>
        Contact No.: <input type="text" name="contact_no"><br>
        <input type="submit" value="Submit">
    </form>
    @endsection