@extends('layouts.admin')

@section('title', 'Daftar Jamaah')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Daftar Jamaah</h1>
        <p style="color: #7d8d83; margin: 4px 0 0;">Kelola seluruh data jamaah terdaftar</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total</div>
                <div class="stat-value">{{ number_format($totalJamaah) }}</div>
            </div>
            <div class="stat-icon icon-green"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Terverifikasi</div>
                <div class="stat-value">{{ $totalJamaah - $belumVerifikasi }}</div>
            </div>
            <div class="stat-icon icon-blue"><i class="fas fa-check"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Belum Verifikasi</div>
                <div class="stat-value">{{ $belumVerifikasi }}</div>
            </div>
            <div class="stat-icon icon-yellow"><i class="fas fa-clock"></i></div>
        </div>
    </div>

    <div class="data-card">
        <form method="GET" action="{{ route('admin.jamaah') }}" class="d-flex gap-2 mb-3" style="max-width: 400px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama, email, atau NIK..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-sm-green"><i class="fas fa-search"></i> Cari</button>
            @if($search)<a href="{{ route('admin.jamaah') }}" class="btn btn-outline-secondary">Reset</a>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background: #f7fff8;">
                    <tr>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>NIK</th>
                        <th>Dokumen</th>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jamaah as $item)
                        @php $paket = $item->pendaftarans->last()?->paketUmrah; @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Profil" style="width: 36px; height: 36px; border-radius: 10px; object-fit: cover;">
                                    @else
                                        <div style="width: 36px; height: 36px; border-radius: 10px; background: #dff7ec; color: #0c8a63; display: grid; place-items: center; font-weight: 700; font-size: 0.85rem;">{{ $item->inisial }}</div>
                                    @endif
                                    <div>
                                        <strong>{{ $item->nama }}</strong><br>
                                        <small style="color: #9ca9a2;">{{ $item->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;"><i class="fas fa-envelope text-muted"></i> {{ $item->email ?? '-' }}</div>
                                <div style="font-size: 0.85rem;"><i class="fas fa-phone text-muted"></i> {{ $item->telepon ?? '-' }}</div>
                            </td>
                            <td style="font-size: 0.85rem;">{{ $item->nik ?? '-' }}</td>
                            <td>
                                @if($item->dokumen_lengkap)
                                    <span class="badge-soft-green" title="Semua dokumen lengkap"><i class="fas fa-check-circle"></i> Lengkap (3/3)</span>
                                @elseif($item->jumlah_dokumen > 0)
                                    <span class="badge-soft-yellow" title="Dokumen belum lengkap"><i class="fas fa-circle-half-stroke"></i> {{ $item->jumlah_dokumen }}/3</span>
                                @else
                                    <span class="badge-soft-red" title="Belum ada dokumen"><i class="fas fa-times-circle"></i> Kosong</span>
                                @endif
                            </td>
                            <td>{{ $paket->nama ?? '-' }}</td>
                            <td>
                                @if($item->status_verifikasi === 'terverifikasi')
                                    <span class="badge-soft-green">Terverifikasi</span>
                                @elseif($item->status_verifikasi === 'ditolak')
                                    <span class="badge-soft-red">Ditolak</span>
                                @else
                                    <span class="badge-soft-yellow">Belum</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.jamaah.detail', $item->id) }}" class="btn-sm-green"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align: center; padding: 40px; color: #7d8d83;">Tidak ada data jamaah.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $jamaah->links() }}
        </div>
    </div>
@endsection
