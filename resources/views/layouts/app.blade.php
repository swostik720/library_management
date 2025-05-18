<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
        }
        .content {
            padding: 20px;
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Library Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
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

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <div class="container-fluid">
        <div class="row">
            @auth
                <div class="col-md-3 col-lg-2 p-0 bg-light sidebar">
                    <div class="d-flex flex-column flex-shrink-0 p-3">
                        <ul class="nav nav-pills flex-column mb-auto">
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : 'text-dark' }}">
                                    <i class="bi bi-book me-2"></i> Books
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : 'text-dark' }}">
                                    <i class="bi bi-arrow-left-right me-2"></i> Transactions
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('acquisition.index') }}" class="nav-link {{ request()->routeIs('acquisition.*') ? 'active' : 'text-dark' }}">
                                    <i class="bi bi-cart-plus me-2"></i> Acquisition Requests
                                </a>
                            </li>

                            @if(auth()->user()->isAdmin() || auth()->user()->isLibrarian())
                                <li class="nav-item">
                                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : 'text-dark' }}">
                                        <i class="bi bi-tags me-2"></i> Categories
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : 'text-dark' }}">
                                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Reports
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : 'text-dark' }}">
                                        <i class="bi bi-people me-2"></i> Users
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 col-lg-10 content">
            @else
                <div class="col-12 content">
            @endauth
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast JavaScript -->
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

            @if($errors->any())
                @foreach($errors->all() as $error)
                    showToast("{{ $error }}", 'error');
                @endforeach
            @endif
        });
    </script>

    @yield('scripts')
</body>
</html>
