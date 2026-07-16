@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')

@section('content')
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Kelola Pembayaran</h1>
        <p style="color: #7d8d83; margin: 4px 0 0;">Verifikasi bukti pembayaran jamaah</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pendapatan (Terverifikasi)</div>
                <div class="stat-value">Rp {{ number_format($totalVerified, 0, ',', '.') }}</div>
            </div>
            <div class="stat-icon icon-green"><i class="fas fa-money-check-dollar"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Menunggu Verifikasi</div>
                <div class="stat-value">{{ $totalPending }}</div>
            </div>
            <div class="stat-icon icon-yellow"><i class="fas fa-clock"></i></div>
        </div>
    </div>

    <div class="data-card">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form method="GET" action="{{ route('admin.pembayaran') }}" class="d-flex gap-2 flex-wrap" style="max-width: 700px; flex: 1;">
                <input type="text" name="q" class="form-control" placeholder="Cari nama jamaah..." value="{{ $search ?? '' }}" style="flex: 1; min-width: 200px;">
                <select name="status" class="form-select" style="max-width: 180px;">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ ($status ?? '') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="terverifikasi" {{ ($status ?? '') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="ditolak" {{ ($status ?? '') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" class="btn btn-sm-green"><i class="fas fa-search"></i> Cari</button>
                @if($search || $status)<a href="{{ route('admin.pembayaran') }}" class="btn btn-outline-secondary">Reset</a>@endif
            </form>
            <a href="{{ route('admin.pembayaran.export', array_filter(['q' => $search ?? '', 'status' => $status ?? ''])) }}" class="btn btn-sm-green" style="white-space: nowrap;">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead style="background: #f7fff8;">
                    <tr>
                        <th>Jamaah</th>
                        <th>Paket</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $p)
                        @php
                            $statusColor = match($p->status) {
                                'terverifikasi' => 'badge-soft-green',
                                'ditolak' => 'badge-soft-red',
                                default => 'badge-soft-yellow',
                            };
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $p->pendaftaran->jamaah->nama ?? '-' }}</strong><br>
                                <small style="color: #9ca9a2;">{{ $p->created_at->format('d M Y') }}</small>
                            </td>
                            <td>{{ $p->pendaftaran->paketUmrah->nama ?? '-' }}</td>
                            <td style="font-size: 0.85rem;">{{ $p->metode }}</td>
                            <td><strong style="color: #0c8a63;">Rp {{ number_format($p->total, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($p->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank" class="btn-sm-green"><i class="fas fa-image"></i> Lihat</a>
                                @else
                                    <span style="color: #9ca9a2; font-size: 0.8rem;">Tidak ada</span>
                                @endif
                            </td>
                            <td><span class="{{ $statusColor }}">{{ $p->status_label }}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('admin.pembayaran.invoice', $p->id) }}" target="_blank" class="dropdown-item"><i class="fas fa-file-pdf text-danger"></i> Cetak Invoice</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><form action="{{ route('admin.pembayaran.status', $p->id) }}" method="POST">@csrf<button type="submit" name="status" value="terverifikasi" class="dropdown-item text-success"><i class="fas fa-check"></i> Verifikasi</button></form></li>
                                        <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#tolakPembayaran-{{ $p->id }}"><i class="fas fa-times"></i> Tolak</button></li>
                                        <li><form action="{{ route('admin.pembayaran.status', $p->id) }}" method="POST">@csrf<button type="submit" name="status" value="menunggu" class="dropdown-item"><i class="fas fa-clock"></i> Kembalikan ke Menunggu</button></form></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Tolak Pembayaran -->
                        <div class="modal fade" id="tolakPembayaran-{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #ffe6e6;">
                                        <h5 class="modal-title" style="color: #d4483c;"><i class="fas fa-exclamation-triangle"></i> Tolak Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.pembayaran.status', $p->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p style="font-size: 0.9rem; color: #5c7264;">
                                                Anda akan menolak pembayaran dari <strong>{{ $p->pendaftaran->jamaah->nama ?? '-' }}</strong> sebesar <strong>Rp {{ number_format($p->total, 0, ',', '.') }}</strong>.
                                            </p>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold">Alasan Penolakan <span style="color: #d4483c;">*</span></label>
                                                <textarea name="alasan" rows="4" class="form-control" placeholder="Contoh: Bukti pembayaran tidak jelas / nominal tidak sesuai / bukti tidak valid. Pesan ini akan dikirim ke jamaah." required minlength="5" maxlength="500"></textarea>
                                                <small class="text-muted">Pesan ini akan ditampilkan kepada jamaah. Min 5 karakter.</small>
                                            </div>
                                            <input type="hidden" name="status" value="ditolak">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Tolak &amp; Kirim Pesan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="7" style="text-align: center; padding: 40px; color: #7d8d83;">Tidak ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $pembayarans->links() }}
        </div>
    </div>
@endsection
