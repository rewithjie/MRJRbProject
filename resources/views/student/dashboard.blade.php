@extends('format.layout')

@section('title', 'Student Dashboard')

@section('Content')
    <style>
        .student-dashboard-header {
            margin-bottom: 2rem;
        }

        .student-dashboard-header h1 {
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
    </style>

    <div class="container py-4">
        <div class="student-dashboard-header">
            <h1>Student Dashboard</h1>
            <p class="logged-account mb-0">
                Logged in as: <strong>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</strong>
                ({{ $studentEmail }})
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        Degree Enrollment
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Degree Program:</strong></p>
                        <p class="text-muted mb-3">
                            {{ optional($student->degree)->title ?? 'No degree assigned yet' }}
                        </p>

                        <p class="mb-2"><strong>Enrollment Status:</strong></p>
                        <span class="badge {{ $student->degree ? 'bg-success' : 'bg-secondary' }}">
                            {{ $student->degree ? 'Enrolled' : 'Not Enrolled' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        Change Password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.password.update') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="old_password" class="form-label">Old Password</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="old_password"
                                        name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        required>
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary password-toggle-btn"
                                        data-target="old_password"
                                        aria-label="Show password"
                                        title="Show password">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="new_password"
                                        name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        required>
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary password-toggle-btn"
                                        data-target="new_password"
                                        aria-label="Show password"
                                        title="Show password">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="new_password_confirmation"
                                        name="new_password_confirmation"
                                        class="form-control"
                                        required>
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary password-toggle-btn"
                                        data-target="new_password_confirmation"
                                        aria-label="Show password"
                                        title="Show password">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.password-toggle-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const inputId = button.getAttribute('data-target');
                    const input = document.getElementById(inputId);

                    if (!input) {
                        return;
                    }

                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');

                    const icon = button.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye', !isPassword);
                        icon.classList.toggle('fa-eye-slash', isPassword);
                    }

                    button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                    button.setAttribute('title', isPassword ? 'Hide password' : 'Show password');
                });
            });
        });
    </script>
@endsection
