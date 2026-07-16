@extends("layouts.jamaah", ["user" => auth()->user()])

@section("title", "Pilih Paket Umrah")

@section("content")
<div class="container-fluid p-0">
    <div class="dashboard-header mb-4">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 4px;">Pilih Paket Umrah</h1>
        <p style="color: #7d8d83; font-size: 0.95rem; margin: 0;">Silakan pilih paket perjalanan umrah yang paling sesuai dengan kebutuhan ibadah Anda.</p>
    </div>

    <div class="row g-4">
        @if($pakets->count() > 0)
            @foreach($pakets as $paket)
                @php
                    $cardClass = $paket->tipe === "vip" ? "linear-gradient(135deg, #9370db, #8b5fbf)"
                        : ($paket->tipe === "plus" ? "linear-gradient(135deg, #d4a137, #b8860b)"
                        : "linear-gradient(135deg, #0c8a63, #087554)");
                    
                    $bgStyle = $paket->image
                        ? 'background-image: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.35)), url("' . asset('storage/' . $paket->image) . '"); background-size: cover; background-position: center;'
                        : 'background: ' . $cardClass . ';';
                @endphp
                <div class="col-xl-6 col-lg-12">
                    <div style="border-radius: 16px; padding: 24px; color: #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.1); min-height: 200px; display: flex; flex-direction: column; justify-content: space-between; {{ $bgStyle }}">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 16px;">
                                <div>
                                    <span class="badge mb-2" style="background: rgba(255,255,255,0.25); text-transform: uppercase; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.05em; padding: 4px 10px;">
                                        {{ $paket->tipe }}
                                    </span>
                                    <h5 style="margin: 0 0 4px; font-size: 1.2rem; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $paket->nama }}</h5>
                                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.9;">{{ $paket->durasi_text }}</p>
                                </div>
                                <div style="text-align: right;">
                                    <p style="margin: 0; font-size: 0.8rem; opacity: 0.9;">Mulai Dari</p>
                                    <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Rp {{ number_format($paket->harga / 1000000, 1, ",", ".") }} jt</h4>
                                </div>
                            </div>
                            
                            @if($paket->hotel || $paket->maskapai)
                                <div style="margin-top: 14px; font-size: 0.88rem; opacity: 0.95; display: flex; gap: 16px; flex-wrap: wrap;">
                                    @if($paket->hotel)
                                        <span><i class="fa-solid fa-hotel me-1"></i> Hotel: {{ $paket->hotel }}</span>
                                    @endif
                                    @if($paket->maskapai)
                                        <span><i class="fa-solid fa-plane me-1"></i> Penerbangan: {{ $paket->maskapai }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.15);">
                            <a href="{{ route('paket.detail', $paket->id) }}" style="background: #fff; color: #1b1b18; border-radius: 10px; padding: 10px 20px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; transition: all 0.2s; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                Detail &amp; Daftar <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            
                            @if($paket->kuota !== null)
                                @php
                                    $sisa = $paket->sisa_kuota;
                                    $badgeColor = $sisa <= 5 ? 'rgba(239, 68, 68, 0.9)' : 'rgba(255, 255, 255, 0.2)';
                                    $badgeTextColor = '#fff';
                                @endphp
                                <span style="background: {{ $badgeColor }}; color: {{ $badgeTextColor }}; padding: 6px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; backdrop-filter: blur(4px);">
                                    <i class="fa-solid fa-users me-1"></i> Sisa {{ $sisa }} Kursi
                                </span>
                            @else
                                <span style="background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); padding: 6px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; backdrop-filter: blur(4px);">
                                    <i class="fa-solid fa-infinity me-1"></i> Kuota Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div style="background: #fff; border-radius: 16px; padding: 48px; text-align: center; color: #7d8d83; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 16px; color: #cbd5e1;"></i>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Paket Aktif</h5>
                    <p style="margin: 0;">Maaf, saat ini belum ada paket umrah aktif yang ditawarkan.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
