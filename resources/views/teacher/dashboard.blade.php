@extends('format.layout')

@section('title', 'Teacher Dashboard')

@section('Content')
    <style>
        .teacher-dashboard {
            background-color: #0d0d0d;
            color: #b8b8b8;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #d4af37;
        }

        .dashboard-header h1 {
            color: #d4af37;
            margin: 0;
        }

        .logout-btn {
            background-color: #d4af37;
            color: #0d0d0d;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #f0c857;
        }

        .menu-sidebar {
            background-color: #1a1a1a;
            border-right: 1px solid #333;
            padding: 1.5rem;
            border-radius: 5px;
        }

        .menu-item {
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            color: #b8b8b8;
            text-decoration: none;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: #242424;
            color: #d4af37;
            border-left: 3px solid #d4af37;
        }

        .content-area {
            background-color: #1a1a1a;
            padding: 2rem;
            border-radius: 5px;
        }

        .teacher-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .info-card {
            background-color: #242424;
            padding: 1rem;
            border-left: 3px solid #d4af37;
            border-radius: 3px;
        }

        .info-label {
            color: #d4af37;
            font-weight: bold;
        }

        .info-value {
            color: #b8b8b8;
            margin-top: 0.5rem;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="dashboard-header">
            <div>
                <h1>Teacher Dashboard</h1>
                <p style="color: #b8b8b8; margin: 0;">Welcome back, <strong style="color: #d4af37;">{{ Session::get('teacher_name') }}</strong></p>
            </div>
            <form method="POST" action="{{ route('teacher.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="menu-sidebar">
                    <h5 style="color: #d4af37; margin-bottom: 1rem;"><i class="fas fa-bars"></i> Menu</h5>
                    <a href="{{ route('teacher.home') }}" class="menu-item">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-book"></i> My Courses
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-users"></i> My Students
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-tasks"></i> Assignments
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-chart-bar"></i> Grades
                    </a>
                    <hr style="border-color: #333;">
                    <a href="#" class="menu-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content-area">
                    <h3 style="color: #d4af37; margin-bottom: 1.5rem;">
                        <i class="fas fa-user-circle"></i> Profile Information
                    </h3>

                    <div class="teacher-info">
                        <div class="info-card">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $teacher->email }}</div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Contact Number</div>
                            <div class="info-value">{{ $teacher->contact_no }}</div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge bg-success"><i class="fas fa-check"></i> Active</span>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Department</div>
                            <div class="info-value">{{ $teacher->department ?? 'Not Assigned' }}</div>
                        </div>

                        <div class="info-card">
                            <div class="info-label">Specialty</div>
                            <div class="info-value">{{ $teacher->specialty ?? 'Not Assigned' }}</div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #333;">
                        <h5 style="color: #d4af37; margin-bottom: 1rem;">Account Details</h5>
                        <p><strong>Member Since:</strong> {{ $teacher->created_at->format('F d, Y') }}</p>
                        <p><strong>Last Updated:</strong> {{ $teacher->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #1a1a1a; border: 1px solid #333;">
                <div class="modal-header" style="border-bottom: 1px solid #333;">
                    <h5 class="modal-title" style="color: #d4af37;"><i class="fas fa-key"></i> Change Password</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('teacher.password.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color: #d4af37;">Old Password</label>
                            <input type="password" name="old_password" class="form-control" style="background-color: #242424; border: 1px solid #333; color: #b8b8b8;" required>
                            @error('old_password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #d4af37;">New Password</label>
                            <input type="password" name="new_password" class="form-control" style="background-color: #242424; border: 1px solid #333; color: #b8b8b8;" required>
                            @error('new_password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #d4af37;">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" style="background-color: #242424; border: 1px solid #333; color: #b8b8b8;" required>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #333;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn" style="background-color: #d4af37; color: #0d0d0d; font-weight: bold;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
