@extends('format.layout')

@section('title', 'Admin Dashboard')

@section('Content')
    <style>
        .admin-dashboard-header {
            margin-bottom: 2rem;
        }

        .admin-dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
            color: #d4af37;
        }

        .logged-account {
            margin-top: 0.5rem;
            color: #b8b8b8;
            font-size: 1rem;
        }

        .logged-account strong {
            color: #d4af37;
        }

        .stat-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
            border-left: 4px solid #d4af37;
            padding: 1.5rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .stat-card h3 {
            color: #d4af37;
            font-size: 2rem;
            margin: 0.5rem 0;
        }

        .stat-card p {
            color: #b8b8b8;
            margin: 0;
        }

        .action-card {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .action-card h4 {
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .btn-action {
            background-color: #d4af37;
            color: #0d0d0d;
            border: none;
            font-weight: bold;
            padding: 0.75rem 2rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-action:hover {
            background-color: #f0c857;
            color: #0d0d0d;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }
    </style>

    <div class="container py-4">
        <div class="admin-dashboard-header">
            <h1><i class="fas fa-shield-alt"></i> Admin Dashboard</h1>
            <p class="logged-account mb-0">
                Logged in as: <strong>{{ Session::get('admin_name') }}</strong>
                ({{ Session::get('admin_email') }}) - <span style="text-transform: uppercase;">{{ Session::get('admin_role') }}</span>
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Section -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-users" style="color: #d4af37; font-size: 2rem;"></i>
                    <h3>{{ $totalStudents }}</h3>
                    <p>Total Students</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-chalkboard-user" style="color: #d4af37; font-size: 2rem;"></i>
                    <h3>{{ $totalTeachers }}</h3>
                    <p>Total Teachers</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-user-check" style="color: #d4af37; font-size: 2rem;"></i>
                    <h3>{{ $activeStudents }}</h3>
                    <p>Active Students</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-chalkboard-user" style="color: #d4af37; font-size: 2rem;"></i>
                    <h3>{{ $activeTeachers }}</h3>
                    <p>Active Teachers</p>
                </div>
            </div>
        </div>

        <!-- Management Section -->
        <div class="row">
            <!-- Student Management -->
            <div class="col-md-6">
                <div class="action-card">
                    <i class="fas fa-users" style="color: #d4af37; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <h4><i class="fas fa-graduation-cap"></i> Student Management</h4>
                    <p style="margin-bottom: 1.5rem;">Manage all students in the system</p>
                    <a href="{{ route('admin.manage.students') }}" class="btn-action me-2">
                        <i class="fas fa-list"></i> View All Students
                    </a>
                    <a href="{{ route('admin.add.student') }}" class="btn-action">
                        <i class="fas fa-plus"></i> Add New Student
                    </a>
                </div>
            </div>

            <!-- Teacher Management -->
            <div class="col-md-6">
                <div class="action-card">
                    <i class="fas fa-chalkboard-user" style="color: #d4af37; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <h4><i class="fas fa-book"></i> Teacher Management</h4>
                    <p style="margin-bottom: 1.5rem;">Manage all teachers in the system</p>
                    <a href="{{ route('admin.manage.teachers') }}" class="btn-action me-2">
                        <i class="fas fa-list"></i> View All Teachers
                    </a>
                    <a href="{{ route('admin.add.teacher') }}" class="btn-action">
                        <i class="fas fa-plus"></i> Add New Teacher
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Account Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="action-card">
                    <h4><i class="fas fa-key"></i> Change Password</h4>
                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                            @error('old_password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                            @error('new_password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn-action">
                            <i class="fas fa-check"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="action-card">
                    <h4><i class="fas fa-sign-out-alt"></i> Account</h4>
                    <p><strong>Admin Name:</strong> {{ $admin->name }}</p>
                    <p><strong>Email:</strong> {{ $admin->email }}</p>
                    <p><strong>Role:</strong> <span class="badge bg-info" style="text-transform: uppercase;">{{ $admin->role }}</span></p>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-action btn-warning">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
