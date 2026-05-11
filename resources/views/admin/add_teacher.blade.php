@extends('format.layout')

@section('title', 'Add New Teacher - Admin Dashboard')

@section('Content')
    <style>
        .form-container {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 2rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        .form-container h2 {
            color: #d4af37;
            margin-bottom: 1.5rem;
        }

        .form-control {
            background-color: #242424;
            border: 1px solid #333;
            color: #b8b8b8;
        }

        .form-control:focus {
            background-color: #242424;
            border-color: #d4af37;
            color: #b8b8b8;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .form-control::placeholder {
            color: #666;
        }

        .form-label {
            color: #d4af37;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-submit {
            background-color: #d4af37;
            color: #0d0d0d;
            border: none;
            font-weight: bold;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
        }

        .btn-submit:hover {
            background-color: #f0c857;
            color: #0d0d0d;
        }

        .btn-back {
            background-color: transparent;
            border: 1px solid #666;
            color: #b8b8b8;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            margin-top: 0.5rem;
        }

        .btn-back:hover {
            border-color: #d4af37;
            color: #d4af37;
        }
    </style>

    <div class="container py-4">
        <div class="form-container">
            <h2><i class="fas fa-plus-circle"></i> Add New Teacher</h2>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Please check the form errors below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.store.teacher') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fname" class="form-label">First Name *</label>
                        <input type="text" class="form-control @error('fname') is-invalid @enderror" 
                               id="fname" name="fname" value="{{ old('fname') }}" required>
                        @error('fname')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mname" class="form-label">Middle Name *</label>
                        <input type="text" class="form-control @error('mname') is-invalid @enderror" 
                               id="mname" name="mname" value="{{ old('mname') }}" required>
                        @error('mname')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name *</label>
                    <input type="text" class="form-control @error('lname') is-invalid @enderror" 
                           id="lname" name="lname" value="{{ old('lname') }}" required>
                    @error('lname')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_no" class="form-label">Contact Number (11 digits) *</label>
                    <input type="text" class="form-control @error('contact_no') is-invalid @enderror" 
                           id="contact_no" name="contact_no" placeholder="09XXXXXXXXX" value="{{ old('contact_no') }}" required>
                    @error('contact_no')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department *</label>
                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                           id="department" name="department" placeholder="e.g., Computer Science" value="{{ old('department') }}" required>
                    @error('department')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="specialty" class="form-label">Specialty (Optional)</label>
                    <input type="text" class="form-control @error('specialty') is-invalid @enderror" 
                           id="specialty" name="specialty" placeholder="e.g., Web Development" value="{{ old('specialty') }}">
                    @error('specialty')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Add Teacher
                </button>

                <a href="{{ route('admin.manage.teachers') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Teacher List
                </a>
            </form>
        </div>
    </div>
@endsection
