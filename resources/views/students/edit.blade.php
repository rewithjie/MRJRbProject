@extends('format.layout')

@section('title', 'Edit Student - Student Management')

@section('Content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Student</h1>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error Detected - It says erroring!</strong>
                    <p class="mb-2 mt-2">Please check the following errors:</p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('students.update', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('fname') is-invalid @enderror" 
                                        id="fname" 
                                        name="fname" 
                                        placeholder="Enter first name"
                                        minlength="3"
                                        value="{{ old('fname', $student->fname) }}"
                                        required>
                                    @error('fname')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mname" class="form-label">Middle Initial <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('mname') is-invalid @enderror" 
                                        id="mname" 
                                        name="mname" 
                                        placeholder="Enter middle initial"
                                        maxlength="1"
                                        value="{{ old('mname', $student->mname) }}"
                                        required>
                                    @error('mname')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('lname') is-invalid @enderror" 
                                id="lname" 
                                name="lname" 
                                placeholder="Enter last name"
                                minlength="3"
                                value="{{ old('lname', $student->lname) }}"
                                required>
                            @error('lname')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="Enter email address"
                                value="{{ old('email', $student->email) }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Enter new password (optional)"
                                minlength="6"
                                maxlength="20">
                            <small class="text-muted">Leave blank to keep current password. If provided, password must be 6 to 20 characters.</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('contact_no') is-invalid @enderror" 
                                id="contact_no" 
                                name="contact_no" 
                                placeholder="09XX-XXX-XXXX"
                                value="{{ old('contact_no', $student->contact_no) }}"
                                required>
                            @error('contact_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="degree_id" class="form-label">Degree</label>
                            <select 
                                class="form-select @error('degree_id') is-invalid @enderror" 
                                id="degree_id" 
                                name="degree_id">
                                <option value="">-- Select Degree --</option>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree->id }}" @if(old('degree_id', $student->degree_id) == $degree->id) selected @endif>
                                        {{ $degree->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('degree_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                Update Student
                            </button>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            submitBtn.addEventListener('click', function(event) {
                // Check if form is valid
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Add was-validated class to show validation feedback
                form.classList.add('was-validated');

                // Validate each required field
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (field.value.trim() === '') {
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
            });

            // Real-time validation as user types
            const inputs = form.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                    } else {
                        this.classList.add('is-invalid');
                    }
                });

                input.addEventListener('change', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
@endsection
