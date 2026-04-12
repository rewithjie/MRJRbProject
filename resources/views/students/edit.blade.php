@extends('format.layout')

@section('title', 'Edit Student - Student Management')

@section('Content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Student</h1>

            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('students.update', $student->id) }}">
                        @csrf
                        @method('PUT')

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
                                        value="{{ old('fname', $student->fname) }}"
                                        required>
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
                                        value="{{ old('mname', $student->mname) }}"
                                        required>
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
                                value="{{ old('lname', $student->lname) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="Enter email address"
                                value="{{ old('email', $student->email) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact Number * (11 digits)</label>
                            <input 
                                type="text" 
                                class="form-control @error('contact_no') is-invalid @enderror" 
                                id="contact_no" 
                                name="contact_no" 
                                placeholder="09212345678"
                                pattern="[0-9]{11}"
                                maxlength="11"
                                inputmode="numeric"
                                value="{{ old('contact_no', $student->contact_no) }}"
                                required>
                            @error('contact_no')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
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
                                    <option value="{{ $degree->id }}" @if(old('degree_id', $student->degree_id) == $degree->id) selected @endif>
                                        {{ $degree->title }}
                                    </option>
                                @endforeach
                            </select>
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
@endsection
