@extends('layouts.jamaah', ['user' => auth()->user()])

@section('title', 'Detail Paket - ' . $paket->nama)

@section('content')
    <div style="color: #6b7a70; font-size: .95rem; margin-bottom: 16px;">
        <a href="{{ route('dashboard') }}" style="color: #0c8a63; text-decoration: none;">Dashboard</a> &rsaquo;
        <strong>{{ $paket->nama }}</strong>
    </div>

    @if($paket->image)
    <div style="border-radius: 20px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); position: relative;">
        <img src="{{ asset('storage/' . $paket->image) }}" alt="{{ $paket->nama }}" style="width: 100%; height: 280px; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0) 100%);"></div>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 24px; color: #fff;">
            <span style="background: rgba(12,138,99,0.95); padding: 4px 12px; border-radius: 999px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;">{{ $paket->tipe_label }}</span>
            <h1 style="font-size: 1.75rem; font-weight: 700; margin: 8px 0 4px;">{{ $paket->nama }}</h1>
            <p style="font-size: 1.2rem; opacity: 0.95; margin: 0;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
            <p style="opacity: 0.9; margin: 2px 0 0;"><i class="fa-solid fa-clock"></i> {{ $paket->durasi_text }}</p>
        </div>
    </div>
    @else
    <div style="background: linear-gradient(135deg, #0c8a63, #087554); border-radius: 20px; padding: 40px; color: #fff; text-align: center; margin-bottom: 24px;">
        <i class="fa-solid fa-mosque" style="font-size: 3rem; margin-bottom: 12px;"></i>
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 8px;">{{ $paket->nama }}</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
        <p style="opacity: 0.85;">{{ $paket->durasi_text }}</p>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div style="color: #7d8d83; font-size: 0.8rem; margin-bottom: 6px;"><i class="fa-solid fa-calendar"></i> Tanggal Berangkat</div>
            <div style="font-weight: 700;">{{ $paket->tanggal_berangkat ?? 'Jadwal menyusul' }}</div>
        </div>
        <div style="background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div style="color: #7d8d83; font-size: 0.8rem; margin-bottom: 6px;"><i class="fa-solid fa-location-dot"></i> Keberangkatan</div>
            <div style="font-weight: 700;">{{ $paket->lokasi_keberangkatan ?? 'Jakarta' }}</div>
        </div>
        <div style="background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div style="color: #7d8d83; font-size: 0.8rem; margin-bottom: 6px;"><i class="fa-solid fa-hotel"></i> Hotel</div>
            <div style="font-weight: 700;">{{ $paket->hotel ?? '-' }}</div>
        </div>
        <div style="background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div style="color: #7d8d83; font-size: 0.8rem; margin-bottom: 6px;"><i class="fa-solid fa-plane"></i> Maskapai</div>
            <div style="font-weight: 700;">{{ $paket->maskapai ?? '-' }}</div>
        </div>
    </div>

    @php
        $kuotaPenuh = $paket->kuota_penuh;
        $sisaKuota = $paket->sisa_kuota;
        $terpakai = $paket->kuota_terpakai;
        $kuotaTotal = $paket->kuota;
        if ($kuotaTotal === null) {
            $badgeTeks = 'Tidak Terbatas';
            $badgeBg = '#6c757d';
            $badgeFg = '#fff';
        } elseif ($kuotaPenuh) {
            $badgeTeks = 'Penuh';
            $badgeBg = '#dc3545';
            $badgeFg = '#fff';
        } elseif ($sisaKuota <= 5) {
            $badgeTeks = 'Hampir Penuh';
            $badgeBg = '#ffc107';
            $badgeFg = '#5a4500';
        } else {
            $badgeTeks = 'Tersedia';
            $badgeBg = '#0c8a63';
            $badgeFg = '#fff';
        }
        $persen = $kuotaTotal !== null ? min(100, round(($terpakai / $kuotaTotal) * 100)) : 0;
    @endphp

    <div style="background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0;"><i class="fa-solid fa-users" style="color: #0c8a63;"></i> Status Kuota Paket</h3>
            <span style="background: {{ $badgeBg }}; color: {{ $badgeFg }}; padding: 5px 14px; border-radius: 999px; font-size: 0.78rem; font-weight: 700;">{{ $badgeTeks }}</span>
        </div>
        @if($kuotaTotal !== null)
            <div style="font-size: 1rem; font-weight: 600; color: #1b1b18; margin-bottom: 8px;">
                Sisa <span style="color: {{ $kuotaPenuh ? '#dc3545' : '#0c8a63' }}; font-size: 1.2rem;">{{ $sisaKuota }}</span> kursi dari {{ $kuotaTotal }}
            </div>
            <div style="height: 10px; background: #e8f5f0; border-radius: 999px; overflow: hidden;">
                <div style="height: 100%; width: {{ $persen }}%; background: {{ $kuotaPenuh ? '#dc3545' : ($sisaKuota <= 5 ? '#ffc107' : '#0c8a63') }}; border-radius: 999px; transition: width .3s;"></div>
            </div>
            <div style="font-size: 0.8rem; color: #7d8d83; margin-top: 6px;">
                Terisi {{ $terpakai }} kursi ({{ $persen }}%)
            </div>
        @else
            <div style="font-size: 1rem; font-weight: 600; color: #1b1b18; margin-bottom: 8px;">
                Kuota <span style="color: #6c757d;">Tidak Terbatas</span>
            </div>
            <div style="font-size: 0.8rem; color: #7d8d83;">
                Saat ini terisi {{ $terpakai }} pendaftaran aktif.
            </div>
        @endif
    </div>

    @if(!empty($paket->deskripsi))
    <div style="background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px;">Deskripsi Paket</h3>
        <p style="color: #4b6858; line-height: 1.7; margin: 0;">{{ $paket->deskripsi }}</p>
    </div>
    @endif

    @if(!empty($paket->fasilitas))
    <div style="background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Fasilitas</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
            @foreach($paket->fasilitas as $fasilitas)
            <div style="display: flex; align-items: center; gap: 10px; color: #4b6858;">
                <i class="fa-solid fa-check" style="color: #0c8a63;"></i> {{ $fasilitas }}
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($paket->itinerary))
    <div style="background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Itinerary Perjalanan</h3>
        @foreach($paket->itinerary as $item)
        <div style="display: flex; gap: 16px; padding-bottom: 16px; margin-bottom: 16px; border-bottom: 1px solid #f0f4ef;">
            <div style="width: 60px; height: 50px; background: #e8f5f0; border-radius: 12px; display: grid; place-items: center; color: #0c8a63; font-weight: 700; font-size: 0.75rem; flex-shrink: 0; text-align: center; padding: 4px;">
                {{ $item['day'] }}
            </div>
            <div>
                <h5 style="margin: 0 0 4px; font-size: 0.95rem; font-weight: 600;">{{ $item['title'] }}</h5>
                <p style="margin: 0; font-size: 0.85rem; color: #7d8d83;">{{ $item['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($pakets->where('id', '!=', $paket->id)->count() > 0)
    <div style="background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px;">Paket Lainnya</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
            @foreach($pakets->where('id', '!=', $paket->id) as $p)
            <a href="{{ route('paket.detail', $p->id) }}" style="display: block; padding: 14px; border: 1px solid #e8eee9; border-radius: 12px; text-decoration: none; color: #1b1b18; transition: all .2s;">
                <strong>{{ $p->nama }}</strong>
                <div style="color: #0c8a63; font-size: 0.85rem; margin-top: 4px;">Rp {{ number_format($p->harga / 1000000, 1, ',', '.') }} jt</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div style="position: sticky; bottom: 0; background: #f5f5f5; padding: 16px 0;">
        @if($kuotaPenuh)
            <div style="display: block; background: #ccc; color: #666; text-align: center; border-radius: 12px; padding: 16px; font-weight: 700; font-size: 1.05rem; cursor: not-allowed;">
                <i class="fa-solid fa-ban"></i> Kuota Penuh
            </div>
        @else
            <a href="{{ route('pendaftaran.show', $paket->id) }}" style="display: block; background: #0c8a63; color: #fff; text-align: center; border-radius: 12px; padding: 16px; font-weight: 700; font-size: 1.05rem; text-decoration: none; transition: background .2s;">
                <i class="fa-solid fa-edit"></i> Daftar Paket Ini
            </a>
        @endif
    </div>
@endsection
