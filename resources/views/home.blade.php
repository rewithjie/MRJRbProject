@extends('format.layout')

@section('title', 'MRJR Management System - Login')

@section('Content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #0d0d0d;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 3rem;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.25rem;
        }

        .role-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .role-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
            border: 2px solid #333;
            border-radius: 10px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .role-card:hover {
            border-color: #d4af37;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
            transform: translateY(-5px);
        }

        .role-card-icon {
            font-size: 4rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .role-card h2 {
            color: #d4af37;
            margin-bottom: 1rem;
            font-size: 1.75rem;
        }

        .role-card p {
            color: #b8b8b8;
            margin-bottom: 1.5rem;
            min-height: 60px;
        }

        .role-card-btn {
            display: inline-block;
            background-color: #d4af37;
            color: #0d0d0d;
            padding: 0.75rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid #d4af37;
        }

        .role-card-btn:hover {
            background-color: transparent;
            color: #d4af37;
        }

        .features-section {
            background-color: #1a1a1a;
            padding: 3rem;
            border-radius: 10px;
            margin-top: 4rem;
            border: 1px solid #333;
        }

        .features-section h2 {
            color: #d4af37;
            text-align: center;
            margin-bottom: 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-item {
            text-align: center;
        }

        .feature-item i {
            font-size: 2.5rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .feature-item h4 {
            color: #d4af37;
            margin-bottom: 0.5rem;
        }

        .feature-item p {
            color: #b8b8b8;
            font-size: 0.9rem;
        }
    </style>

    <div class="hero-section">
        <h1><i class="fas fa-graduation-cap"></i> MRJR Management System</h1>
        <p>Streamlined Education Management Platform</p>
    </div>

    <div class="container py-4">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="color: #d4af37; font-size: 2rem;">Select Your Role to Login</h2>
            <p style="color: #b8b8b8; font-size: 1.1rem;">Choose the appropriate portal for your account type</p>
        </div>

        <div class="role-container">
            <!-- Student Card -->
            <div class="role-card">
                <div class="role-card-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h2>Student</h2>
                <p>Access your student dashboard, courses, grades, and academic information. Manage your learning journey here.</p>
                <a href="{{ route('student.login.show') }}" class="role-card-btn">
                    <i class="fas fa-sign-in-alt"></i> Student Login
                </a>
                <p style="margin-top: 1rem; font-size: 0.9rem;">
                    Don't have an account? <a href="{{ route('students.create') }}" style="color: #d4af37;">Register here</a>
                </p>
            </div>

            <!-- Teacher Card -->
            <div class="role-card">
                <div class="role-card-icon">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <h2>Teacher</h2>
                <p>Manage your courses, students, assignments, and grades. Access comprehensive teaching tools and resources.</p>
                <a href="{{ route('teacher.login.show') }}" class="role-card-btn">
                    <i class="fas fa-sign-in-alt"></i> Teacher Login
                </a>
                <p style="margin-top: 1rem; font-size: 0.9rem;">
                    Credentials provided by administration
                </p>
            </div>

            <!-- Admin Card -->
            <div class="role-card">
                <div class="role-card-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Administrator</h2>
                <p>Manage the entire system including users, courses, and institution-wide settings. Full administrative access.</p>
                <a href="{{ route('admin.login.show') }}" class="role-card-btn">
                    <i class="fas fa-sign-in-alt"></i> Admin Login
                </a>
                <p style="margin-top: 1rem; font-size: 0.9rem;">
                    Administrator credentials required
                </p>
            </div>
        </div>

        <div class="features-section">
            <h2><i class="fas fa-star"></i> System Features</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-lock"></i>
                    <h4>Secure Access</h4>
                    <p>Protected login with password encryption and session management</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <h4>Multi-Role Support</h4>
                    <p>Separate portals for students, teachers, and administrators</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-bar"></i>
                    <h4>Analytics Dashboard</h4>
                    <p>Real-time insights and comprehensive reporting tools</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-bell"></i>
                    <h4>Notifications</h4>
                    <p>Stay updated with important system announcements</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-mobile-alt"></i>
                    <h4>Responsive Design</h4>
                    <p>Fully responsive interface for mobile and desktop devices</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Data Protection</h4>
                    <p>Enterprise-grade security and data privacy measures</p>
                </div>
            </div>
        </div>

        <div style="background-color: #1a1a1a; padding: 2rem; border-radius: 10px; margin-top: 3rem; border: 1px solid #333; text-align: center;">
            <h3 style="color: #d4af37; margin-bottom: 1rem;">Need Help?</h3>
            <p style="color: #b8b8b8; margin-bottom: 1rem;">
                If you encounter any issues logging in or need assistance with your account, please contact the administration office.
            </p>
            <p style="color: #b8b8b8;">
                <strong>Email:</strong> admin@mrjr.edu | <strong>Phone:</strong> +63 (0) XXX-XXXX
            </p>
        </div>
    </div>
@endsection
