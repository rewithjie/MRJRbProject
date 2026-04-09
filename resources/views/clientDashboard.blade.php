@extends('format.layout')

@section('title', 'Home - Student Management Dashboard')

@section('Content')
    <h1>Welcome to Student Management Dashboard</h1>
    <p>This is a comprehensive platform to manage and view student records easily and efficiently.</p>
    
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('students.index') }}">Go to Students</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
    </ul>
@endsection