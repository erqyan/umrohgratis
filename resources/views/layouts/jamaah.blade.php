<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Smart Umrah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; color: #1b1b18; font-family: "Segoe UI", sans-serif; }
        .top-navbar { background: #fff; padding: 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 8px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 100; }
        .navbar-left { display: flex; align-items: center; gap: 16px; flex: 1; }
        .navbar-toggle { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #333; display: none; }
        .navbar-brand { display: flex; align-items: center; gap: 8px; text-decoration: none; color: #0c8a63; font-weight: 700; font-size: 1rem; }
        .navbar-brand i { font-size: 1.25rem; }
        .navbar-right { display: flex; align-items: center; gap: 12px; }
        .profile-btn { background: #0c8a63; border: none; width: 40px; height: 40px; border-radius: 50%; color: #fff; cursor: pointer; display: grid; place-items: center; font-size: 1.1rem; transition: all .2s; position: relative; }
        .profile-btn:hover { background: #087554; }
        .dropdown-profile { position: absolute; top: 52px; right: 0; background: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 200px; overflow: hidden; display: none; z-index: 200; }
        .dropdown-profile.show { display: block; }
        .dropdown-profile a { display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #1b1b18; text-decoration: none; font-size: 0.9rem; }
        .dropdown-profile a:hover { background: #f0f5f3; color: #0c8a63; }
        .sidebar { width: 280px; background: #fff; padding: 20px; border-right: 1px solid #e8eee9; max-height: calc(100vh - 64px); overflow-y: auto; position: sticky; top: 64px; display: flex; flex-direction: column; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e8eee9; }
        .brand-icon { width: 40px; height: 40px; border-radius: 10px; background: #0c8a63; display: grid; place-items: center; color: #fff; font-size: 1.25rem; flex-shrink: 0; }
        .brand-text h3 { margin: 0; font-size: 0.95rem; font-weight: 700; color: #0c8a63; }
        .brand-text p { margin: 0; font-size: 0.75rem; color: #7d8d83; }
        .menu-section { margin-bottom: 18px; }
        .menu-section:last-of-type { margin-bottom: 0; }
        .menu-title { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #9ca9a2; margin-bottom: 10px; letter-spacing: .06em; }
        .menu-list { list-style: none; }
        .menu-list li { margin-bottom: 6px; }
        .menu-list a { display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 8px; color: #6b7570; text-decoration: none; transition: all .2s; font-weight: 500; font-size: 0.9rem; }
        .menu-list a:hover { background: #f0f5f3; color: #0c8a63; }
        .menu-list a.active { background: #0c8a63; color: #fff; }
        .menu-list i { width: 18px; text-align: center; }
        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid #e8eee9; }
        .profile-card { background: #f7fff8; border-radius: 12px; padding: 12px; display: flex; align-items: center; gap: 10px; }
        .profile-avatar { width: 40px; height: 40px; border-radius: 10px; background: #0c8a63; display: grid; place-items: center; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
        .profile-info h5 { margin: 0; font-size: 0.85rem; font-weight: 700; color: #1b1b18; }
        .profile-info p { margin: 0; font-size: 0.7rem; color: #9ca9a2; }
        .main-content { flex: 1; padding: 24px; overflow-y: auto; min-width: 0; }
        .alert-flash { margin-bottom: 20px; }
        @media (max-width: 768px) {
            .navbar-toggle { display: block; }
            .sidebar { position: fixed; left: 0; top: 64px; width: 280px; height: calc(100vh - 64px); background: #fff; z-index: 50; transform: translateX(-100%); transition: transform .3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { padding: 16px; }
        }
        @media (min-width: 769px) { .sidebar { display: flex !important; transform: none !important; } }
    </style>
</head>
<body>
    <nav class="top-navbar">
        <div class="navbar-left">
            <button class="navbar-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"> Smart Umrah
            </a>
        </div>
        <div class="navbar-right" style="position: relative;">
            <button class="profile-btn" onclick="toggleProfile(event)" style="padding: 0; overflow: hidden; display: grid; place-items: center;">
                @if($user->jamaah && $user->jamaah->foto)
                    <img src="{{ asset('storage/' . $user->jamaah->foto) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <i class="fa-solid fa-user"></i>
                @endif
            </button>
            <div class="dropdown-profile" id="profileDropdown">
                <a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="{{ route('profile.show') }}"><i class="fa-solid fa-user"></i> Profil Saya</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" style="all: unset; display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #d4483c; font-size: 0.9rem; width: 100%; cursor: pointer;">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div style="display: flex;">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                <div class="brand-text">
                    <h3>Smart Umrah</h3>
                    <p style="font-size: 0.62rem; line-height: 1.2;">PT. KHOTIMAH AHMAD TOUR & TRAVEL</p>
                </div>
            </div>

            <div class="menu-section">
                <p class="menu-title">Menu Utama</p>
                <ul class="menu-list">
                    @php $current = request()->path(); @endphp
                    <li><a href="{{ route('dashboard') }}" class="{{ $current === 'dashboard' ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                    <li><a href="{{ route('profile.show') }}" class="{{ $current === 'profile' ? 'active' : '' }}"><i class="fa-solid fa-user"></i> Profil Saya</a></li>
                    <li><a href="{{ route('paket.index') }}" class="{{ str_starts_with($current, 'paket') ? 'active' : '' }}"><i class="fa-solid fa-briefcase"></i> Pilih Paket</a></li>
                    <li><a href="{{ route('pendaftaran.index') }}" class="{{ str_starts_with($current, 'status-pendaftaran') ? 'active' : '' }}"><i class="fa-solid fa-file-lines"></i> Status Pendaftaran</a></li>
                </ul>
            </div>

            <div class="menu-section">
                <p class="menu-title">Bantuan</p>
                <ul class="menu-list">
                    <li><a href="https://wa.me/6281325874378" target="_blank"><i class="fa-brands fa-whatsapp"></i> Hubungi Admin</a></li>
                    <li><a href="https://www.instagram.com/khotimah_ahmad.tour?igsh=MWxraHZhbnNqNnRmcw==" target="_blank"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://www.facebook.com/share/1Bj5Vj6R28/?mibextid=wwXIfr" target="_blank"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                    <li><a href="https://maps.app.goo.gl/suqwVzM7WNLJBvL9A?g_st=iw" target="_blank"><i class="fa-solid fa-location-dot"></i> Lokasi Kami</a></li>
                    <li><a href="{{ route('dashboard') }}#faq"><i class="fa-solid fa-circle-question"></i> Bantuan &amp; FAQ</a></li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <div class="profile-card">
                    @if($user->jamaah && $user->jamaah->foto)
                        <img src="{{ asset('storage/' . $user->jamaah->foto) }}" alt="Avatar" class="profile-avatar" style="object-fit: cover;">
                    @else
                        <div class="profile-avatar">{{ strtoupper(mb_substr(trim($user->name ?? 'J'), 0, 1)) }}</div>
                    @endif
                    <div class="profile-info">
                        <h5>{{ $user->name ?? 'Jamaah' }}</h5>
                        <p>Jamaah Terdaftar</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-flash">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-flash">{{ session('error') }}</div>
            @endif
            @if(session('status'))
                <div class="alert alert-info alert-flash">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
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
        document.querySelectorAll('.menu-list a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
