@extends('format.layout')

@section('title', 'Student Login - Student Management Dashboard')

@section('Content')
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="mb-2">Student Login</h1>
                        <p class="text-muted">Sign in to access your student dashboard</p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <i class="fas fa-exclamation-triangle"></i> {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: #d4af37; border: none;">
                                    <i class="fas fa-envelope" style="color: #0d0d0d;"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: #d4af37; border: none;">
                                    <i class="fas fa-lock" style="color: #0d0d0d;"></i>
                                </span>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter your password"
                                    required>
                                <button type="button" class="btn btn-outline-secondary" id="toggle-login-password">
                                    Show
                                </button>
                            </div>
                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn w-100 mb-3" style="background-color: #d4af37; color: #0d0d0d; font-weight: bold; border: none;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </form>

                    <hr class="my-4" style="border-color: #333;">

                    <div class="text-center">
                        <p class="text-muted mb-2">Don't have an account?</p>
                        <a href="{{ route('students.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-user-plus"></i> Register as New Student
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="fas fa-lock-open"></i> Secure login powered by Argon2id encryption
                </p>
            </div>
        </div>
    </div>

    <style>
        .min-vh-100 {
            min-height: 100vh !important;
        }

        .card {
            background-color: #2a2a2a;
            border: 1px solid #444 !important;
        }

        .form-label {
            color: #e0e0e0;
            font-weight: 500;
        }

        .form-control {
            background-color: #1a1a1a;
            border: 1px solid #444;
            color: #e0e0e0;
        }

        .form-control:focus {
            background-color: #1a1a1a;
            border-color: #d4af37;
            color: #e0e0e0;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .form-control::placeholder {
            color: #666;
        }

        .input-group-text {
            background-color: #d4af37 !important;
            border: none !important;
        }

        .text-danger {
            color: #ff6b6b !important;
        }

        .text-muted {
            color: #999 !important;
        }

        .btn-outline-warning {
            color: #d4af37;
            border-color: #d4af37;
        }

        .btn-outline-warning:hover {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #0d0d0d;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginPasswordInput = document.getElementById('password');
            const loginToggleBtn = document.getElementById('toggle-login-password');

            if (loginPasswordInput && loginToggleBtn) {
                loginToggleBtn.addEventListener('click', function () {
                    const isPassword = loginPasswordInput.getAttribute('type') === 'password';
                    loginPasswordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    loginToggleBtn.textContent = isPassword ? 'Hide' : 'Show';
                });
            }
        });
    </script>
@endsection
