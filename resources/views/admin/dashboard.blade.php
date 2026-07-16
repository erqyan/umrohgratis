@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 4px;">Dashboard</h1>
        <p style="color: #7d8d83; font-size: 0.95rem;">Ringkasan data Smart Umrah</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 8px;">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Jamaah</div>
                <div class="stat-value">{{ number_format($totalJamaah) }}</div>
                <div class="stat-sub">{{ $sudahVerifikasi }} terverifikasi</div>
            </div>
            <div class="stat-icon icon-green"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Paket Aktif</div>
                <div class="stat-value">{{ $paketAktif }}</div>
                <div class="stat-sub">paket umrah tersedia</div>
            </div>
            <div class="stat-icon icon-blue"><i class="fas fa-box"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Belum Verifikasi</div>
                <div class="stat-value">{{ $belumVerifikasi }}</div>
                <div class="stat-sub">menunggu verifikasi</div>
            </div>
            <div class="stat-icon icon-yellow"><i class="fas fa-user-clock"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Pendaftaran Pending</div>
                <div class="stat-value">{{ $pendaftaranPending }}</div>
                <div class="stat-sub">perlu ditindaklanjuti</div>
            </div>
            <div class="stat-icon icon-red"><i class="fas fa-clipboard-list"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value" style="font-size: 1.3rem;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
                <div class="stat-sub">pembayaran terverifikasi</div>
            </div>
            <div class="stat-icon icon-green"><i class="fas fa-money-check-dollar"></i></div>
        </div>
    </div>

    <div class="data-card" style="text-align: center; padding: 40px 20px;">
        <div style="width: 64px; height: 64px; border-radius: 16px; background: #e8f5f0; color: #0c8a63; display: grid; place-items: center; margin: 0 auto 16px; font-size: 1.75rem;">
            <i class="fas fa-users"></i>
        </div>
        <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">Data Jamaah</h2>
        <p style="color: #7d8d83; font-size: 0.9rem; margin: 8px 0 20px;">Kelola seluruh data jamaah terdaftar</p>
        <a href="{{ route('admin.jamaah') }}" class="btn-sm-green" style="padding: 10px 28px; font-size: 0.95rem; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-right"></i> Lihat Semua Jamaah
        </a>
    </div>
@endsection
