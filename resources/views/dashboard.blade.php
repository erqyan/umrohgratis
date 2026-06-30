@extends("layouts.jamaah", ["user" => $user])

@section("title", "Dashboard Jamaah")

@section("content")
    <div class="dashboard-header" style="margin-bottom: 20px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 4px;">Dashboard</h1>
        <p style="color: #7d8d83; font-size: 0.95rem;">Selamat datang kembali, {{ $user->name }}</p>
    </div>

    <div style="background: #fff; border-radius: 16px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; gap: 16px; align-items: flex-start;">
        <div style="width: 50px; height: 50px; background: #e8f5f0; border-radius: 12px; display: grid; place-items: center; color: #0c8a63; font-size: 1.5rem; flex-shrink: 0;">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div style="flex: 1;">
            <p style="color: #7d8d83; font-size: 0.8rem; margin: 0 0 4px;">Paket Aktif</p>
            @if($pendaftaranAktif && $pendaftaranAktif->paketUmrah)
                <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0 0 4px;">{{ $pendaftaranAktif->paketUmrah->nama }}</h3>
                <p style="color: #7d8d83; font-size: 0.85rem; margin: 0;">{{ $pendaftaranAktif->paketUmrah->durasi_text }} &middot; Status: {{ $pendaftaranAktif->status_label }}</p>
                @if($pendaftaranAktif->pembayaranTerakhir)
                    <a href="{{ route('pembayaran.invoice', [$pendaftaranAktif->paket_umrah_id, $pendaftaranAktif->pembayaranTerakhir->id]) }}" target="_blank" style="margin-top: 10px; display: inline-flex; align-items: center; gap: 6px; background: #0c8a63; color: #fff; border-radius: 8px; padding: 7px 14px; font-weight: 600; text-decoration: none; font-size: 0.8rem;">
                        <i class="fa-solid fa-file-pdf"></i> Cetak Invoice Pembayaran
                    </a>
                @endif
            @else
                <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0 0 4px;">Belum Ada Paket</h3>
                <p style="color: #7d8d83; font-size: 0.85rem; margin: 0;">Silakan pilih paket umrah di bawah ini.</p>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <p style="color: #7d8d83; font-size: 0.8rem; margin: 0 0 8px;">Status Pembayaran</p>
            @if($pendaftaranAktif && $pendaftaranAktif->pembayaranTerakhir)
                <h4 style="margin: 0 0 8px; font-size: 1rem; font-weight: 700; color: {{ $pendaftaranAktif->pembayaranTerakhir->status === "terverifikasi" ? "#0c8a63" : "#f59e0b" }};">
                    {{ $pendaftaranAktif->pembayaranTerakhir->status_label }}
                </h4>
                <p style="color: #7d8d83; font-size: 0.75rem; margin: 0;">Rp {{ number_format($pendaftaranAktif->pembayaranTerakhir->total, 0, ",", ".") }}</p>
            @else
                <h4 style="margin: 0 0 8px; font-size: 1rem; font-weight: 700; color: #6b7280;">Menunggu</h4>
                <p style="color: #7d8d83; font-size: 0.75rem; margin: 0;">Belum ada pembayaran</p>
            @endif
        </div>
        <div style="background: #fff; border-radius: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <p style="color: #7d8d83; font-size: 0.8rem; margin: 0 0 8px;">Status Verifikasi</p>
            @if($jamaah)
                <h4 style="margin: 0 0 8px; font-size: 1rem; font-weight: 700; color: {{ $jamaah->status_verifikasi === "terverifikasi" ? "#0c8a63" : "#f59e0b" }};">
                    {{ $jamaah->status_verifikasi === "terverifikasi" ? "Terverifikasi" : "Belum Diverifikasi" }}
                </h4>
                <p style="color: #7d8d83; font-size: 0.75rem; margin: 0;">{{ $jamaah->status_verifikasi === "terverifikasi" ? "Akun aktif" : "Menunggu verifikasi admin" }}</p>
            @else
                <h4 style="margin: 0 0 8px; font-size: 1rem; font-weight: 700; color: #6b7280;">Belum Lengkap</h4>
                <p style="color: #7d8d83; font-size: 0.75rem; margin: 0;">Lengkapi data diri</p>
            @endif
        </div>
    </div>

    <div id="paket" style="margin-bottom: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Pilih Paket Umrah</h3>
        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
            @foreach($pakets as $paket)
                @php
                    $cardClass = $paket->tipe === "vip" ? "linear-gradient(135deg, #9370db, #8b5fbf)"
                        : ($paket->tipe === "plus" ? "linear-gradient(135deg, #d4a137, #b8860b)"
                        : "linear-gradient(135deg, #0c8a63, #087554)");
                @endphp
                <div style="border-radius: 16px; padding: 20px; color: #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.1); background: {{ $cardClass }};">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 16px;">
                        <div>
                            <h5 style="margin: 0 0 4px; font-size: 1.05rem; font-weight: 700;">{{ $paket->nama }}</h5>
                            <p style="margin: 0; font-size: 0.8rem; opacity: 0.9;">{{ $paket->durasi_text }}</p>
                        </div>
                        <div style="text-align: right;">
                            <p style="margin: 0; font-size: 0.75rem; opacity: 0.9;">Rp</p>
                            <h4 style="margin: 0; font-size: 1.25rem; font-weight: 700;">{{ number_format($paket->harga / 1000000, 1, ",", ".") }} jt</h4>
                        </div>
                    </div>
                    @if($paket->hotel || $paket->maskapai)
                        <p style="margin: 0 0 12px; font-size: 0.85rem; opacity: 0.95;">
                            <i class="fa-solid fa-hotel"></i> {{ $paket->hotel ?? "-" }}
                            &middot; <i class="fa-solid fa-plane"></i> {{ $paket->maskapai ?? "-" }}
                        </p>
                    @endif
                    <a href="{{ route("paket.detail", $paket->id) }}" style="background: rgba(255,255,255,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.5); border-radius: 10px; padding: 8px 16px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                        <i class="fa-solid fa-arrow-right"></i> Lihat Paket
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div id="riwayat">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Riwayat Pendaftaran</h3>
        @if($riwayat->count() > 0)
            <div style="display: grid; gap: 12px;">
                @foreach($riwayat as $item)
                    <div style="background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                            <div>
                                <strong style="display: block; color: #1b1b18;">{{ $item->paketUmrah->nama ?? "Paket Dihapus" }}</strong>
                                <small style="color: #7d8d83;">{{ $item->tanggal_pendaftaran->format("d M Y") }}</small>
                            </div>
                            <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; background: {{ $item->status === "aktif" ? "#e8f5f0" : "#fff4e6" }}; color: {{ $item->status === "aktif" ? "#0c8a63" : "#b45309" }};">
                                {{ $item->status_label }}
                            </span>
                        </div>
                        @if($item->pembayaranTerakhir)
                            <div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed #e8eee9; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
                                <div>
                                    <small style="color: #7d8d83; display: block; margin-bottom: 2px;">Pembayaran: Rp {{ number_format($item->pembayaranTerakhir->total, 0, ",", ".") }}</small>
                                    <small style="color: {{ $item->pembayaranTerakhir->status === "terverifikasi" ? "#0c8a63" : "#b45309" }}; font-weight: 600;">
                                        {{ $item->pembayaranTerakhir->status_label }}
                                    </small>
                                </div>
                                <a href="{{ route('pembayaran.invoice', [$item->paket_umrah_id, $item->pembayaranTerakhir->id]) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: #fff; color: #0c8a63; border: 1px solid #0c8a63; border-radius: 8px; padding: 6px 12px; font-weight: 600; text-decoration: none; font-size: 0.78rem;">
                                    <i class="fa-solid fa-file-pdf"></i> Cetak Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: #fff; border-radius: 12px; padding: 32px; text-align: center; color: #7d8d83; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 12px; opacity: 0.5;"></i>
                <p style="margin: 0;">Belum ada riwayat pendaftaran.</p>
            </div>
        @endif
    </div>
@endsection