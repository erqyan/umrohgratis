@extends('layouts.jamaah', ['user' => auth()->user()])

@section('title', 'Status Pembayaran')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <a href="{{ route('dashboard') }}" style="color: #0c8a63; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px;">
            <i class="fa-solid fa-chevron-left"></i> Kembali ke Dashboard
        </a>

        <div style="background: #fff; border-radius: 24px; padding: 32px 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); margin-bottom: 24px; text-align: center;">
            @if($pembayaran->status === 'ditolak')
                <div style="width: 88px; height: 88px; border-radius: 50%; background: #ffe6e6; display: grid; place-items: center; margin: 0 auto 18px; color: #d4483c; font-size: 2.4rem;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 10px; color: #d4483c;">Pembayaran Ditolak</h1>
                <p style="color: #5c7264; line-height: 1.7;">Maaf, pembayaran Anda ditolak oleh admin. Silakan periksa alasan di bawah dan lakukan pembayaran ulang.</p>
            @elseif($pembayaran->status === 'terverifikasi')
                <div style="width: 88px; height: 88px; border-radius: 50%; background: #ecf9f1; display: grid; place-items: center; margin: 0 auto 18px; color: #0c8a63; font-size: 2.4rem;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 10px;">Pembayaran Terverifikasi</h1>
                <p style="color: #5c7264; line-height: 1.7;">Alhamdulillah! Pembayaran Anda telah terverifikasi. Pendaftaran umrah Anda aktif.</p>
            @else
                <div style="width: 88px; height: 88px; border-radius: 50%; background: #ecf9f1; display: grid; place-items: center; margin: 0 auto 18px; color: #0c8a63; font-size: 2.4rem;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 10px;">Bukti Pembayaran Berhasil Dikirim</h1>
                <p style="color: #5c7264; line-height: 1.7;">Terima kasih. Bukti pembayaran Anda telah kami terima dan sedang menunggu proses verifikasi dari Smart Umrah.</p>
            @endif
        </div>

        @if($pembayaran->status === 'ditolak' && $notifikasiPenolakan)
        <div style="background: #fff5f5; border: 1px solid #f5c2c2; border-left: 4px solid #d4483c; border-radius: 18px; padding: 20px 22px; margin-bottom: 24px;">
            <div style="display: flex; gap: 12px; align-items: flex-start;">
                <i class="fa-solid fa-comment-dots" style="color: #d4483c; font-size: 1.3rem; margin-top: 2px;"></i>
                <div style="flex: 1;">
                    <strong style="display: block; color: #d4483c; font-size: 0.95rem; margin-bottom: 8px;">Pesan dari Admin: {{ $notifikasiPenolakan->judul }}</strong>
                    <p style="color: #5c4848; font-size: 0.9rem; line-height: 1.6; margin: 0;">{{ $notifikasiPenolakan->pesan }}</p>
                    <small style="color: #9ca9a2; font-size: 0.75rem; display: block; margin-top: 10px;">{{ $notifikasiPenolakan->created_at->format('d F Y, H:i') }}</small>
                </div>
            </div>
        </div>
        @endif

        <div style="background: #fff; border-radius: 20px; padding: 22px; border: 1px solid #dbe6dc; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 18px;">Detail Pembayaran</h3>
            <div style="display: flex; justify-content: space-between; gap: 14px; margin-bottom: 14px;">
                <span style="color: #6b7a70; font-size: 0.9rem;">Paket Umrah</span>
                <strong style="font-size: 0.9rem; text-align: right;">{{ $paket->nama }} - {{ $paket->durasi_text }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 14px; margin-bottom: 14px;">
                <span style="color: #6b7a70; font-size: 0.9rem;">Nama Jamaah</span>
                <strong style="font-size: 0.9rem;">{{ $pembayaran->pendaftaran->jamaah->nama ?? '-' }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 14px; margin-bottom: 14px;">
                <span style="color: #6b7a70; font-size: 0.9rem;">Metode Bayar</span>
                <strong style="font-size: 0.9rem;">{{ $pembayaran->metode }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 14px; margin-bottom: 14px;">
                <span style="color: #6b7a70; font-size: 0.9rem;">Tanggal Upload</span>
                <strong style="font-size: 0.9rem;">{{ $pembayaran->created_at->format('d F Y H:i') }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 14px; margin-bottom: 16px;">
                <span style="color: #6b7a70; font-size: 0.9rem;">Nominal Pembayaran</span>
                <strong style="font-size: 1rem; color: #0c8a63;">Rp {{ number_format($pembayaran->total, 0, ',', '.') }}</strong>
            </div>
            <div style="text-align: center;">
                @if($pembayaran->status === 'terverifikasi')
                    <span style="display: inline-flex; align-items: center; gap: 8px; background: #e8f5f0; color: #0c8a63; border-radius: 999px; padding: 10px 16px; font-size: 0.85rem; font-weight: 700;">
                        <i class="fa-solid fa-check-circle"></i> Pembayaran Terverifikasi
                    </span>
                @elseif($pembayaran->status === 'ditolak')
                    <span style="display: inline-flex; align-items: center; gap: 8px; background: #ffe6e6; color: #d4483c; border-radius: 999px; padding: 10px 16px; font-size: 0.85rem; font-weight: 700;">
                        <i class="fa-solid fa-times-circle"></i> Pembayaran Ditolak
                    </span>
                @else
                    <span style="display: inline-flex; align-items: center; gap: 8px; background: #fff4e6; color: #b45309; border-radius: 999px; padding: 10px 16px; font-size: 0.85rem; font-weight: 700;">
                        <i class="fa-solid fa-clock"></i> Menunggu Verifikasi Admin
                    </span>
                @endif
            </div>
        </div>

        <div style="background: #f4fbf7; border: 1px solid #d4ebd9; border-radius: 18px; padding: 18px 20px; margin-bottom: 24px;">
            <strong style="display: block; color: #1d4f29; font-size: 0.92rem; margin-bottom: 6px;">Catatan</strong>
            <p style="color: #5c7264; font-size: 0.88rem; line-height: 1.6; margin: 0;">Admin Smart Umrah akan memvalidasi pembayaran dalam waktu maksimal 1x24 jam. Anda akan menerima notifikasi setelah pembayaran dikonfirmasi.</p>
        </div>

        <div style="display: grid; gap: 14px;">
            <a href="{{ route('pembayaran.invoice', [$paket->id, $pembayaran->id]) }}" target="_blank" class="btn btn-success"><i class="fa-solid fa-file-pdf"></i> Unduh Invoice (PDF)</a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-success">Kembali ke Dashboard</a>
        </div>
    </div>
@endsection
