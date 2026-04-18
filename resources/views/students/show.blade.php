@extends('format.layout')

@section('title', $student->fname . ' ' . $student->lname . ' - Student Details')

@section('Content')
    <style>
        .student-detail-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 2rem;
            padding: 0.6rem 1.2rem;
            border: 2px solid #d4af37;
            color: #d4af37;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .back-button:hover {
            background-color: #d4af37;
            color: #0d0d0d;
            transform: translateX(-3px);
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

        .student-card {
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .student-header {
            background-color: #1a1a1a;
            color: white;
            padding: 2rem;
            border-bottom: 3px solid #d4af37;
        }

        .student-header h2 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            text-transform: capitalize;
            color: #ffffff;
        }

        .student-body {
            padding: 2rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section:last-of-type {
            margin-bottom: 0;
        }

        .detail-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            background-color: #333;
            padding: 1.5rem;
            border-radius: 6px;
            border-left: 4px solid #d4af37;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #ffffff;
            font-weight: 500;
            word-break: break-word;
        }

        .detail-link {
            color: #d4af37;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .detail-link:hover {
            color: #e8c547;
            text-decoration: underline;
        }

        .badge-degree {
            display: inline-block;
            background-color: #2ecc71;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .badge-degree:hover {
            background-color: #27ae60;
        }

        .timestamp-section {
            background-color: #333;
            padding: 1.5rem;
            border-radius: 6px;
            border-left: 4px solid #d4af37;
        }

        .timestamp-label {
            color: #d4af37;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .timestamp-value {
            color: #e0e0e0;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .student-footer {
            background-color: #1a1a1a;
            padding: 1.5rem 2rem;
            border-top: 1px solid #3a3a3a;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-edit {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-edit:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-delete:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
            text-decoration: none;
        }

        .id-badge {
            display: inline-block;
            background-color: #d4af37;
            color: #0d0d0d;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .student-header h2 {
                font-size: 1.5rem;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }

            .student-footer {
                flex-direction: column;
            }

            .btn-edit, .btn-delete {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="student-detail-container">
        <a href="{{ route('students.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>

        @if ($message = Session::get('success'))
            <div class="alert alert-custom alert-success-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="student-card">
            <div class="student-header">
                <h2>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</h2>
            </div>

            <div class="student-body">
                @if($student->degree)
                    <div class="detail-section">
                        <span class="detail-label">Degree Program</span>
                        <a href="{{ route('degrees.show', $student->degree->id) }}" class="badge-degree">
                            {{ $student->degree->title }}
                        </a>
                    </div>
                @endif

                <div class="detail-section">
                    <div class="detail-row">
                        <div class="detail-item">
                            <span class="detail-label">Email Address</span>
                            <div class="detail-value">
                                <a href="mailto:{{ $student->email }}" class="detail-link">{{ $student->email }}</a>
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Contact Number</span>
                            <div class="detail-value">
                                <a href="tel:{{ $student->contact_no }}" class="detail-link">{{ $student->contact_no }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-row">
                        <div class="detail-item">
                            <span class="detail-label">Student ID</span>
                            <div class="detail-value">
                                <span class="id-badge">{{ $student->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-row">
                        <div class="timestamp-section">
                            <div class="timestamp-label">
                                <i class="fas fa-calendar-plus"></i> Created On
                            </div>
                            <div class="timestamp-value">
                                {{ $student->created_at->format('M d, Y \a\t h:i A') }}
                            </div>
                        </div>
                        <div class="timestamp-section">
                            <div class="timestamp-label">
                                <i class="fas fa-calendar-check"></i> Last Updated
                            </div>
                            <div class="timestamp-value">
                                {{ $student->updated_at->format('M d, Y \a\t h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="student-footer">
                <a href="{{ route('students.edit', $student->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Student
                </a>
                <form method="POST" action="{{ route('students.destroy', $student->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Delete Student
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
