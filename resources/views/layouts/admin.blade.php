<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Seller Center - Wello Back-Office')</title>

    <link rel="icon" href="{{ asset('wello-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --bg-canvas: #F5F7F2;
            --surface: #FFFFFF;
            --primary: #3C6A00;
            --primary-container: #7CB342;
            --primary-light: #EAEFD9;
            --accent: #FF8F06;
            --text-main: #191C1A;
            --text-muted: #424939;
            --text-light: #737A68;
            --border-subtle: #D8DBD6;
            --shadow-subtle: 0 4px 20px rgba(27, 48, 34, 0.05);
            --shadow-card: 0 10px 30px rgba(27, 48, 34, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Glassmorphism Topbar */
        .admin-topbar {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0 40px;
            height: 72px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-badge {
            background-color: #1B3022;
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .admin-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .admin-nav {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .admin-link {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .admin-link:hover {
            background-color: #ECEFEA;
            color: var(--text-main);
        }

        .admin-link.active {
            background-color: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
        }

        .admin-link-store {
            text-decoration: none;
            color: var(--primary);
            background-color: #EAEFD9;
            border: 1px solid rgba(124, 179, 66, 0.3);
            font-size: 13.5px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 10px;
            margin-left: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .admin-link-store:hover {
            background-color: var(--primary);
            color: #FFFFFF;
        }

        .admin-content {
            flex: 1;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .admin-footer {
            background-color: #ECEFEA;
            color: var(--text-light);
            padding: 24px;
            text-align: center;
            font-size: 13px;
            border-top: 1px solid var(--border-subtle);
        }

        @media (max-width: 768px) {
            .admin-topbar {
                padding: 0 20px;
                height: auto;
                flex-direction: column;
                gap: 12px;
                padding-top: 16px;
                padding-bottom: 16px;
            }
            .admin-content {
                padding: 20px 16px;
            }
            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- TOPBAR -->
    <header class="admin-topbar">
        <div class="admin-brand">
            <span class="admin-badge">Seller Center</span>
            <h1 class="admin-title">Wello Back-Office</h1>
        </div>

        <nav class="admin-nav">
            <a href="/admin/transactions" class="admin-link {{ request()->is('admin/transactions*') ? 'active' : '' }}">
                <i data-lucide="package-search" style="width: 16px; height: 16px;"></i>
                Pesanan Masuk
            </a>
            <a href="/admin/products" class="admin-link {{ request()->is('admin/products') ? 'active' : '' }}">
                <i data-lucide="layout-grid" style="width: 16px; height: 16px;"></i>
                Katalog Produk
            </a>
            <a href="/admin/products/create" class="admin-link {{ request()->is('admin/products/create') ? 'active' : '' }}">
                <i data-lucide="plus-circle" style="width: 16px; height: 16px;"></i>
                Tambah Produk
            </a>
            <a href="/" target="_blank" class="admin-link-store">
                <span>Lihat Toko</span>
                <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
            </a>
        </nav>
    </header>

    <!-- CONTENT -->
    <main class="admin-content">
        @yield('konten_admin')
    </main>

    <!-- FOOTER -->
    <footer class="admin-footer">
        <p style="margin: 0; font-weight: 600;">Wello Fresh Groceries &bull; Back-Office Management System</p>
    </footer>

    <!-- Init Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
