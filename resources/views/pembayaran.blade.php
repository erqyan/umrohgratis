@extends('layouts.jamaah', ['user' => auth()->user()])

@section('title', 'Pembayaran - ' . $paket->nama)

@section('content')
    <div style="color: #6b7a70; font-size: .95rem; margin-bottom: 10px;">
        <a href="{{ route('dashboard') }}" style="color: #0c8a63; text-decoration: none;">Dashboard</a> &rsaquo;
        <a href="{{ route('pendaftaran.show', $paket->id) }}" style="color: #0c8a63; text-decoration: none;">Pendaftaran</a> &rsaquo;
        <strong>Pembayaran</strong>
    </div>
    <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 8px;">Pembayaran</h1>
    <p style="color: #5e6a60; margin-bottom: 26px;">Selesaikan pembayaran untuk mengamankan paket umrah Anda.</p>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 28px;">
        <div style="background: #0c8a63; color: #fff; border-radius: 14px; padding: 14px; text-align: center;">
            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.3); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 6px;"><i class="fa-solid fa-check"></i></div>
            <strong style="font-size: 0.85rem;">Pilih Paket</strong><br><small style="opacity: 0.9;">Selesai</small>
        </div>
        <div style="background: #0c8a63; color: #fff; border-radius: 14px; padding: 14px; text-align: center;">
            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.3); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 6px;"><i class="fa-solid fa-check"></i></div>
            <strong style="font-size: 0.85rem;">Data Diri</strong><br><small style="opacity: 0.9;">Selesai</small>
        </div>
        <div style="background: #fff; border: 2px solid #0c8a63; border-radius: 14px; padding: 14px; text-align: center;">
            <div style="width: 32px; height: 32px; background: #0c8a63; color: #fff; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 6px; font-weight: 700;">3</div>
            <strong style="font-size: 0.85rem;">Pembayaran</strong><br><small style="color: #7d8d83;">Sekarang</small>
        </div>
        <div style="background: #fff; border: 1px solid #e8eee9; border-radius: 14px; padding: 14px; text-align: center;">
            <div style="width: 32px; height: 32px; background: #f0f5f3; color: #9ca9a2; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 6px; font-weight: 700;">4</div>
            <strong style="font-size: 0.85rem;">Konfirmasi</strong><br><small style="color: #7d8d83;">Menunggu</small>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.05fr .95fr; gap: 24px;">
        <div style="background: #fff; border-radius: 20px; border: 1px solid #dbe6dc; padding: 28px;">
            <form method="POST" action="{{ route('pembayaran.confirm', $paket->id) }}" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div style="background: #fff8e1; border: 1px solid #f3e1a1; border-radius: 16px; padding: 16px 20px; display: flex; gap: 14px; align-items: flex-start; margin-bottom: 24px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fff1c7; color: #a47208; display: grid; place-items: center; flex-shrink: 0;"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div>
                        <h3 style="font-size: 0.95rem; font-weight: 700; margin: 0 0 4px;">Batas Waktu Pembayaran</h3>
                        <p style="color: #5f5b33; font-size: 0.85rem; margin: 0; line-height: 1.5;">Selesaikan pembayaran dalam 24 jam untuk menghindari pembatalan otomatis.</p>
                    </div>
                </div>

                <div style="background: #f6fff9; border: 1px solid #d4ead5; border-radius: 16px; padding: 20px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div>
                            <span style="background: #e9f8ed; color: #0c8a63; border-radius: 999px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700;">Ringkasan Pesanan</span>
                            <h2 style="font-size: 1.1rem; font-weight: 700; margin: 10px 0 0;">{{ $paket->nama }}</h2>
                        </div>
                        <span style="background: #e9f8ed; color: #0c8a63; border-radius: 999px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700;">{{ $paket->tipe_label }}</span>
                    </div>
                    <div style="display: grid; gap: 10px; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem;"><span><i class="fa-solid fa-calendar-days"></i> {{ $paket->tanggal_berangkat ?? 'Jadwal menyusul' }}</span><strong>{{ $paket->durasi_text }}</strong></div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem;"><span><i class="fa-solid fa-hotel"></i> {{ $paket->hotel ?? '-' }}</span><strong>{{ $paket->maskapai ?? '-' }}</strong></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px dashed #d4ead5; font-size: 0.9rem;"><span>Harga Paket</span><strong>Rp {{ number_format($paket->harga, 0, ',', '.') }}</strong></div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;"><span>Biaya Admin</span><strong style="color: #5e6d5f;">Rp {{ number_format($biayaAdmin, 0, ',', '.') }}</strong></div>
                    <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px dashed #d4ead5; margin-top: 8px;"><span style="font-weight: 700;">Total Pembayaran</span><strong style="font-size: 1.2rem; color: #0c8a63;">Rp {{ number_format($total, 0, ',', '.') }}</strong></div>
                </div>

                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 14px;">Metode Pembayaran</h3>
                    <div style="display: grid; gap: 12px;">
                        <label class="d-flex align-items-center gap-4 p-3" style="border: 2px solid #0c8a63; border-radius: 14px; background: #f2fbf5; cursor: pointer;">
                            <input type="radio" name="payment_method" value="Transfer Bank BNI" checked class="form-check-input d-none">
                            <div style="width: 64px; height: 64px; background: #fff; border-radius: 12px; display: grid; place-items: center; border: 1px solid #e8eee9; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <img src="{{ asset('images/bni-logo.jpg') }}" alt="BNI Logo" style="width: 54px; height: auto; object-fit: contain;">
                            </div>
                            <div>
                                <strong style="font-size: 1.1rem; color: #1b1b18;">Bank BNI</strong><br>
                                <strong style="font-size: 1.15rem; color: #0c8a63; letter-spacing: 1.5px;">1100150079</strong><br>
                                <span style="font-size: 0.85rem; color: #5f6a61;">a.n Khotimah Ahmad Tour dan Travel</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div style="background: #f8fbf7; border: 1px solid #dbe6dc; border-radius: 16px; padding: 18px; margin-bottom: 24px;">
                    <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 10px;">Upload Bukti Pembayaran</h3>
                    <p style="color: #5c7264; font-size: 0.85rem; margin-bottom: 12px;">Upload screenshot/foto bukti transfer (JPG, PNG, max 5MB).</p>
                    <input type="file" name="proof" class="form-control" accept="image/jpeg,image/png">
                </div>

                <div style="display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('pendaftaran.show', $paket->id) }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-success btn-lg px-4">Konfirmasi Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection
