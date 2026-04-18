@extends('format.layout')

@section('title', 'Activity Logs - Student Management')

@section('Content')
    <style>
        .logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logs-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .btn-back {
            background-color: #666;
            border-color: #666;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background-color: #777;
            border-color: #777;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
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

        .action-text {
            font-weight: 600;
            color: #d4af37;
        }

        .data-value {
            color: #ffffff;
        }

        .data-na {
            color: #999;
            font-style: italic;
        }

        .degree-transition {
            color: #4dd0e1;
            font-weight: 600;
        }

        .no-logs {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
        }

        .no-logs-icon {
            font-size: 3rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .logs-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem;
            }
        }
    </style>

    <div class="logs-header">
        <h1>Activity Logs</h1>
        <a href="{{ route('students.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
    </div>

    <div class="table-container">
        @if(count($logs) > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Degree</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    <span class="action-text">{{ $log['message'] }}</span>
                                </td>
                                <td>
                                    @if($log['data'])
                                        @php
                                            $studentName = $log['data']['student_name'] ?? $log['data']['new_name'] ?? $log['data']['old_name'] ?? '';
                                            $nameParts = explode(' ', $studentName);
                                            $firstName = $nameParts[0] ?? '';
                                        @endphp
                                        <span class="data-value">{{ $firstName ?: '-' }}</span>
                                    @else
                                        <span class="data-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log['data'])
                                        @php
                                            $studentName = $log['data']['student_name'] ?? $log['data']['new_name'] ?? $log['data']['old_name'] ?? '';
                                            $nameParts = explode(' ', $studentName);
                                            $lastName = end($nameParts) ?? '';
                                        @endphp
                                        <span class="data-value">{{ $lastName ?: '-' }}</span>
                                    @else
                                        <span class="data-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log['data'] && isset($log['data']['email']))
                                        <span class="data-value">{{ $log['data']['email'] }}</span>
                                    @elseif($log['data'] && isset($log['data']['new_email']))
                                        <span class="data-value">{{ $log['data']['new_email'] }}</span>
                                    @else
                                        <span class="data-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log['data'] && isset($log['data']['contact_no']))
                                        <span class="data-value">{{ $log['data']['contact_no'] }}</span>
                                    @elseif($log['data'] && isset($log['data']['new_phone']))
                                        <span class="data-value">{{ $log['data']['new_phone'] }}</span>
                                    @else
                                        <span class="data-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log['data'])
                                        @if(isset($log['data']['old_degree']) && isset($log['data']['new_degree']))
                                            <span class="degree-transition">{{ $log['data']['old_degree'] }} → {{ $log['data']['new_degree'] }}</span>
                                        @elseif(isset($log['data']['degree']))
                                            <span class="data-value">{{ $log['data']['degree'] }}
                                                @if(strpos($log['message'], 'created') !== false)
                                                    <span class="data-na">(Added)</span>
                                                @elseif(strpos($log['message'], 'deleted') !== false)
                                                    <span class="data-na">(Deleted)</span>
                                                @endif
                                            </span>
                                        @elseif(isset($log['data']['new_degree']))
                                            <span class="data-value">{{ $log['data']['new_degree'] }}
                                                @if(strpos($log['message'], 'created') !== false)
                                                    <span class="data-na">(Added)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="data-na">N/A</span>
                                        @endif
                                    @else
                                        <span class="data-na">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-logs">
                <div class="no-logs-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h3>No Activity Logs Found</h3>
                <p>Student operations will appear here once you start managing records.</p>
            </div>
        @endif
    </div>
@endsection


