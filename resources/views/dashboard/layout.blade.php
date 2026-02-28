<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ __('dashboard.dashboard_title') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6f42c1;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #0dcaf0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, var(--primary) 0%, #5a32a3 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar.rtl {
            left: 0;
        }

        .sidebar.ltr {
            left: 0;
        }

        .main-content {
            margin-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 260px;
            flex: 1;
            padding: 30px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo h4 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu li {
            margin-bottom: 10px;
        }

        .nav-menu a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-menu a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .nav-menu i {
            width: 20px;
            margin-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 10px;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-role {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            background: var(--primary);
            color: white;
            font-weight: bold;
        }

        .user-role.superadmin {
            background: #dc3545;
        }

        .user-role.admin {
            background: #ffc107;
            color: black;
        }

        .user-role.content_manager {
            background: #17a2b8;
        }

        .dashboard-card {
            background: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #5a32a3 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }

        .dashboard-card-body {
            padding: 20px;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar span:not(.icon) {
                display: none;
            }

            .main-content {
                margin-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 70px;
            }

            .topbar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>

    @yield('style')
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        @include('dashboard.components.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h2>@yield('page-title')</h2>
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="user-role user-role-{{ auth()->user()->role }}">
                        {{ auth()->user()->getRoleNameArabic() }}
                    </span>
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('script')
</body>

</html>
