<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background-color: #1a1a1a;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.5rem;
        }

        .maintenance-content {
            max-width: 680px;
            width: 100%;
        }

        .maintenance-icon {
            color: #d4af37;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .maintenance-label {
            color: #d4af37;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0;
        }

        h1 {
            margin: 0.8rem 0 1rem;
            font-size: 2.3rem;
            color: #f5f5f5;
        }

        .maintenance-subtitle {
            color: #b8b8b8;
            font-size: 1.05rem;
            line-height: 1.7;
            margin: 0 auto 1.1rem;
        }

        .maintenance-note {
            color: #9e9e9e;
            margin: 0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            .maintenance-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <main class="maintenance-content" role="main">
        <div class="maintenance-icon">
            <i class="fas fa-screwdriver-wrench" aria-hidden="true"></i>
        </div>
        <p class="maintenance-label">System Notice</p>
        <h1>Maintenance In Progress</h1>
        <p class="maintenance-subtitle">
            This page are temporarily unavailable while we apply updates and improvements.
        </p>
        <p class="maintenance-note">Please check back again later.</p>
    </main>
</body>
</html>
