@extends('format.layout')

@section('title', 'Home - Student Management Dashboard')

@section('Content')
    <div class="section-label">Student Management System</div>
    
    <h1>Welcome to the <span class="highlight">Student</span><br>Management Dashboard</h1>
    
    <p class="subtitle">A comprehensive platform to manage and view student records easily and efficiently.</p>
    
    <div class="divider"></div>

    <div class="dashboard-grid">
        <a href="{{ route('student.dashboard') }}" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="card-title">Student Dashboard</div>
            <div class="card-description">Open the student home dashboard</div>
        </a>

        <a href="{{ route('students.index') }}" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="card-title">Students</div>
            <div class="card-description">View and manage all student records</div>
        </a>

        <a href="{{ route('degrees.index') }}" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="card-title">Degrees</div>
            <div class="card-description">Manage degree programs and courses</div>
        </a>

        <a href="{{ route('logs') }}" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="card-title">Logs</div>
            <div class="card-description">Track system activity and changes</div>
        </a>

        <a href="{{ route('about') }}" class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="card-title">About</div>
            <div class="card-description">Project info and documentation</div>
        </a>
    </div>
@endsection
