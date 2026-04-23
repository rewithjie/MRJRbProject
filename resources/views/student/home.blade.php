@extends('format.layout')

@section('title', 'Student Home Dashboard')

@section('Content')
    <div class="container-fluid p-0">
        <div class="header-section" style="background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%); border-bottom: 3px solid #d4af37; padding: 2rem;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-2">
                        <i class="fas fa-user-graduate" style="color: #d4af37;"></i>
                        Welcome, {{ $student->fname }}
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope"></i> {{ $studentEmail }}
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('student.new.dashboard') }}" class="btn btn-warning me-2">
                        <i class="fas fa-id-card"></i> Student Dashboard
                    </a>
                    <form method="POST" action="{{ route('student.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-0" style="min-height: calc(100vh - 200px);">
            <div class="col-md-3" style="background-color: #0d0d0d; border-right: 1px solid #333; overflow-y: auto;">
                <div class="p-3">
                    <h5 class="mb-3" style="color: #d4af37; border-bottom: 2px solid #d4af37; padding-bottom: 10px;">
                        <i class="fas fa-comments"></i> Home Menu
                    </h5>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" style="background-color: #2a2a2a; border-color: #333; color: #e0e0e0;">
                            <i class="fas fa-book"></i> Course Updates
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: transparent; border-color: #333; color: #999;">
                            <i class="fas fa-calendar"></i> Announcements
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" style="background-color: transparent; border-color: #333; color: #999;">
                            <i class="fas fa-users"></i> Class Chat
                        </a>
                        <a href="{{ route('student.new.dashboard') }}" class="list-group-item list-group-item-action" style="background-color: transparent; border-color: #333; color: #999;">
                            <i class="fas fa-id-card"></i> My Student Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9" style="display: flex; flex-direction: column; background-color: #1a1a1a;">
                <div class="messages-container" style="flex: 1; overflow-y: auto; padding: 2rem; border-bottom: 1px solid #333;">
                    <div class="message-group mb-4">
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background-color: #d4af37; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-graduation-cap" style="color: #0d0d0d; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-weight: bold; color: #d4af37;">System</p>
                                <p style="margin: 0; color: #999; font-size: 0.85rem;">Now</p>
                            </div>
                        </div>
                        <div style="background-color: #2a2a2a; padding: 1rem; border-radius: 0.5rem; border-left: 3px solid #d4af37; margin-left: 3rem;">
                            <p style="margin: 0; color: #e0e0e0; line-height: 1.5;">
                                This is your Home Dashboard. Use "Student Dashboard" to view your degree enrollment and manage your password.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
