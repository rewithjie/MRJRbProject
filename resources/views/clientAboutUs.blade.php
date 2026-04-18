@extends('format.layout')

@section('title', 'About Us - Student Management Dashboard')

@section('Content')
    <style>
        .about-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 3rem;
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
            text-decoration: none;
        }

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
            font-size: 2.5rem;
            font-weight: bold;
            margin: 1rem 0 2rem 0;
            color: #ffffff;
        }

        .intro-text {
            font-size: 1rem;
            color: #999;
            line-height: 1.8;
        }

        .divider {
            width: 60px;
            height: 2px;
            background-color: #d4af37;
            margin: 2rem 0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="about-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="section-label">About Our Platform</div>
        
        <h1>Student Management System</h1>
        
        <p class="intro-text">
            A comprehensive and intuitive platform designed to streamline student record management, degree program organization, and system activity tracking for educational institutions.
        </p>

        <div class="divider"></div>
    </div>
@endsection