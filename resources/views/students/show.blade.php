@extends('format.layout')

@section('title', $student->fname . ' ' . $student->lname . ' - Student Details')

@section('Content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4">
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to Students</a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</h3>
                </div>
                <div class="card-body">
                    @if($student->degree)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="text-muted">Degree</h6>
                                <p class="mb-3">
                                    <a href="{{ route('degrees.show', $student->degree->id) }}" class="badge bg-primary fs-6">
                                        {{ $student->degree->title }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p class="mb-3">
                                <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Contact Number</h6>
                            <p class="mb-3">
                                <a href="tel:{{ $student->contact_no }}">{{ $student->contact_no }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4 text-muted small">
                        <div class="col-md-12">
                            <p>
                                <strong>ID Number:</strong> {{ $student->id }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4 text-muted small">
                        <div class="col-md-6">
                            <p>
                                <strong>Created:</strong> {{ $student->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Last Updated:</strong> {{ $student->updated_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light d-flex gap-2">
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit Student</a>
                    <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Student
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
