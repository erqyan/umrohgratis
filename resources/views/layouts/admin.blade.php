<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Smart Umrah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f5f5f5; color: #1b1b18; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .navbar-top { background: white; padding: 16px 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 100; display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .navbar-brand-admin { display: flex; align-items: center; gap: 10px; text-decoration: none; font-weight: 700; color: #0c8a63; font-size: 1.1rem; }
        .navbar-brand-admin i { font-size: 1.5rem; }
        .navbar-right { display: flex; align-items: center; gap: 20px; }
        .profile-btn { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #0c8a63, #087554); border: none; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.2s; position: relative; }
        .profile-btn:hover { box-shadow: 0 4px 12px rgba(12,138,99,0.3); transform: translateY(-2px); }
        .dropdown-profile { position: absolute; top: 52px; right: 0; background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 200px; overflow: hidden; display: none; z-index: 200; }
        .dropdown-profile.show { display: block; }
        .dropdown-profile a, .dropdown-profile button { display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #1b1b18; text-decoration: none; font-size: 0.9rem; width: 100%; }
        .dropdown-profile a:hover, .dropdown-profile button:hover { background: #f0f5f3; color: #0c8a63; }
        .dropdown-profile button { all: unset; display: flex; align-items: center; gap: 10px; padding: 12px 16px; font-size: 0.9rem; cursor: pointer; box-sizing: border-box; }
        .container-admin { display: flex; gap: 0; }
        .sidebar-admin { width: 260px; background: white; padding: 20px; border-right: 1px solid #e8eee9; min-height: calc(100vh - 64px); position: sticky; top: 64px; overflow-y: auto; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #e8eee9; }
        .brand-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #0c8a63, #087554); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0; }
        .brand-text h3 { margin: 0; font-size: 0.95rem; font-weight: 700; color: #0c8a63; }
        .brand-text p { margin: 0; font-size: 0.75rem; color: #9ca9a2; }
        .menu-section { margin-bottom: 24px; }
        .menu-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #9ca9a2; margin-bottom: 10px; letter-spacing: 0.06em; }
        .menu-list { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        .menu-list a { display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; color: #6b7570; text-decoration: none; transition: all 0.2s; font-weight: 500; font-size: 0.9rem; }
        .menu-list a:hover { background: #f0f5f3; color: #0c8a63; }
        .menu-list a.active { background: linear-gradient(135deg, #0c8a63, #087554); color: white; }
        .menu-list i { width: 18px; text-align: center; font-size: 1rem; }
        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid #e8eee9; }
        .profile-card { background: #f7fff8; border-radius: 12px; padding: 12px; display: flex; align-items: center; gap: 10px; }
        .profile-avatar { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #0c8a63, #087554); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
        .profile-info h5 { margin: 0; font-size: 0.85rem; font-weight: 700; color: #1b1b18; }
        .profile-info p { margin: 0; font-size: 0.7rem; color: #9ca9a2; }
        .main-content-admin { flex: 1; padding: 24px; overflow-y: auto; min-width: 0; }
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 16px; transition: all 0.2s; }
        .stat-card:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .stat-content { flex: 1; }
        .stat-label { color: #7d8d83; font-size: 0.85rem; margin-bottom: 8px; text-transform: capitalize; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: #0c8a63; margin-bottom: 4px; }
        .stat-sub { font-size: 0.78rem; color: #7d8d83; }
        .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
        .icon-green { background: #e8f5f0; color: #0c8a63; }
        .icon-yellow { background: #fff4e6; color: #f59e0b; }
        .icon-red { background: #ffe6e6; color: #d4483c; }
        .icon-blue { background: #e6f7ff; color: #0ea5e9; }
        .data-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-top: 24px; }
        .badge-soft-green { background: #e8f5f0; color: #0c8a63; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .badge-soft-yellow { background: #fff4e6; color: #b45309; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .badge-soft-red { background: #ffe6e6; color: #d4483c; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 600; }
        .btn-sm-green { background: #0c8a63; color: white; border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; }
        .btn-sm-green:hover { background: #087554; color: white; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
        @media (max-width: 768px) {
            .container-admin { flex-direction: column; }
            .sidebar-admin { width: 100%; min-height: auto; position: relative; top: 0; border-right: none; border-bottom: 1px solid #e8eee9; }
            .main-content-admin { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="navbar-top">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand-admin">
            <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"> Smart Umrah Admin
        </a>
        <div class="navbar-right">
            <div style="position: relative;">
                <button class="profile-btn" onclick="toggleProfile(event)">
                    <i class="fas fa-user"></i>
                </button>
                <div class="dropdown-profile" id="profileDropdown">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #f0f4ef;">
                        <strong style="display: block; font-size: 0.9rem;">{{ auth()->user()->name }}</strong>
                        <small style="color: #9ca9a2;">Administrator</small>
                    </div>
                    <a href="{{ route('home') }}"><i class="fas fa-globe"></i> Lihat Website</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="color: #d4483c;"><i class="fas fa-right-from-bracket"></i> Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-admin">
        <aside class="sidebar-admin">
            <div class="sidebar-brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                <div class="brand-text">
                    <h3>Smart Umrah</h3>
                    <p style="font-size: 0.62rem; line-height: 1.2;">PT. KHOTIMAH AHMAD TOUR & TRAVEL</p>
                </div>
            </div>

            @php $current = request()->path(); @endphp
            <div class="menu-section">
                <div class="menu-title">MAIN MENU</div>
                <ul class="menu-list">
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ str_starts_with($current, 'admin/dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.jamaah') }}" class="{{ str_starts_with($current, 'admin/jamaah') ? 'active' : '' }}"><i class="fas fa-users"></i> Jamaah</a></li>
                    <li><a href="{{ route('admin.paket') }}" class="{{ str_starts_with($current, 'admin/paket') ? 'active' : '' }}"><i class="fas fa-box"></i> Paket Umrah</a></li>
                    <li><a href="{{ route('admin.pendaftaran') }}" class="{{ str_starts_with($current, 'admin/pendaftaran') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i> Pendaftaran</a></li>
                    <li><a href="{{ route('admin.pembayaran') }}" class="{{ str_starts_with($current, 'admin/pembayaran') ? 'active' : '' }}"><i class="fas fa-money-bill"></i> Pembayaran</a></li>
                </ul>
            </div>

            <div class="menu-section">
                <div class="menu-title">VERIFIKASI</div>
                <ul class="menu-list">
                    <li><a href="{{ route('admin.belum.verifikasi') }}"><i class="fas fa-user-clock"></i> Belum Verifikasi</a></li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <div class="profile-card">
                    <div class="profile-avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="profile-info">
                        <h5>{{ auth()->user()->name }}</h5>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="main-content-admin">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleProfile(e) {
            e.stopPropagation();
            document.getElementById('profileDropdown').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.contains(e.target) && !e.target.closest('.profile-btn')) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>
