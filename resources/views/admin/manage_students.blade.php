@extends('format.layout')

@section('title', 'Manage Students - Admin Dashboard')

@section('Content')
    <style>
        .management-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .management-header h1 {
            color: #d4af37;
            font-size: 2rem;
        }

        .btn-add {
            background-color: #d4af37;
            color: #0d0d0d;
            font-weight: bold;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
        }

        .btn-add:hover {
            background-color: #f0c857;
            color: #0d0d0d;
            text-decoration: none;
        }

        .table {
            color: #b8b8b8;
            margin-top: 2rem;
        }

        .table thead {
            background-color: #1a1a1a;
            color: #d4af37;
        }

        .table tbody tr {
            border-bottom: 1px solid #333;
            transition: background-color 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #242424;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            padding: 0.5rem 1rem;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>

    <div class="container py-4">
        <div class="management-header">
            <div>
                <h1><i class="fas fa-users"></i> Manage Students</h1>
                <p style="color: #b8b8b8;">Total Students: <strong style="color: #d4af37;">{{ $students->total() }}</strong></p>
            </div>
            <a href="{{ route('admin.add.student') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add New Student
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div style="overflow-x: auto; background-color: #1a1a1a; border-radius: 5px; padding: 1rem;">
            @if($students->count() > 0)
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Degree</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->contact_no }}</td>
                                <td>{{ $student->degree?->title ?? 'N/A' }}</td>
                                <td>{{ $student->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.delete.student', $student->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-3">
                    {{ $students->links('pagination::bootstrap-4') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No students found. <a href="{{ route('admin.add.student') }}">Add one now</a>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
@endsection
