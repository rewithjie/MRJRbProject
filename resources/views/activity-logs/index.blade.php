@extends('format.layout')

@section('title', 'Activity Logs - Student Management')

@section('Content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-0">Activity Logs</h1>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($logs as $log)
                @if ($loop->first)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>User Email</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                @endif

                <tr>
                    <td>
                        <small>{{ $log->id }}</small>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $log->action }}</span>
                    </td>
                    <td>
                        <strong>{{ $log->entity_type }}</strong>
                        @if($log->entity_id)
                            <small class="text-muted">#{{ $log->entity_id }}</small>
                        @endif
                    </td>
                    <td>
                        {{ $log->user_email ?? 'N/A' }}
                    </td>
                    <td>
                        {{ Str::limit($log->message, 50) }}
                    </td>
                    <td>
                        @if($log->status === 'success')
                            <span class="badge bg-success">{{ ucfirst($log->status) }}</span>
                        @elseif($log->status === 'error')
                            <span class="badge bg-danger">{{ ucfirst($log->status) }}</span>
                        @else
                            <span class="badge bg-warning">{{ ucfirst($log->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <small>{{ $log->created_at->format('M d, Y H:i:s') }}</small>
                    </td>
                </tr>

                @if ($loop->last)
                            </tbody>
                        </table>
                    </div>
                @endif
            @empty
                <div class="alert alert-info text-center" role="alert">
                    No activity logs found.
                </div>
            @endforelse
        </div>
    </div>

    @if($logs->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $logs->links() }}
        </div>
    @endif
@endsection
