<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Box Icon CSS-->
    <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Custom JobDigitalCI CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/jobdigitalci-custom.css') }}">

    <!-- Title -->
    <title>@yield('title', 'Dashboard') - JobDigitalCI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <style>
        /* Dashboard Layout Styles */
        :root {
            --primary-red: #fd1616;
            --primary-blue: #001935;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        body {
            background-color: #f8f9fa;
            font-family: "Catamaran", sans-serif;
        }

        /* Top Navbar */
        .dashboard-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: white;
            border-bottom: 1px solid #e5e7eb;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 2rem;
        }

        .dashboard-navbar .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-blue);
            text-decoration: none;
        }

        .dashboard-navbar .logo .text-red {
            color: var(--primary-red);
        }

        .dashboard-navbar .navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .dashboard-navbar .user-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .dashboard-navbar .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-red);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Sidebar */
        .dashboard-sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: var(--primary-blue);
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .sidebar-nav .nav-item {
            margin: 0.25rem 0;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .sidebar-nav .nav-link i {
            font-size: 20px;
            width: 24px;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(253, 22, 22, 0.1);
            color: white;
            border-left: 3px solid var(--primary-red);
        }

        /* Main Content */
        .dashboard-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 2rem;
            min-height: calc(100vh - var(--navbar-height));
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stats-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }

        .stats-card.red .icon {
            background: rgba(253, 22, 22, 0.1);
            color: var(--primary-red);
        }

        .stats-card.blue .icon {
            background: rgba(0, 25, 53, 0.1);
            color: var(--primary-blue);
        }

        .stats-card.green .icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stats-card.orange .icon {
            background: rgba(249, 115, 22, 0.1);
            color: #f97316;
        }

        .stats-card .number {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .stats-card .label {
            font-size: 14px;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .dashboard-sidebar.active {
                transform: translateX(0);
            }

            .dashboard-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Top Navbar -->
    <nav class="dashboard-navbar">
        <a href="{{ route('home') }}" class="logo">
            JobDigital<span class="text-red">CI</span>
        </a>

        <div class="navbar-right">
            <!-- User Menu -->
            <div class="dropdown">
                <div class="user-menu" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                    <i class='bx bx-chevron-down'></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="@yield('profile-route', '#')">
                            <i class='bx bx-user'></i> Mon Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class='bx bx-log-out'></i> Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <nav class="sidebar-nav">
            @yield('sidebar')
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class='bx bx-error-circle'></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- jQuery Min JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap Bundle Min JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
