@extends('format.layout')

@section('title', 'Teacher Dashboard')

@section('Content')
    <style>
        .teacher-dashboard-header {
            margin-bottom: 2rem;
        }

        .teacher-dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .logged-account {
            margin-top: 0.5rem;
            color: #b8b8b8;
            font-size: 1rem;
        }

        .logged-account strong {
            color: #d4af37;
            font-weight: 600;
        }

        .dashboard-card {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            border-color: #d4af37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
        }

        .dashboard-card h3 {
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .btn-primary-custom {
            background-color: #d4af37;
            color: #0d0d0d;
            border: none;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #f0c857;
            color: #0d0d0d;
            text-decoration: none;
        }
    </style>

    <div class="container py-4">
        <div class="teacher-dashboard-header">
            <h1>Teacher Dashboard</h1>
            <p class="logged-account mb-0">
                Logged in as: <strong>{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</strong>
                ({{ Session::get('teacher_email') }})
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

        <div class="row">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3><i class="fas fa-user-circle"></i> Your Profile</h3>
                    <p><strong>Full Name:</strong> {{ $teacher->full_name }}</p>
                    <p><strong>Email:</strong> {{ $teacher->email }}</p>
                    <p><strong>Contact:</strong> {{ $teacher->contact_no }}</p>
                    <p><strong>Department:</strong> {{ $teacher->department ?? 'N/A' }}</p>
                    <p><strong>Specialty:</strong> {{ $teacher->specialty ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3><i class="fas fa-lock"></i> Security</h3>
                    <p>Manage your account security</p>
                    <form method="POST" action="{{ route('teacher.password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" name="old_password" class="form-control" required>
                            @error('old_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h3><i class="fas fa-info-circle"></i> Teacher Information</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Account Created:</strong></p>
                            <p>{{ $teacher->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Last Updated:</strong></p>
                            <p>{{ $teacher->updated_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Status:</strong></p>
                            <p><span class="badge bg-success" style="font-size: 1rem;">Active</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <form method="POST" action="{{ route('teacher.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
