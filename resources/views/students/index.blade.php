@extends('format.layout')

@section('title', 'Students - Student Management')

@section('Content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-0">Students</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('students.create') }}" class="btn btn-success">Add New Student</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($students as $student)
                @if ($loop->first)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Degree</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                @endif

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</strong>
                    </td>
                    <td>{{ $student->email }}</td>
                    <td>
                        {{ $student->contact_no }}
                    </td>
                    <td>
                        @if($student->degree)
                            <span class="badge bg-success">
                                {{ $student->degree->title }}
                            </span>
                        @else
                            <span class="badge bg-secondary">No Degree</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                @if ($loop->last)
                            </tbody>
                        </table>
                    </div>
                @endif
            @empty
                <div class="alert alert-warning text-center" role="alert">
                    No students found. <a href="{{ route('students.create') }}" class="alert-link">Add one now</a>
                </div>
            @endforelse
        </div>
    </div>

    @if($students->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $students->links() }}
        </div>
    @endif
@endsection
