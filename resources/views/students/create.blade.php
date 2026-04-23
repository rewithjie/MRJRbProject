@extends('format.layout')

@section('title', 'Create Student - Student Management')

@section('Content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Add New Student</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('students.store') }}" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name *</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="fname" 
                                        name="fname" 
                                        placeholder="Enter first name"
                                        minlength="3"
                                        value="{{ old('fname') }}"
                                        required>
                                    @error('fname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mname" class="form-label">Middle Initial *</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="mname" 
                                        name="mname" 
                                        placeholder="Enter middle initial"
                                        maxlength="1"
                                        value="{{ old('mname') }}"
                                        required>
                                    @error('mname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="lname" 
                                name="lname" 
                                placeholder="Enter last name"
                                minlength="3"
                                value="{{ old('lname') }}"
                                required>
                            @error('lname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="Enter email address"
                                value="{{ old('email') }}"
                                required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Enter password (min 8 characters)"
                                minlength="8"
                                required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-1">Password will be securely encrypted with Argon2id</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Confirm password"
                                minlength="8"
                                required>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact Number *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="contact_no" 
                                name="contact_no" 
                                placeholder="09XX-XXX-XXXX"
                                value="{{ old('contact_no') }}"
                                required>
                            @error('contact_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="degree_id" class="form-label">Degree</label>
                            <select 
                                class="form-select" 
                                id="degree_id" 
                                name="degree_id">
                                <option value="">-- Select Degree --</option>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree->id }}" @if(old('degree_id') == $degree->id) selected @endif>
                                        {{ $degree->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('degree_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                Create Student
                            </button>
                            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
