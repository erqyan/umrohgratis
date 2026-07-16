@extends("layouts.jamaah", ["user" => $user])

@section("title", "Status Pendaftaran")

@section("content")
<div class="container-fluid p-0">
    <div class="dashboard-header mb-4">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 4px;">Status Pendaftaran</h1>
        <p style="color: #7d8d83; font-size: 0.95rem; margin: 0;">Pantau status pendaftaran paket umrah dan riwayat transaksi pembayaran Anda.</p>
    </div>

    <div class="row">
        <div class="col-12">
            @if($riwayat->count() > 0)
                <div class="d-flex flex-column gap-4">
                    @foreach($riwayat as $item)
                        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: #fff;">
                            <!-- Header Card: Paket Info and Status -->
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3 pb-3" style="border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <span class="badge mb-2" style="background: #e8f5f0; color: #0c8a63; text-transform: uppercase; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 6px;">
                                        {{ $item->paketUmrah->tipe ?? 'Regular' }}
                                    </span>
                                    <h4 class="fw-bold mb-1" style="font-size: 1.15rem; color: #1b1b18;">
                                        {{ $item->paketUmrah->nama ?? "Paket Tidak Ditemukan" }}
                                    </h4>
                                    <p class="text-muted mb-0" style="font-size: 0.8rem;">
                                        Tanggal Daftar: {{ $item->tanggal_pendaftaran->format("d M Y") }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">Status Pendaftaran</span>
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-secondary',
                                            'pending' => 'bg-warning text-dark',
                                            'aktif' => 'bg-success',
                                            'selesai' => 'bg-info text-white',
                                            'batal' => 'bg-danger'
                                        ];
                                        $colorClass = $statusColors[$item->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $colorClass }} px-3 py-2 rounded-pill fw-semibold" style="font-size: 0.8rem;">
                                        {{ $item->status_label }}
                                    </span>
                                </div>
                            </div>

                            <!-- Body Card: Details & Payment Status -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-secondary mb-2" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Detail Perjalanan</h6>
                                    <div class="d-flex flex-column gap-2" style="font-size: 0.85rem;">
                                        <div>
                                            <i class="fa-solid fa-clock text-muted me-2" style="width: 16px;"></i>
                                            <span class="text-muted">Durasi:</span> {{ $item->paketUmrah->durasi_text ?? '-' }}
                                        </div>
                                        @if($item->paketUmrah && $item->paketUmrah->hotel)
                                            <div>
                                                <i class="fa-solid fa-hotel text-muted me-2" style="width: 16px;"></i>
                                                <span class="text-muted">Hotel:</span> {{ $item->paketUmrah->hotel }}
                                            </div>
                                        @endif
                                        @if($item->paketUmrah && $item->paketUmrah->maskapai)
                                            <div>
                                                <i class="fa-solid fa-plane text-muted me-2" style="width: 16px;"></i>
                                                <span class="text-muted">Maskapai:</span> {{ $item->paketUmrah->maskapai }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="fw-bold text-secondary mb-2" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Informasi Pembayaran</h6>
                                    
                                    @if($item->pembayaranTerakhir)
                                        <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.85rem;">
                                                <span class="text-muted">Total Pembayaran:</span>
                                                <strong class="text-dark">Rp {{ number_format($item->pembayaranTerakhir->total, 0, ",", ".") }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center" style="font-size: 0.85rem;">
                                                <span class="text-muted">Status Pembayaran:</span>
                                                @php
                                                    $paymentColors = [
                                                        'menunggu' => 'text-warning',
                                                        'terverifikasi' => 'text-success',
                                                        'ditolak' => 'text-danger'
                                                    ];
                                                    $payColor = $paymentColors[$item->pembayaranTerakhir->status] ?? 'text-muted';
                                                @endphp
                                                <strong class="{{ $payColor }}">
                                                    <i class="fa-solid fa-circle me-1" style="font-size: 0.5rem; vertical-align: middle;"></i>
                                                    {{ $item->pembayaranTerakhir->status_label }}
                                                </strong>
                                            </div>

                                            @if($item->pembayaranTerakhir->status === 'terverifikasi')
                                                <div class="mt-3 pt-3 border-top d-flex justify-content-end">
                                                    <a href="{{ route('pembayaran.invoice', [$item->paket_umrah_id, $item->pembayaranTerakhir->id]) }}" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center gap-2 fw-semibold" style="border-radius: 8px; font-size: 0.8rem;">
                                                        <i class="fa-solid fa-file-pdf"></i> Cetak Invoice
                                                    </a>
                                                </div>
                                            @elseif($item->pembayaranTerakhir->status === 'ditolak')
                                                <div class="mt-3 pt-3 border-top">
                                                    <p class="text-danger mb-2" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-info"></i> Bukti pembayaran Anda ditolak admin. Silakan upload ulang bukti pembayaran yang sah.</p>
                                                    <a href="{{ route('pembayaran.show', $item->paket_umrah_id) }}" class="btn btn-danger btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-2 fw-semibold" style="border-radius: 8px; font-size: 0.8rem;">
                                                        <i class="fa-solid fa-upload"></i> Upload Bukti Baru
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="p-3 rounded-3 text-center" style="background: #fffbeb; border: 1px dashed #fcd34d;">
                                            <p class="text-warning-emphasis mb-2" style="font-size: 0.8rem; font-weight: 500;">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> Belum melakukan pembayaran
                                            </p>
                                            <a href="{{ route('pembayaran.show', $item->paket_umrah_id) }}" class="btn btn-warning btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-2 fw-semibold text-dark" style="border-radius: 8px; font-size: 0.8rem; background-color: #fbbf24; border-color: #fbbf24;">
                                                <i class="fa-solid fa-credit-card"></i> Bayar Sekarang
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background: #fff; border-radius: 16px; padding: 48px; text-align: center; color: #7d8d83; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 16px; color: #cbd5e1;"></i>
                    <h5 class="fw-bold text-dark mb-1">Tidak Ada Riwayat Pendaftaran</h5>
                    <p class="mb-3" style="margin: 0;">Anda belum pernah mendaftar untuk paket umrah apa pun.</p>
                    <a href="{{ route('paket.index') }}" class="btn btn-success fw-semibold px-4 py-2" style="border-radius: 10px; background-color: #0c8a63; border-color: #0c8a63; font-size: 0.88rem;">
                        Pilih Paket Sekarang <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
