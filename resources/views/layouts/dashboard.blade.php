<!DOCTYPE html>
<html lang="en">

<head>
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >
    <title>Expose FC - Admin</title>
    <meta
        content="width=device-width, initial-scale=1.0"
        name="viewport"
    >
    <meta
        content=""
        name="keywords"
    >
    <meta
        content=""
        name="description"
    >

    <!-- Favicon -->
    <link
        rel="icon"
        href="{{ asset('assets\client\images\logo.png') }}"
    >

    <!-- Google Web Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Icon Font Stylesheet -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/font/lucide.min.css"
        rel="stylesheet"
    >
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        rel="stylesheet"
    >

    <!-- Libraries Stylesheet -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            /* Primary Colors */
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --primary-bg: rgba(99, 102, 241, 0.1);

            /* Neutral Colors */
            --dark-primary: #0f172a;
            --dark-secondary: #1e293b;
            --dark-tertiary: #334155;
            --dark-card: #1e293b;
            --dark-hover: #2d3748;

            /* Text Colors */
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --text-light: #94a3b8;

            /* Status Colors */
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #3b82f6;

            /* Background Effects */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --shadow-primary: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* Animations */
            --transition-fast: all 0.15s ease;
            --transition-normal: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-primary) 0%, var(--dark-secondary) 50%, var(--dark-tertiary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Enhanced Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-primary);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 3px;
            transition: var(--transition-fast);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
        }

        /* Loading Spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: var(--transition-normal);
        }

        .spinner-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .modern-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(99, 102, 241, 0.2);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--dark-card);
            border-right: 1px solid var(--glass-border);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: var(--transition-normal);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-xl);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--glass-border);
            position: relative;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 18px;
            transition: var(--transition-normal);
        }

        .brand-logo {
            width: 54px;
            height: 54px;
            border-radius: 34px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 34px;
            flex-shrink: 0;
        }

        .brand-text {
            transition: var(--transition-normal);
            white-space: nowrap;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            transform: translateX(-10px);
            width: 0;
            overflow: hidden;
            visibility: hidden;
        }

        /* Admin Profile Section */
        .admin-profile {
            padding: 20px;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 16px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            transition: var(--transition-normal);
        }

        .profile-card:hover {
            background: rgba(99, 102, 241, 0.05);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .profile-avatar {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-dot {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 12px;
            height: 12px;
            background: var(--success);
            border: 2px solid var(--dark-card);
            border-radius: 50%;
            animation: pulse-status 2s infinite;
        }

        @keyframes pulse-status {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .profile-info {
            flex: 1;
            min-width: 0;
            transition: var(--transition-normal);
        }

        .sidebar.collapsed .profile-info {
            opacity: 0;
            transform: translateX(-10px);
        }

        .profile-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            font-size: 14px;
            line-height: 1.4;
        }

        .profile-role {
            color: var(--text-light);
            font-size: 12px;
            margin: 2px 0 0 0;
        }

        /* Navigation Styles */
        .sidebar-nav {
            padding: 0 16px 24px;
        }

        .nav-section {
            margin-bottom: 28px;
        }

        .nav-section-title {
            color: var(--text-light);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0 0 12px 12px;
            transition: var(--transition-normal);
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            transform: translateX(-10px);
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 13px;
            transition: var(--transition-fast);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .nav-link:hover::before {
            transform: translateX(100%);
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.08);
            color: var(--primary-light);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-bg), rgba(79, 70, 229, 0.08));
            color: var(--primary-light);
            border-left: 3px solid var(--primary);
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .nav-text {
            transition: var(--transition-normal);
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            transform: translateX(-10px);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: transparent;
            transition: var(--transition-normal);
        }

        .sidebar.collapsed+.main-content {
            margin-left: 70px;
        }

        /* Top Navigation */
        .top-nav {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-primary);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
            border-radius: 10px;
            transition: var(--transition-fast);
        }

        .sidebar-toggle:hover {
            background: var(--glass-bg);
            color: var(--primary-light);
        }

        .search-container {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            transition: var(--transition-fast);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-input::placeholder {
            color: var(--text-light);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            color: var(--text-light);
            font-size: 14px;
            pointer-events: none;
        }

        /* Navigation Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .action-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--text-secondary);
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition-fast);
            font-size: 16px;
        }

        .action-btn:hover {
            background: var(--glass-bg);
            color: var(--primary-light);
        }

        @keyframes pulse-notification {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(0.9);
            }
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 8px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .profile-trigger:hover {
            background: rgba(99, 102, 241, 0.05);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .profile-trigger img {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            object-fit: cover;
        }

        .profile-trigger .chevron {
            font-size: 12px;
            color: var(--text-light);
            transition: var(--transition-fast);
        }

        .profile-dropdown.open .chevron {
            transform: rotate(180deg);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: var(--dark-card);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            min-width: 200px;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition-fast);
            z-index: 1000;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            transition: var(--transition-fast);
        }

        .dropdown-item:hover {
            background: rgba(99, 102, 241, 0.08);
            color: var(--primary-light);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--glass-border);
            margin: 8px 0;
        }

        .dropdown-item.danger {
            color: var(--error);
        }

        .dropdown-item.danger:hover {
            background: rgba(239, 68, 68, 0.08);
            color: var(--error);
        }

        /* Content Area */
        .content-area {
            padding: 24px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Demo Content Card */
        .demo-card {
            background: var(--dark-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(20px);
        }

        .demo-card h2 {
            color: var(--text-primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .demo-card p {
            color: var(--text-secondary);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .demo-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 32px;
        }

        .feature-item {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: var(--transition-normal);
        }

        .feature-item:hover {
            background: rgba(99, 102, 241, 0.05);
            border-color: rgba(99, 102, 241, 0.2);
            transform: translateY(-2px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 20px;
            color: white;
        }

        .feature-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        /* Footer */
        .footer {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            padding: 24px;
            margin-top: 40px;
        }

        .footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-text {
            color: var(--text-light);
            font-size: 13px;
            margin: 0;
        }

        .footer-brand {
            color: var(--primary-light);
            font-weight: 600;
        }

        .footer-heart {
            color: var(--error);
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(8px);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition-normal);
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .search-container {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .top-nav {
                padding: 12px 16px;
            }

            .content-area {
                padding: 16px;
            }

            .demo-card {
                padding: 24px;
            }

            .demo-card h2 {
                font-size: 24px;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .demo-features {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        /* Additional Utility Classes */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
            transition: var(--transition-fast);
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }

        .card {
            background: var(--dark-card);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            backdrop-filter: blur(20px);
        }

        .table-dark {
            background: transparent;
        }

        .table-dark th {
            background: var(--glass-bg);
            border-color: var(--glass-border);
            color: var(--text-primary);
        }

        .table-dark td {
            border-color: rgba(51, 65, 85, 0.3);
            color: var(--text-secondary);
        }
    </style>
</head>

<body>
    <!-- Loading Spinner -->
    <div
        id="spinner"
        class="spinner-overlay"
    >
        <div class="modern-spinner"></div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>

    <!-- Sidebar -->
    <div
        class="sidebar"
        id="sidebar"
    >
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a
                href="/"
                class="sidebar-brand"
            >
                <div class="brand-logo">
                    <img
                        src="{{ asset('assets\client\images\logo.png') }}"
                        alt="Logo"
                        style="width:34px; height:34px;"
                    >
                </div>
                <span class="brand-text">Expose FC</span>
            </a>
        </div>

        <!-- Admin Profile -->
        <div class="admin-profile">
            <div class="profile-card">
                <div class="profile-avatar">
                    <img
                        src="{{ asset('assets/admin/img/user.jpg') }}"
                        alt="Admin"
                    >
                    <div class="status-dot"></div>
                </div>
                <div class="profile-info">
                    <h6 class="profile-name">Super Admin</h6>
                    <p class="profile-role">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Core Management -->
            <div class="nav-section">
                <h6 class="nav-section-title">Core Management</h6>
                <div class="nav-section">
                    <div class="nav-item">
                        <a
                            href="/admin/pelatih"
                            class="{{ Request::is('admin/pelatih') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <span class="nav-text">Pelatih</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/players"
                            class="{{ Request::is('admin/players') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-users nav-icon"></i>
                            <span class="nav-text">Players</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/latihan"
                            class="{{ Request::is('admin/latihan') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-running nav-icon"></i>
                            <span class="nav-text">Latihan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/teams"
                            class="{{ Request::is('admin/teams') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-users-cog nav-icon"></i>
                            <span class="nav-text">Teams</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/sejarah"
                            class="{{ Request::is('admin/sejarah') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-trophy nav-icon"></i>
                            <span class="nav-text">Trophy</span>
                        </a>
                    </div>
                </div>

                <!-- Competition & Events -->
                <div class="nav-section">
                    <h6 class="nav-section-title">Competition & Events</h6>
                    <div class="nav-item">
                        <a
                            href="/admin/competitions"
                            class="{{ Request::is('admin/competitions') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-trophy nav-icon"></i>
                            <span class="nav-text">Competitions</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/teams_competitions"
                            class="{{ Request::is('admin/teams_competitions') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-handshake nav-icon"></i>
                            <span class="nav-text">Team Competitions</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/menu-categories"
                            class="{{ Request::is('admin/menu-categories') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-tags nav-icon"></i>
                            <span class="nav-text">Master Categories</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/matches"
                            class="{{ Request::is('admin/matches') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-futbol nav-icon"></i>
                            <span class="nav-text">Matches</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/match_goals"
                            class="{{ Request::is('admin/match_goals') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-futbol nav-icon"></i>
                            <span class="nav-text">Match Goals</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/events"
                            class="{{ Request::is('admin/events') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <span class="nav-text">Events</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/standings"
                            class="{{ Request::is('admin/standings') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-list-ol nav-icon"></i>
                            <span class="nav-text">Standings</span>
                        </a>
                    </div>
                </div>

                <!-- Content Management -->
                <div class="nav-section">
                    <h6 class="nav-section-title">Content Management</h6>
                    <div class="nav-item">
                        <a
                            href="/admin/news"
                            class="{{ Request::is('admin/news') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-newspaper nav-icon"></i>
                            <span class="nav-text">News</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/slider"
                            class="{{ Request::is('admin/slider') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-image nav-icon"></i>
                            <span class="nav-text">slider</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/blogs"
                            class="{{ Request::is('admin/blogs') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-blog nav-icon"></i>
                            <span class="nav-text">Blog</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/gallery"
                            class="{{ Request::is('admin/gallery') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-image nav-icon"></i>
                            <span class="nav-text">Gallery</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/videos"
                            class="{{ Request::is('admin/videos') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-video nav-icon"></i>
                            <span class="nav-text">Videos</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/merchandise"
                            class="{{ Request::is('admin/merchandise') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-tshirt nav-icon"></i>
                            <span class="nav-text">Merchandise</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/transaksi"
                            class="{{ Request::is('admin/transaksi') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-tshirt nav-icon"></i>
                            <span class="nav-text">transaksi</span>
                        </a>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="nav-section">
                    <h6 class="nav-section-title">System Settings</h6>
                    <div class="nav-item">
                        <a
                            href="/admin/news_categories"
                            class="{{ Request::is('admin/news_categories') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-tags nav-icon"></i>
                            <span class="nav-text">News Categories</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/positions"
                            class="{{ Request::is('admin/positions') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-map-marker-alt nav-icon"></i>
                            <span class="nav-text">Positions</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/players_positions"
                            class="{{ Request::is('admin/players_positions') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-user-tag nav-icon"></i>
                            <span class="nav-text">Player Positions</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/venues"
                            class="{{ Request::is('admin/venues') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-map-marked-alt nav-icon"></i>
                            <span class="nav-text">Venues</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/contacts"
                            class="{{ Request::is('admin/contacts') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-envelope nav-icon"></i>
                            <span class="nav-text">Contacts</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a
                            href="/admin/users"
                            class="{{ Request::is('admin/users') ? 'nav-link active' : 'nav-link' }}"
                        >
                            <i class="fas fa-user-shield nav-icon"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </div>
                </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="nav-content">
                <div class="nav-left">
                    <button
                        class="sidebar-toggle"
                        id="sidebarToggle"
                    >
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="search-container">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="text"
                                class="search-input"
                                placeholder="Search dashboard..."
                            >
                        </div>
                    </div>
                </div>

                <div class="nav-actions">
                    <div
                        class="profile-dropdown"
                        id="profileDropdown"
                    >
                        <button
                            class="profile-trigger"
                            id="profileTrigger"
                        >
                            <img
                                src="{{ asset('assets/admin/img/user.jpg') }}"
                                alt="Profile"
                            >
                            <i class="fas fa-chevron-down chevron"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            class="dropdown-menu"
                            id="dropdownMenu"
                        >
                            <a
                                href="#"
                                class="dropdown-item"
                            >
                                <i class="fas fa-user"></i>
                                My Profile
                            </a>
                            <a
                                href="#"
                                class="dropdown-item"
                            >
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                            <a
                                href="#"
                                class="dropdown-item"
                            >
                                <i class="fas fa-chart-line"></i>
                                Analytics
                            </a>
                            @auth
                                <div class="dropdown-divider"></div>
                                <a
                                    href="/logout"
                                    class="dropdown-item danger"
                                >
                                    <i class="fas fa-sign-out-alt"></i>
                                    Log Out
                                </a>
                            @else
                                <div class="normal-link col-auto">
                                    <a href="/registrasi">Registrasi</a>
                                </div>
                                <li class="nav-item">
                                    <a
                                        href="/login"
                                        class="nav-link"
                                    >Login</a>
                                </li>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area animate-fade-in">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <p class="footer-text">
                    &copy; 2024 <span class="footer-brand">Expose FC</span>. All rights reserved.
                </p>
                <p class="footer-text">
                    Designed with <i class="fas fa-heart footer-heart"></i> by
                    <span class="footer-brand">Jumagar Team</span>
                </p>
            </div>
        </footer>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading spinner with smooth transition
            setTimeout(() => {
                document.getElementById('spinner').classList.add('hidden');
            }, 800);

            // Initialize all interactive components
            initializeSidebar();
            initializeDropdowns();
            initializeSearch();
            initializeAnimations();
        });

        // Sidebar functionality
        function initializeSidebar() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.toggle('collapsed');
                    // Store sidebar state in localStorage
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                } else {
                    sidebar.classList.toggle('mobile-open');
                    sidebarOverlay.classList.toggle('active');
                }
            });

            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');

                    // Restore sidebar state
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                    }
                }
            });

            // Load saved sidebar state
            if (window.innerWidth > 1024) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                }
            }
        }

        // Dropdown functionality
        function initializeDropdowns() {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileTrigger = document.getElementById('profileTrigger');
            const dropdownMenu = document.getElementById('dropdownMenu');

            profileTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = profileDropdown.classList.contains('open');

                // Close all dropdowns first
                closeAllDropdowns();

                if (!isOpen) {
                    profileDropdown.classList.add('open');
                    dropdownMenu.classList.add('show');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    closeAllDropdowns();
                }
            });

            // Close dropdown on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllDropdowns();
                }
            });

            function closeAllDropdowns() {
                profileDropdown.classList.remove('open');
                dropdownMenu.classList.remove('show');
            }
        }

        // Search functionality
        function initializeSearch() {
            const searchInput = document.querySelector('.search-input');
            const searchContainer = document.querySelector('.search-container');

            searchInput.addEventListener('focus', function() {
                searchContainer.style.transform = 'scale(1.02)';
                this.style.background = 'rgba(255, 255, 255, 0.08)';
            });

            searchInput.addEventListener('blur', function() {
                searchContainer.style.transform = 'scale(1)';
                if (!this.value) {
                    this.style.background = 'var(--glass-bg)';
                }
            });

            // Add search functionality here
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                // Implement search logic
                console.log('Searching for:', query);
            });
        }

        // Animation enhancements
        function initializeAnimations() {
            // Add hover effects to nav links
            const navLinks = document.querySelectorAll('.nav-link:not(.active)');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Add intersection observer for fade-in animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                    }
                });
            });

            // Observe elements for animation
            const animateElements = document.querySelectorAll('.feature-item');
            animateElements.forEach(el => observer.observe(el));
        }

        // Utility functions
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                    <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            // Notification styles
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10001;
                background: ${type === 'success' ? 'var(--success)' : type === 'error' ? 'var(--error)' : 'var(--info)'};
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: var(--shadow-xl);
                backdrop-filter: blur(20px);
                animation: slideInRight 0.3s ease;
                max-width: 350px;
                font-size: 14px;
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        function addLoadingState(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        }

        // Add notification animations
        const notificationStyles = document.createElement('style');
        notificationStyles.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                margin-left: auto;
                padding: 4px;
                border-radius: 6px;
                transition: var(--transition-fast);
                opacity: 0.8;
            }
            
            .notification-close:hover {
                background: rgba(255,255,255,0.2);
                opacity: 1;
            }
        `;
        document.head.appendChild(notificationStyles);

        // Example notification (remove in production)
        setTimeout(() => {
            showNotification('Dashboard loaded successfully!', 'success');
        }, 1200);
    </script>
    @stack('scripts')

</body>

</html>
