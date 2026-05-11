@extends('format.layout')

@section('title', 'Manage Teachers - Admin Dashboard')

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

        .badge-active {
            background-color: #28a745;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 3px;
        }
    </style>

    <div class="container py-4">
        <div class="management-header">
            <div>
                <h1><i class="fas fa-chalkboard-user"></i> Manage Teachers</h1>
                <p style="color: #b8b8b8;">Total Teachers: <strong style="color: #d4af37;">{{ $teachers->total() }}</strong></p>
            </div>
            <a href="{{ route('admin.add.teacher') }}" class="btn-add">
                <i class="fas fa-plus"></i> Add New Teacher
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div style="overflow-x: auto; background-color: #1a1a1a; border-radius: 5px; padding: 1rem;">
            @if($teachers->count() > 0)
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Department</th>
                            <th>Specialty</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration + ($teachers->currentPage() - 1) * $teachers->perPage() }}</td>
                                <td>{{ $teacher->lname }}, {{ $teacher->fname }} {{ $teacher->mname }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->contact_no }}</td>
                                <td>{{ $teacher->department ?? 'N/A' }}</td>
                                <td>{{ $teacher->specialty ?? 'N/A' }}</td>
                                <td>
                                    @if($teacher->is_active)
                                        <span class="badge-active"><i class="fas fa-check"></i> Active</span>
                                    @else
                                        <span style="background-color: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 3px;"><i class="fas fa-times"></i> Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.delete.teacher', $teacher->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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
                    {{ $teachers->links('pagination::bootstrap-4') }}
                </nav>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No teachers found. <a href="{{ route('admin.add.teacher') }}">Add one now</a>
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
