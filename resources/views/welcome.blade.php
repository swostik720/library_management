<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .feature-card {
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #0d6efd;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Library Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Welcome to Our Library Management System</h1>
            <p class="lead mb-5">A comprehensive solution for managing books, members, and transactions</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3">Go to Dashboard</a>
            @else
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3">Register</a>
                </div>
            @endauth
        </div>
    </section>

    <section class="container mb-5">
        <h2 class="text-center mb-5">Features of Our Library System</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <h4>Book Management</h4>
                        <p>Easily add, edit, and manage your entire book collection with detailed information.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Member Management</h4>
                        <p>Keep track of all library members, their borrowing history, and account status.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <h4>Transaction Tracking</h4>
                        <p>Manage book issues, returns, and track overdue books with automated fine calculation.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-cart-plus"></i>
                        </div>
                        <h4>Acquisition Requests</h4>
                        <p>Allow members to request new books and track the acquisition process.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <h4>Comprehensive Reports</h4>
                        <p>Generate detailed reports on book popularity, member activity, and more.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Role-Based Access</h4>
                        <p>Different access levels for administrators, librarians, and members.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>About Our Library</h2>
                <p class="lead">Our library management system is designed to streamline the operations of modern libraries.</p>
                <p>Whether you're managing a small community library or a large institutional collection, our system provides the tools you need to efficiently manage your resources, serve your members, and make data-driven decisions.</p>
                <p>With features like book tracking, member management, and comprehensive reporting, you can focus on what matters most - providing excellent service to your community.</p>
            </div>
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Library" class="img-fluid rounded shadow">
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Library Management System</h5>
                    <p>A comprehensive solution for modern libraries.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('login') }}" class="text-white">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-white">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope me-2"></i> info@library.com</li>
                        <li><i class="bi bi-telephone me-2"></i> (123) 456-7890</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Library Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to create and show a toast
        function showToast(message, type = 'success') {
            // Create toast element
            const toastEl = document.createElement('div');
            toastEl.className = 'toast';
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');

            // Set toast background color based on type
            let bgColor = 'bg-success';
            let icon = 'bi-check-circle-fill';

            if (type === 'error') {
                bgColor = 'bg-danger';
                icon = 'bi-exclamation-circle-fill';
            } else if (type === 'warning') {
                bgColor = 'bg-warning';
                icon = 'bi-exclamation-triangle-fill';
            } else if (type === 'info') {
                bgColor = 'bg-info';
                icon = 'bi-info-circle-fill';
            }

            // Create toast content
            toastEl.innerHTML = `
                <div class="toast-header ${bgColor} text-white">
                    <i class="bi ${icon} me-2"></i>
                    <strong class="me-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;

            // Add toast to container
            document.querySelector('.toast-container').appendChild(toastEl);

            // Initialize and show toast
            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 5000
            });
            toast.show();

            // Remove toast from DOM after it's hidden
            toastEl.addEventListener('hidden.bs.toast', function () {
                toastEl.remove();
            });
        }

        // Show toasts for flash messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if(session('warning'))
                showToast("{{ session('warning') }}", 'warning');
            @endif

            @if(session('info'))
                showToast("{{ session('info') }}", 'info');
            @endif
        });
    </script>
</body>
</html>
