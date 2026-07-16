<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Umrah — Wujudkan Perjalanan Ibadah</title>
    <meta name="description" content="Platform pendaftaran umrah terpercaya. Pilih paket, daftar online, dan kelola perjalanan ibadah Anda dengan mudah dan aman.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #0c8a63;
            --green-dark: #087554;
            --green-light: #e8f5f0;
            --gold: #d4a137;
            --muted: #6b7280;
            --bg: #f7faf7;
        }
        * { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            color: #1b1b18;
            overflow-x: hidden;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            padding: 96px 0 60px;
            background: linear-gradient(160deg, #f0f7f3 0%, #f7faf7 45%, #fff 100%);
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -10%; right: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(12,138,99,0.25), transparent 70%);
            filter: blur(40px);
            border-radius: 50%;
            animation: floatBlob 10s infinite alternate ease-in-out;
            z-index: 0;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -15%; left: -10%;
            width: 450px; height: 450px;
            background: radial-gradient(circle, rgba(212,161,55,0.2), transparent 70%);
            filter: blur(40px);
            border-radius: 50%;
            animation: floatBlob 12s infinite alternate-reverse ease-in-out;
            z-index: 0;
        }
        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-40px, 50px) scale(1.1); }
        }
        .hero .container { position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(12,138,99,0.1); color: var(--green-dark);
            border: 1px solid rgba(12,138,99,0.2);
            border-radius: 999px; padding: 8px 18px;
            font-size: .85rem; font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(12,138,99,0.08);
        }
        .hero-title { font-size: clamp(2rem, 4.5vw, 3.2rem); font-weight: 800; line-height: 1.15; letter-spacing: -0.03em; }
        .hero-title .hl { 
            background: linear-gradient(135deg, var(--green), #20b2aa); 
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; 
            text-shadow: 0 4px 16px rgba(12,138,99,0.2);
        }
        .hero-sub { color: var(--muted); font-size: 1.05rem; line-height: 1.7; max-width: 540px; }
        .hero-cta { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 30px; }
        .btn-cta {
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: #fff; border: none; border-radius: 12px;
            padding: 13px 28px; font-weight: 700; font-size: 1rem;
            box-shadow: 0 8px 24px rgba(12,138,99,0.35);
            transition: all .3s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            position: relative; overflow: hidden;
        }
        .btn-cta::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left .5s ease;
        }
        .btn-cta:hover::after { left: 100%; }
        .btn-cta:hover { color: #fff; transform: translateY(-3px); box-shadow: 0 12px 32px rgba(12,138,99,0.45); }
        .btn-ghost-cta {
            background: rgba(255,255,255,0.8); color: #1b1b18; border: 1px solid #e8eee9;
            backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            border-radius: 12px; padding: 13px 26px; font-weight: 700; font-size: 1rem;
            transition: all .3s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .btn-ghost-cta:hover { background: #fff; border-color: var(--green); color: var(--green-dark); transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }

        .hero-features { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 36px; }
        .hero-feature { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid #eef2ed; border-radius: 16px; padding: 14px 16px; box-shadow: 0 6px 16px rgba(0,0,0,0.05); transition: transform .2s; }
        .hero-feature:hover { transform: translateY(-2px); }
        .hero-feature-icon { width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--green-light), #fff); color: var(--green); display: grid; place-items: center; font-size: 1.1rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(12,138,99,0.1); }
        .hero-feature h6 { margin: 0; font-weight: 700; font-size: .92rem; }
        .hero-feature p { margin: 2px 0 0; font-size: .78rem; color: var(--muted); }

        /* Hero image card */
        .hero-visual { position: relative; perspective: 1000px; }
        .hero-card-main {
            border-radius: 28px; color: #fff;
            box-shadow: 0 24px 64px rgba(0,0,0,0.2);
            position: relative; overflow: hidden;
            background-image: url('{{ asset('images/hero_mecca.jpg') }}');
            background-size: cover; background-position: center;
            height: 480px; display: flex; flex-direction: column; justify-content: flex-end;
            transform: rotateY(-5deg) rotateX(2deg);
            transition: transform .4s ease;
        }
        .hero-card-main:hover { transform: rotateY(0) rotateX(0); }
        .hero-card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 50%, transparent 100%);
            z-index: 1;
        }
        .hero-card-glass {
            position: relative; z-index: 2;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 20px; padding: 24px; margin: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .hero-mosque-icon { font-size: 2.5rem; margin-bottom: 12px; opacity: .95; color: var(--gold); text-shadow: 0 2px 10px rgba(212,161,55,0.5); }
        .hero-card-glass h3 { font-weight: 800; margin-bottom: 6px; font-size: 1.25rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .hero-card-glass p { opacity: .95; margin-bottom: 0; font-size: .95rem; line-height: 1.5; text-shadow: 0 1px 3px rgba(0,0,0,0.3); }
        .hero-stat-badge {
            position: absolute; bottom: -18px; right: -8px;
            background: #fff; border-radius: 16px; padding: 12px 18px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.12); color: #1b1b18;
            display: flex; align-items: center; gap: 10px;
        }
        .hero-stat-badge .num { font-size: 1.4rem; font-weight: 800; color: var(--green); line-height: 1; }
        .hero-stat-badge .lbl { font-size: .72rem; color: var(--muted); }
        .hero-float-card {
            position: absolute; top: -14px; left: -20px;
            background: #fff; border-radius: 14px; padding: 10px 14px;
            box-shadow: 0 10px 28px rgba(0,0,0,0.1);
            display: flex; align-items: center; gap: 10px;
        }
        .hero-float-card .icon { width: 34px; height: 34px; border-radius: 9px; background: #fff4e6; color: var(--gold); display: grid; place-items: center; font-size: .85rem; }
        .hero-float-card h6 { margin: 0; font-size: .78rem; font-weight: 700; }
        .hero-float-card p { margin: 0; font-size: .68rem; color: var(--muted); }

        /* ===== SECTIONS ===== */
        .section { padding: 80px 0; }
        .section-title { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; letter-spacing: -0.02em; }
        .section-sub { color: var(--muted); max-width: 600px; margin: 0 auto; }
        .section-eyebrow { color: var(--green); font-weight: 700; font-size: .85rem; text-transform: uppercase; letter-spacing: .08em; }

        /* Stats strip */
        .stats-strip { 
            background: linear-gradient(135deg, rgba(12,138,99,0.95), rgba(8,117,84,0.98)); 
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 32px; padding: 48px 40px; color: #fff; 
            box-shadow: 0 32px 64px rgba(12,138,99,0.3); 
            position: relative; overflow: hidden;
        }
        .stats-strip::before {
            content: ''; position: absolute; top: -50%; left: -20%; width: 140%; height: 200%;
            background: radial-gradient(ellipse, rgba(255,255,255,0.08), transparent 60%);
            animation: rotateBg 20s linear infinite;
        }
        @keyframes rotateBg { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .stat-item { text-align: center; position: relative; z-index: 1; }
        .stat-item .num { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; line-height: 1; text-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .stat-item .lbl { opacity: .9; font-size: .95rem; margin-top: 8px; font-weight: 500; }

        /* Traffic visitor card */
        .visitor-card { background: #fff; border: 1px solid #eef2ed; border-radius: 24px; padding: 32px; display: flex; align-items: center; gap: 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); flex-wrap: wrap; }
        .visitor-icon { width: 72px; height: 72px; border-radius: 18px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: #fff; display: grid; place-items: center; font-size: 1.9rem; flex-shrink: 0; box-shadow: 0 10px 24px rgba(12,138,99,0.3); }
        .visitor-info { flex: 1; min-width: 200px; }
        .visitor-num { font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; color: var(--green); line-height: 1; }
        .visitor-label { font-size: 1.05rem; font-weight: 700; color: #1b1b18; margin-top: 6px; }
        .visitor-sub { font-size: .88rem; color: var(--muted); margin-top: 4px; }
        @media (max-width: 576px) { .visitor-card { padding: 24px; } }

        /* Paket cards */
        .paket-card { background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid #eef2ed; box-shadow: 0 8px 30px rgba(0,0,0,0.05); transition: transform .25s, box-shadow .25s; height: 100%; display: flex; flex-direction: column; }
        .paket-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(12,138,99,0.15); }
        .paket-head { padding: 24px; color: #fff; position: relative; }
        .paket-head.reguler { background: linear-gradient(135deg, #0c8a63, #087554); }
        .paket-head.plus { background: linear-gradient(135deg, #d4a137, #b8860b); }
        .paket-head.vip { background: linear-gradient(135deg, #9370db, #8b5fbf); }
        .paket-tag { display: inline-block; background: rgba(255,255,255,0.25); padding: 4px 12px; border-radius: 999px; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 10px; }
        .paket-name { font-size: 1.35rem; font-weight: 800; margin: 0; }
        .paket-dur { font-size: .85rem; opacity: .9; margin-top: 2px; }
        .paket-price { font-size: 1.7rem; font-weight: 800; margin-top: 12px; }
        .paket-price small { font-size: .85rem; font-weight: 500; opacity: .85; }
        .paket-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
        .paket-fas { list-style: none; padding: 0; margin: 0 0 18px; }
        .paket-fas li { display: flex; align-items: center; gap: 8px; font-size: .88rem; color: #4b6858; padding: 5px 0; }
        .paket-fas li i { color: var(--green); font-size: .8rem; width: 16px; }
        .paket-meta { display: flex; gap: 16px; font-size: .8rem; color: var(--muted); margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f0f4ef; }
        .paket-meta span i { color: var(--green); }
        .btn-paket { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; border-radius: 14px; font-weight: 700; text-decoration: none; transition: all .2s; margin-top: auto; }
        .btn-paket.outline { background: #fff; border: 1px solid #e8eee9; color: #1b1b18; }
        .btn-paket.outline:hover { background: var(--green-light); border-color: var(--green); color: var(--green-dark); }
        .btn-paket.solid { background: var(--green); color: #fff; }
        .btn-paket.solid:hover { background: var(--green-dark); color: #fff; }
        .paket-badge-popular { position: absolute; top: 16px; right: 16px; background: #fff; color: var(--gold); padding: 5px 12px; border-radius: 999px; font-size: .72rem; font-weight: 800; text-transform: uppercase; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

        /* Features */
        .feature-card { background: #fff; border-radius: 22px; padding: 30px; border: 1px solid #eef2ed; height: 100%; transition: transform .25s, box-shadow .25s; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.08); }
        .feature-icon { width: 58px; height: 58px; border-radius: 16px; display: grid; place-items: center; font-size: 1.4rem; margin-bottom: 18px; }
        .fi-1 { background: var(--green-light); color: var(--green); }
        .fi-2 { background: #fff4e6; color: var(--gold); }
        .fi-3 { background: #e6f7ff; color: #0ea5e9; }
        .fi-4 { background: #fee2e2; color: #ef4444; }
        .fi-5 { background: #f3e8ff; color: #a855f7; }
        .fi-6 { background: #fef9c3; color: #ca8a04; }
        .feature-card h5 { font-weight: 700; margin-bottom: 8px; }
        .feature-card p { color: var(--muted); font-size: .92rem; margin: 0; line-height: 1.6; }

        /* Testimoni */
        .testi-card { background: #fff; border-radius: 22px; padding: 28px; border: 1px solid #eef2ed; height: 100%; position: relative; }
        .testi-quote { font-size: 2.5rem; color: var(--green-light); line-height: 1; position: absolute; top: 18px; right: 22px; font-family: Georgia, serif; }
        .testi-stars { color: var(--gold); margin-bottom: 12px; }
        .testi-text { color: #374151; line-height: 1.7; font-size: .95rem; }
        .testi-user { display: flex; align-items: center; gap: 12px; margin-top: 18px; }
        .testi-avatar { width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: #fff; display: grid; place-items: center; font-weight: 700; }
        .testi-user h6 { margin: 0; font-weight: 700; }
        .testi-user small { color: var(--muted); }

        /* CTA */
        .cta-section { background: linear-gradient(135deg, var(--green), var(--green-dark)); border-radius: 32px; padding: 56px; color: #fff; text-align: center; position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; inset: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="160" cy="40" r="50" fill="rgba(255,255,255,0.06)"/><circle cx="40" cy="160" r="40" fill="rgba(255,255,255,0.05)"/></svg>') no-repeat center; background-size: cover; }

        /* Footer */
        footer { background: #0f1f17; color: #c4d4ca; padding: 64px 0 28px; }
        footer h5 { color: #fff; font-weight: 700; margin-bottom: 18px; font-size: 1rem; }
        footer a { color: #9bb3a3; text-decoration: none; font-size: .9rem; transition: color .2s; }
        footer a:hover { color: #fff; }
        .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
        .footer-brand .logo { width: 44px; height: 44px; border-radius: 12px; background: var(--green); display: grid; place-items: center; color: #fff; font-size: 1.2rem; }
        .footer-brand h4 { margin: 0; color: #fff; font-weight: 800; }
        .social-btn { width: 38px; height: 38px; border-radius: 10px; background: rgba(255,255,255,0.08); display: grid; place-items: center; color: #fff; transition: background .2s; }
        .social-btn:hover { background: var(--green); color: #fff; }

        /* Animations */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 991px) {
            .hero { padding: 84px 0 50px; }
            .hero-visual { margin-top: 32px; }
            .hero-float-card { left: 0; }
            .hero-stat-badge { right: 0; }
        }
        @media (max-width: 576px) {
            .hero { padding: 76px 0 44px; }
            .hero-features { grid-template-columns: 1fr; }
            .hero-card-main { padding: 26px; }
            .hero-mosque-icon { font-size: 3rem; }
            .cta-section { padding: 36px 24px; }
            .stats-strip { padding: 28px 20px; }
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <!-- ===== HERO ===== -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="hero-badge"><i class="fa-solid fa-circle-check"></i> Travel Umrah Resmi & Terpercaya</span>
                    <h1 class="hero-title">Wujudkan <span class="hl">Perjalanan Ibadah</span> Umrah Anda</h1>
                    <p class="hero-sub mt-3">Rencanakan, daftar, dan kelola perjalanan umrah dengan platform digital yang mudah — paket lengkap, pembayaran aman, dan pendampingan setiap langkah ibadah.</p>

                    <div class="hero-cta">
                        <a href="#paket" class="btn-cta"><i class="fa-solid fa-suitcase-rolling"></i> Lihat Paket</a>
                        @guest
                            <a href="{{ route('register') }}" class="btn-ghost-cta"><i class="fa-solid fa-user-plus"></i> Daftar Sekarang</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-ghost-cta"><i class="fa-solid fa-gauge"></i> Dashboard Saya</a>
                        @endguest
                    </div>

                    <div class="hero-features">
                        <div class="hero-feature">
                            <div class="hero-feature-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <div><h6>Pendaftaran Online</h6><p>Mudah & cepat 24/7</p></div>
                        </div>
                        <div class="hero-feature">
                            <div class="hero-feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div><h6>Pembayaran Aman</h6><p>Transaksi terlindungi</p></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual">
                        <div class="hero-card-main">
                            <div class="hero-card-overlay"></div>
                            <div class="hero-card-glass">
                                <i class="fa-solid fa-mosque hero-mosque-icon"></i>
                                <h3>Bismillah, Mari Beribadah</h3>
                                <p>Temukan ketenangan batin dengan perjalanan umrah yang berkesan, didampingi tim profesional kami.</p>
                            </div>
                        </div>
                        <div class="hero-stat-badge">
                            <div><div class="num">{{ $jamaahCount }}+</div><div class="lbl">Jamaah Bahagia</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS STRIP ===== -->
    <section class="container" style="margin-top: -40px; position: relative; z-index: 2;">
        <div class="stats-strip reveal">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="num counter" data-target="{{ $jamaahCount }}">0</div>
                        <div class="lbl">Jamaah Terlayani</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="num counter" data-target="{{ $kloterCount }}">0</div>
                        <div class="lbl">Kloter Terlaksana</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="num"><span class="counter" data-target="98">0</span>%</div>
                        <div class="lbl">Tingkat Kepuasan</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="num"><span class="counter" data-target="24">0</span>/7</div>
                        <div class="lbl">Dukungan Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TRAFFIC VISITOR ===== -->
    <section class="container" style="margin-top: 24px;">
        <div class="visitor-card reveal">
            <div class="visitor-icon"><i class="fa-solid fa-eye"></i></div>
            <div class="visitor-info">
                <div class="visitor-num"><span class="counter" data-target="{{ $totalVisitors }}">{{ $totalVisitors }}</span></div>
                <div class="visitor-label">Total Pengunjung Website</div>
                <div class="visitor-sub">Terima kasih telah mengunjungi Smart Umrah</div>
            </div>
        </div>
    </section>

    <!-- ===== PAKET ===== -->
    <section class="section" id="paket">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <div class="section-eyebrow mb-2">Pilihan Paket</div>
                <h2 class="section-title">Paket Umrah Pilihan</h2>
                <p class="section-sub mt-2">Pilih paket yang paling sesuai dengan kebutuhan dan budget Anda untuk perjalanan ibadah yang berkesan.</p>
            </div>

            <div class="row g-4">
                @foreach($pakets as $paket)
                    <div class="col-md-4 reveal">
                        <div class="paket-card">
                            @if($paket->tipe === 'plus')
                                <span class="paket-badge-popular"><i class="fa-solid fa-fire"></i> Terpopuler</span>
                            @endif
                            <div class="paket-head {{ $paket->tipe }}" @if($paket->image) style="background-image: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0.25)), url('{{ asset('storage/' . $paket->image) }}'); background-size: cover; background-position: center;" @endif>
                                <span class="paket-tag">{{ $paket->tipe_label }}</span>
                                <h3 class="paket-name">{{ $paket->nama }}</h3>
                                <div class="paket-dur"><i class="fa-solid fa-clock"></i> {{ $paket->durasi_text }}</div>
                                <div class="paket-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}<small> / orang</small></div>
                            </div>
                            <div class="paket-body">
                                <div class="paket-meta">
                                    <span><i class="fa-solid fa-hotel"></i> {{ $paket->hotel ?? '-' }}</span>
                                    <span><i class="fa-solid fa-plane"></i> {{ $paket->maskapai ?? '-' }}</span>
                                </div>
                                <ul class="paket-fas">
                                    @foreach(array_slice($paket->fasilitas ?? [], 0, 5) as $fas)
                                        <li><i class="fa-solid fa-check"></i> {{ $fas }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('paket.detail', $paket->id) }}" class="btn-paket solid"><i class="fa-solid fa-arrow-right"></i> Lihat Detail Paket</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== FITUR ===== -->
    <section class="section bg-white" id="fitur">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <div class="section-eyebrow mb-2">Keunggulan</div>
                <h2 class="section-title">Kenapa Memilih Smart Umrah?</h2>
                <p class="section-sub mt-2">Kami berkomitmen memberikan pengalaman umrah terbaik dengan layanan profesional dan terpercaya.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-1"><i class="fa-solid fa-laptop-file"></i></div>
                        <h5>Pendaftaran Digital</h5>
                        <p>Daftar umrah sepenuhnya online tanpa antrian. Isi data, unggah dokumen, dan selesaikan semuanya dari rumah.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-2"><i class="fa-solid fa-tags"></i></div>
                        <h5>Harga Transparan</h5>
                        <p>Tidak ada biaya tersembunyi. Semua rincian biaya tertera jelas sejak awal pendaftaran hingga keberangkatan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-3"><i class="fa-solid fa-credit-card"></i></div>
                        <h5>Pembayaran Mudah</h5>
                        <p>Transfer bank, virtual account, atau e-wallet. Pilih metode pembayaran yang paling nyaman untuk Anda.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-4"><i class="fa-solid fa-headset"></i></div>
                        <h5>Support 24/7</h5>
                        <p>Tim dukungan kami siap membantu Anda kapan saja, sebelum, selama, dan setelah perjalanan ibadah.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-5"><i class="fa-solid fa-user-tie"></i></div>
                        <h5>Muthawif Profesional</h5>
                        <p>Didampingi pemandu umrah berpengalaman dan bersertifikat untuk memastikan ibadah Anda berjalan khusyuk.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 reveal">
                    <div class="feature-card">
                        <div class="feature-icon fi-6"><i class="fa-solid fa-map-location-dot"></i></div>
                        <h5>Itinerary Terstruktur</h5>
                        <p>Jadwal perjalanan yang jelas dan terorganisir, mengunjungi tempat bersejarah dengan waktu yang optimal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONI ===== -->
    <section class="section" id="testimoni">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <div class="section-eyebrow mb-2">Kata Mereka</div>
                <h2 class="section-title">Testimoni Jamaah Kami</h2>
                <p class="section-sub mt-2">Ribuan jamaah telah mempercayakan perjalanan ibadah mereka kepada Smart Umrah.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 reveal">
                    <div class="testi-card">
                        <div class="testi-quote">&ldquo;</div>
                        <div class="testi-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="testi-text">Pendaftarannya sangat mudah dan cepat. Semua proses dilakukan online, tinggal unggah dokumen dan bayar. Timnya juga responsif.</p>
                        <div class="testi-user">
                            <div class="testi-avatar">SA</div>
                            <div><h6>Siti Aminah</h6><small>Jamaah Paket Reguler</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="testi-card">
                        <div class="testi-quote">&ldquo;</div>
                        <div class="testi-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="testi-text">Pelayanan luar biasa! Muthawifnya sabar dan penuh perhatian. Hotelnya juga nyaman sesuai yang dijanjikan. Recommended!</p>
                        <div class="testi-user">
                            <div class="testi-avatar">AF</div>
                            <div><h6>Ahmad Fauzi</h6><small>Jamaah Paket Plus</small></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 reveal">
                    <div class="testi-card">
                        <div class="testi-quote">&ldquo;</div>
                        <div class="testi-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="testi-text">Platformnya transparan, harga jelas tidak ada biaya tersembunyi. Bisa pantau status pendaftaran kapan saja. Terima kasih Smart Umrah!</p>
                        <div class="testi-user">
                            <div class="testi-avatar">FZ</div>
                            <div><h6>Fatimah Zahra</h6><small>Jamaah Paket VIP</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="section pt-0">
        <div class="container">
            <div class="cta-section reveal">
                <div style="position: relative; z-index: 1;">
                    <h2 class="fw-bold mb-3" style="font-size: clamp(1.5rem, 3vw, 2.2rem);">Siap Memulai Perjalanan Ibadah Anda?</h2>
                    <p class="mb-4" style="opacity: .9; font-size: 1.05rem;">Bergabunglah dengan ribuan jamaah yang telah merasakan kemudahan mendaftar umrah bersama Smart Umrah.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @guest
                            <a href="{{ route('register') }}" class="btn-cta" style="background: #fff; color: var(--green-dark);"><i class="fa-solid fa-user-plus"></i> Daftar Gratis Sekarang</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-cta" style="background: #fff; color: var(--green-dark);"><i class="fa-solid fa-gauge"></i> Lihat Dashboard</a>
                        @endguest
                        <a href="https://wa.me/6281325874378" target="_blank" class="btn-ghost-cta" style="background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.4);"><i class="fa-brands fa-whatsapp"></i> Konsultasi via WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer id="kontak">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Smart Umrah" style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.25);">
                        <div>
                            <h4>Smart Umrah</h4>
                            <p style="font-size: 0.72rem; color: #a3b8ab; margin: 0;">PT. KHOTIMAH AHMAD TOUR & TRAVEL</p>
                        </div>
                    </div>
                    <p style="font-size: .9rem; line-height: 1.7;">Platform pendaftaran umrah terpercaya. Kami berkomitmen membantu Anda mewujudkan ibadah umrah dengan mudah, aman, dan berkesan.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="https://www.instagram.com/khotimah_ahmad.tour?igsh=MWxraHZhbnNqNnRmcw==" target="_blank" class="social-btn" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.facebook.com/share/1Bj5Vj6R28/?mibextid=wwXIfr" target="_blank" class="social-btn" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://wa.me/6281325874378" target="_blank" class="social-btn" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://maps.app.goo.gl/suqwVzM7WNLJBvL9A?g_st=iw" target="_blank" class="social-btn" title="Lokasi Google Maps"><i class="fa-solid fa-location-dot"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h5>Menu</h5>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('home') }}#paket">Paket Umrah</a></li>
                        <li><a href="{{ route('home') }}#fitur">Fitur</a></li>
                        <li><a href="{{ route('home') }}#testimoni">Testimoni</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h5>Layanan</h5>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="{{ route('register') }}">Pendaftaran</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="https://wa.me/6281325874378" target="_blank">Bantuan</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="mailto:ptkatt22@gmail.com"><i class="fa-solid fa-envelope me-2"></i> ptkatt22@gmail.com</a></li>
                        <li><a href="https://wa.me/6281325874378" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i> +62 813-2587-4378</a></li>
                        <li><a href="https://maps.app.goo.gl/suqwVzM7WNLJBvL9A?g_st=iw" target="_blank"><i class="fa-solid fa-location-dot me-2"></i> Lihat Lokasi di Google Maps</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <small>&copy; {{ date('Y') }} PT. KHOTIMAH AHMAD TOUR & TRAVEL (Smart Umrah). Semua hak dilindungi.</small>
                <small>Dibuat dengan <i class="fa-solid fa-heart text-danger"></i> untuk jamaah Indonesia</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 30) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Reveal on scroll
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // Animated counters
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseInt(el.dataset.target);
                const duration = 1800;
                const start = performance.now();
                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const value = Math.floor(eased * target);
                    el.textContent = value.toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(step);
                    else el.textContent = target.toLocaleString('id-ID');
                };
                requestAnimationFrame(step);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.5 });
        document.querySelectorAll('.counter').forEach(el => counterObserver.observe(el));
    </script>
</body>
</html>
