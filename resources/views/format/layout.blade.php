<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #1a1a1a;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #0d0d0d !important;
            border-bottom: 3px solid #d4af37;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #d4af37 !important;
            letter-spacing: 2px;
        }

        .nav-link {
            color: #e0e0e0 !important;
            margin: 0 1rem;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #d4af37 !important;
        }

        .nav-link.active {
            color: #d4af37 !important;
        }

        /* Main Container */
        .main-container {
            flex: 1;
            padding: 3rem 2rem;
        }

        .content-section {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Typography */
        .section-label {
            font-size: 0.875rem;
            color: #d4af37;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-label::before {
            content: '';
            width: 30px;
            height: 2px;
            background-color: #d4af37;
            margin-right: 15px;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            margin: 1.5rem 0;
            line-height: 1.2;
        }

        h1 .highlight {
            color: #d4af37;
        }

        .subtitle {
            color: #999;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .divider {
            width: 60px;
            height: 2px;
            background-color: #d4af37;
            margin: 2rem 0;
        }

        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .dashboard-card {
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 8px;
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-card:hover {
            background-color: #333;
            border-color: #d4af37;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.2);
        }

        .card-icon {
            font-size: 2.5rem;
            color: #d4af37;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #999;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Footer */
        footer {
            background-color: #0d0d0d;
            border-top: 1px solid #3a3a3a;
            padding: 2rem;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-brand {
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 0.5rem;
        }

        .footer-brand span {
            color: #d4af37;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .main-container {
                padding: 2rem 1rem;
            }
        }

        /* General styles for other pages */
        .table-hover tbody tr:hover {
            background-color: #2a2a2a;
        }

        .btn-primary {
            background-color: #d4af37;
            border-color: #d4af37;
            color: #0d0d0d;
        }

        .btn-primary:hover {
            background-color: #e8c547;
            border-color: #e8c547;
        }

        .card {
            background-color: #2a2a2a;
            border-color: #3a3a3a;
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                MRJR PROJECT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.dashboard') || request()->routeIs('student.new.dashboard') || request()->routeIs('student.home') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">Student Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('degrees.*') ? 'active' : '' }}" href="{{ route('degrees.index') }}">Degrees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logs') ? 'active' : '' }}" href="{{ route('logs') }}">Logs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="content-section">
            @yield('Content')
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <span>MRJR</span> Laravel @2026
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDzlPLNUeeqnsIY40JmqrP4ukNHlF7p3c/f7jmrxeXsRxRBtzPbkm5Z5Z0K" crossorigin="anonymous"></script>
</body>
</html>
