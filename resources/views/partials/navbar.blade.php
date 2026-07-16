<nav class="navbar navbar-expand-lg navbar-public fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" class="brand-logo-img">
      <span class="brand-text">Smart <span class="text-success">Umrah</span></span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Menu">
      <i class="fa-solid fa-bars text-success" style="font-size:18px"></i>
    </button>

    {{-- SATU menu tunggal: dipakai desktop (horizontal) & mobile (collapse). Tidak ada duplikat. --}}
    <div class="collapse navbar-collapse justify-content-end align-items-center" id="navMenu">
      <ul class="navbar-nav mb-0 gap-1 align-items-lg-center text-center text-lg-start">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#paket">Paket</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#fitur">Fitur</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#testimoni">Testimoni</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#kontak">Kontak</a></li>
        <li class="nav-item mt-2 mt-lg-0 ms-lg-2 d-flex gap-2 justify-content-center">
          @guest
            <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm w-50 w-lg-auto">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-success btn-sm w-50 w-lg-auto">Daftar</a>
          @else
            <div class="dropdown w-100">
              <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1 mx-auto" data-bs-toggle="dropdown">
                <span class="avatar-sm">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="d-none d-xl-inline">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 14) }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                @if(auth()->user()->isAdmin())
                  <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-2 text-success"></i> Dashboard Admin</a></li>
                @else
                  <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-2 text-success"></i> Dashboard</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</button>
                  </form>
                </li>
              </ul>
            </div>
          @endguest
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  /* Navbar ramping & kompak untuk landing page - hanya SATU menu */
  #mainNav.navbar { padding: 2px 0 !important; min-height: 40px; }
  #mainNav .container { max-width: 1200px; }
  #mainNav .navbar-brand { padding: 0 !important; margin: 0 !important; }
  .navbar-public { transition: all .3s ease; background: rgba(255,255,255,0.96); backdrop-filter: blur(10px); box-shadow: 0 1px 0 rgba(0,0,0,0.04); }
  .navbar-public.scrolled { box-shadow: 0 2px 16px rgba(0,0,0,0.06); }
  .navbar-public .brand-logo { width: 24px; height: 24px; border-radius: 6px; background: linear-gradient(135deg, #0c8a63, #087554); color: #fff; display: grid; place-items: center; font-size: .65rem; box-shadow: 0 4px 12px rgba(12,138,99,0.28); }
  .navbar-public .brand-logo-img { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
  .navbar-public .brand-text { font-weight: 800; font-size: .82rem; color: #1b1b18; }
  .navbar-public .navbar-nav { gap: 1px !important; }
  .navbar-public .nav-link { font-weight: 600; color: #4b5563 !important; border-radius: 7px; padding: 3px 9px !important; transition: all .2s; font-size: .8rem; }
  .navbar-public .nav-link:hover { color: #0c8a63 !important; background: #f0f5f3; }
  .navbar-public .btn-sm { font-size: .76rem; padding: 3px 12px !important; border-radius: 8px; line-height: 1.4; }
  .avatar-sm { width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #0c8a63, #087554); color: #fff; display: grid; place-items: center; font-weight: 700; font-size: .62rem; }
  .navbar-public .dropdown-toggle::after { font-size: .6rem; margin-left: 3px; }
  #mainNav .navbar-toggler i { font-size: 18px !important; }

  /* Saat menu collapse terbuka di mobile, beri jarak agar tidak menempel */
  @media (max-width: 991.98px) {
    #navMenu { padding-top: 8px; padding-bottom: 8px; }
    #navMenu .nav-link { padding: 6px 9px !important; }
  }
</style>
