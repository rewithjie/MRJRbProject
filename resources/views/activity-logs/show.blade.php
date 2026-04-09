@extends('format.layout')

@section('title', 'Activity Log Details - Student Management')

@section('Content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h1 class="mb-4">Activity Log Details</h1>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Log #{{ $log->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Action:</strong></p>
                            <p>
                                <span class="badge bg-primary">{{ $log->action }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong></p>
                            <p>
                                @if($log->status === 'success')
                                    <span class="badge bg-success">{{ ucfirst($log->status) }}</span>
                                @elseif($log->status === 'error')
                                    <span class="badge bg-danger">{{ ucfirst($log->status) }}</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($log->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Entity Type:</strong></p>
                            <p>{{ $log->entity_type }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Entity ID:</strong></p>
                            <p>{{ $log->entity_id ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>User Email:</strong></p>
                            <p>{{ $log->user_email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>IP Address:</strong></p>
                            <p>{{ $log->ip_address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p><strong>Message:</strong></p>
                        <p>{{ $log->message }}</p>
                    </div>

                    <div class="mb-3">
                        <p><strong>Created At:</strong></p>
                        <p>{{ $log->created_at->format('M d, Y H:i:s') }}</p>
                    </div>

                    @if($log->data)
                        <div class="mb-3">
                            <p><strong>Additional Data:</strong></p>
                            <pre class="bg-light p-3 rounded"><code>{{ json_encode($log->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('logs.index') }}" class="btn btn-secondary">Back to Logs</a>
            </div>
        </div>
    </div>
@endsection
