<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Water Refilling Station</title>
    <style>
        :root {
            --primary: #1e293b;
            --primary-hover: #0f172a;
            --accent: #0284c7;
            --accent-hover: #0369a1;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-sub: #475569;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --danger-border: #fca5a5;
            --success: #15803d;
            --success-bg: #dcfce7;
            --success-border: #bbf7d0;
            --focus-ring: rgba(2, 132, 199, 0.25);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation Bar */
        .navbar {
            background: var(--primary);
            color: #ffffff;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            flex-wrap: wrap;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo {
            width: 28px;
            height: 28px;
            fill: #38bdf8;
        }

        .brand-title {
            font-size: 17px;
            font-weight: 700;
            letter-spacing: -0.2px;
            color: #ffffff;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link.active {
            color: #ffffff;
            background: #334155;
            font-weight: 600;
        }

        .nav-user-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-greeting {
            font-size: 13px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-name {
            font-weight: 600;
            color: #ffffff;
        }

        .role-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 2px 7px;
            border-radius: 9999px;
            line-height: 1.4;
        }

        .role-badge.admin {
            background: #38bdf8;
            color: #0f172a;
        }

        .role-badge.user {
            background: #94a3b8;
            color: #0f172a;
        }

        .nav-logout-btn {
            background: transparent;
            color: #cbd5e1;
            border: 1px solid #475569;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .nav-logout-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            border-color: #64748b;
        }

        /* Layout Main Body */
        .main-content {
            flex: 1;
            padding: 32px 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .container-narrow {
            max-width: 700px;
            margin: 0 auto;
        }

        .container-medium {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Headers */
        .header, .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: var(--text-main);
        }

        .description {
            color: var(--text-muted);
            margin-top: 6px;
            margin-bottom: 0;
            font-size: 14px;
        }

        /* Cards & Containers */
        .card, .table-container, .state-message {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .card {
            padding: 28px;
        }

        /* Buttons */
        .button, button.button {
            display: inline-block;
            padding: 10px 16px;
            background: var(--primary);
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.15s ease;
            text-align: center;
        }

        .button:hover, button.button:hover {
            background: var(--primary-hover);
        }

        .button:focus, button:focus, input:focus, select:focus, textarea:focus {
            outline: 3px solid var(--focus-ring);
            outline-offset: 1px;
            border-color: var(--accent);
        }

        .secondary-button, .button.secondary, .button.secondary-button, .secondary {
            background: #64748b !important;
            color: #ffffff !important;
        }

        .secondary-button:hover, .button.secondary:hover, .button.secondary-button:hover, .secondary:hover {
            background: #475569 !important;
        }

        .button:disabled, button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: var(--text-sub);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #fbfcfd;
        }

        .actions a, .actions button {
            margin-right: 12px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .actions button {
            background: none;
            border: 0;
            padding: 0;
            cursor: pointer;
            font: inherit;
            color: var(--danger);
            text-decoration: none;
        }

        .actions button:hover {
            text-decoration: underline;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
            background: #ffffff;
            color: var(--text-main);
        }

        .required {
            color: var(--danger);
        }

        .form-note {
            margin-bottom: 20px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: var(--danger);
            font-size: 13px;
        }

        .form-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 6px;
            display: none;
            font-size: 14px;
        }

        .form-message.success, .form-success {
            display: block;
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid var(--success-border);
        }

        .form-message.error, .form-error {
            display: block;
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid var(--danger-border);
        }

        /* State Messages */
        .state-message {
            padding: 36px 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .state-message h2 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 20px;
        }

        .state-message p {
            color: var(--text-muted);
            margin-top: 0;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .error-state {
            border-color: var(--danger-border);
        }

        .error-state h2 {
            color: var(--danger);
        }

        /* Detail Rows */
        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row .label {
            font-weight: 600;
            color: var(--text-sub);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-inner {
                height: auto;
                padding: 12px 0;
                gap: 12px;
            }
            .nav-menu {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 4px;
            }
            .header, .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .detail-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar" aria-label="Main Navigation">
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="brand-container">
                <svg class="brand-logo" viewBox="0 0 24 24">
                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                </svg>
                <span class="brand-title">Water Refilling Station</span>
            </a>

            <ul class="nav-menu">
                <li>
                    <a href="{{ url('/') }}" class="nav-link {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/customers') }}" class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                        Customers
                    </a>
                </li>
                <li>
                    <a href="{{ url('/products') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ url('/orders') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ url('/deliveries') }}" class="nav-link {{ request()->is('deliveries*') ? 'active' : '' }}">
                        Deliveries
                    </a>
                </li>
            </ul>

            <div class="nav-user-area">
                @auth
                    <div class="user-greeting">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->isAdmin())
                            <span class="role-badge admin">Admin</span>
                        @else
                            <span class="role-badge user">User</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline; margin: 0;">
                        @csrf
                        <button type="submit" class="nav-logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log In</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
