@extends('layouts.admin')

@section('title', 'Daftar Pendaftaran')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Daftar Pendaftaran</h1>
        <p style="color: #7d8d83; margin: 4px 0 0;">Kelola seluruh pendaftaran paket umrah</p>
    </div>

    <div class="data-card">
        <form method="GET" action="{{ route('admin.pendaftaran') }}" class="d-flex gap-2 mb-3 flex-wrap" style="max-width: 700px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama jamaah..." value="{{ $search ?? '' }}" style="flex: 1; min-width: 200px;">
            <select name="status" class="form-select" style="max-width: 160px;">
                <option value="">Semua Status</option>
                <option value="draft" {{ ($status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="aktif" {{ ($status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ ($status ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ ($status ?? '') === 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
            <button type="submit" class="btn btn-sm-green"><i class="fas fa-search"></i> Cari</button>
            @if($search || $status)<a href="{{ route('admin.pendaftaran') }}" class="btn btn-outline-secondary">Reset</a>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background: #f7fff8;">
                    <tr>
                        <th>Jamaah</th>
                        <th>Paket</th>
                        <th>Tgl Pendaftaran</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $p)
                        @php
                            $pembayaran = $p->pembayaranTerakhir;
                            $statusColor = match($p->status) {
                                'aktif' => 'badge-soft-green',
                                'selesai' => 'badge-soft-green',
                                'batal' => 'badge-soft-red',
                                'draft' => 'badge-soft-yellow',
                                default => 'badge-soft-yellow',
                            };
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $p->jamaah->nama ?? '-' }}</strong><br>
                                <small style="color: #9ca9a2;">{{ $p->jamaah->email ?? '-' }}</small>
                            </td>
                            <td>{{ $p->paketUmrah->nama ?? '-' }}</td>
                            <td style="font-size: 0.85rem;">{{ $p->tanggal_pendaftaran->format('d M Y') }}</td>
                            <td>
                                @if($pembayaran)
                                    <span style="font-size: 0.8rem;">Rp {{ number_format($pembayaran->total, 0, ',', '.') }}</span><br>
                                    @if($pembayaran->status === 'terverifikasi')<span class="badge-soft-green" style="font-size: 0.7rem;">{{ $pembayaran->status_label }}</span>
                                    @elseif($pembayaran->status === 'ditolak')<span class="badge-soft-red" style="font-size: 0.7rem;">{{ $pembayaran->status_label }}</span>
                                    @else<span class="badge-soft-yellow" style="font-size: 0.7rem;">{{ $pembayaran->status_label }}</span>@endif
                                @else
                                    <span style="color: #9ca9a2; font-size: 0.8rem;">Belum ada</span>
                                @endif
                            </td>
                            <td><span class="{{ $statusColor }}">{{ $p->status_label }}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Ubah Status</button>
                                    <ul class="dropdown-menu">
                                        <li><form action="{{ route('admin.pendaftaran.status', $p->id) }}" method="POST">@csrf<button type="submit" name="status" value="pending" class="dropdown-item">Pending</button></form></li>
                                        <li><form action="{{ route('admin.pendaftaran.status', $p->id) }}" method="POST">@csrf<button type="submit" name="status" value="aktif" class="dropdown-item">Aktif</button></form></li>
                                        <li><form action="{{ route('admin.pendaftaran.status', $p->id) }}" method="POST">@csrf<button type="submit" name="status" value="selesai" class="dropdown-item">Selesai</button></form></li>
                                        <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#batalPendaftaran-{{ $p->id }}"><i class="fas fa-times"></i> Batal</button></li>
                                    </ul>
                                </div>
                                @if($p->jamaah)<a href="{{ route('admin.jamaah.detail', $p->jamaah->id) }}" class="btn-sm-green mt-1"><i class="fas fa-eye"></i></a>@endif
                            </td>
                        </tr>

                        <!-- Modal Batalkan Pendaftaran -->
                        <div class="modal fade" id="batalPendaftaran-{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #ffe6e6;">
                                        <h5 class="modal-title" style="color: #d4483c;"><i class="fas fa-exclamation-triangle"></i> Batalkan Pendaftaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.pendaftaran.status', $p->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p style="font-size: 0.9rem; color: #5c7264;">Anda akan membatalkan pendaftaran <strong>{{ $p->jamaah->nama ?? '-' }}</strong> untuk paket <strong>{{ $p->paketUmrah->nama ?? '-' }}</strong>.</p>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold">Alasan Pembatalan <span style="color: #d4483c;">*</span></label>
                                                <textarea name="alasan" rows="4" class="form-control" placeholder="Contoh: Kuota penuh / Dokumen tidak valid / Minta per data diri. Pesan ini akan dikirim ke jamaah." required minlength="5" maxlength="500"></textarea>
                                                <small class="text-muted">Pesan ini akan ditampilkan kepada jamaah. Min 5 karakter.</small>
                                            </div>
                                            <input type="hidden" name="status" value="batal">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Batalkan &amp; Kirim Pesan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="6" style="text-align: center; padding: 40px; color: #7d8d83;">Tidak ada data pendaftaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $pendaftarans->links() }}
        </div>
    </div>
@endsection
