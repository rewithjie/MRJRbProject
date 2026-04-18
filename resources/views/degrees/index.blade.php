@extends('format.layout')

@section('title', 'Degrees - Degree Management')

@section('Content')
    <style>
        .degrees-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .degrees-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .btn-add-degree {
            background-color: #2ecc71;
            border-color: #2ecc71;
            color: white;
            font-weight: 600;
            padding: 0.7rem 1.8rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
            font-size: 0.95rem;
            text-decoration: none;
        }

        .btn-add-degree:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(46, 204, 113, 0.4);
            text-decoration: none;
        }

        .alert-custom {
            border-radius: 8px;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-success-custom {
            background-color: #1e5631;
            color: #90ee90;
            border-left: 4px solid #2ecc71;
        }

        .alert-danger-custom {
            background-color: #5a1a1a;
            color: #ff6b6b;
            border-left: 4px solid #e74c3c;
        }

        .table-container {
            background-color: #2a2a2a;
            border-radius: 8px;
            border: 1px solid #3a3a3a;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .table {
            margin: 0;
            color: #e0e0e0;
            background-color: #2a2a2a;
        }

        .table thead {
            background-color: #1a1a1a;
            border-bottom: 3px solid #d4af37;
        }

        .table thead th {
            color: #d4af37;
            font-weight: 600;
            padding: 1.25rem;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border: none;
            background-color: #1a1a1a;
        }

        .table tbody {
            background-color: #2a2a2a;
        }

        .table tbody tr {
            border-bottom: 1px solid #3a3a3a;
            transition: all 0.3s ease;
            background-color: #2a2a2a;
        }

        .table tbody tr:hover {
            background-color: #333;
            box-shadow: inset 0 0 10px rgba(212, 175, 55, 0.1);
        }

        .table tbody td {
            padding: 1.25rem;
            vertical-align: middle;
            border: none;
            background-color: #2a2a2a;
            color: #e0e0e0;
        }

        .degree-title {
            font-weight: 600;
            color: #ffffff;
        }

        .badge-students {
            background-color: #4dd0e1;
            color: #0d0d0d;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .btn-view {
            background-color: #d4af37;
            color: #0d0d0d;
        }

        .btn-view:hover {
            background-color: #e8c547;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(212, 175, 55, 0.4);
            text-decoration: none;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(243, 156, 18, 0.4);
            text-decoration: none;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(231, 76, 60, 0.4);
            text-decoration: none;
        }

        .no-degrees {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
        }

        .no-degrees-icon {
            font-size: 3rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination .page-link {
            background-color: #2a2a2a;
            border-color: #3a3a3a;
            color: #d4af37;
        }

        .pagination .page-link:hover {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #0d0d0d;
        }

        .pagination .page-item.active .page-link {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #0d0d0d;
        }

        @media (max-width: 768px) {
            .degrees-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table {
                font-size: 0.9rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="degrees-header">
        <h1>Degrees</h1>
        <a href="{{ route('degrees.create') }}" class="btn-add-degree">
            <i class="fas fa-plus"></i> Add New Degree
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-custom alert-success-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-custom alert-danger-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-container">
        @forelse($degrees as $degree)
            @if ($loop->first)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Degree Title</th>
                                <th>Total Students</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

            <tr>
                <td>{{ ($degrees->currentPage() - 1) * $degrees->perPage() + $loop->iteration }}</td>
                <td class="degree-title">{{ $degree->title }}</td>
                <td>
                    <span class="badge-students">{{ $degree->students->count() }}</span>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('degrees.show', $degree->id) }}" class="btn-action btn-view">View</a>
                        <a href="{{ route('degrees.edit', $degree->id) }}" class="btn-action btn-edit">Edit</a>
                        <form method="POST" action="{{ route('degrees.destroy', $degree->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>

            @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif
        @empty
            <div class="no-degrees">
                <div class="no-degrees-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>No Degrees Found</h3>
                <p>Get started by adding your first degree program.</p>
                <a href="{{ route('degrees.create') }}" class="btn-add-degree" style="display: inline-block; margin-top: 1rem;">
                    <i class="fas fa-plus"></i> Add First Degree
                </a>
            </div>
        @endforelse
    </div>

    @if($degrees->count() > 0)
        <nav aria-label="Page navigation">
            {{ $degrees->links() }}
        </nav>
    @endif
@endsection
