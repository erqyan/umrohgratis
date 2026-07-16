@extends('layouts.admin')

@section('title', 'Detail Jamaah')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.jamaah') }}" style="color: #0c8a63; text-decoration: none; font-weight: 600;">&larr; Kembali ke Daftar Jamaah</a>
    </div>

    <div style="background: #fff; border-radius: 20px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
            @if($jamaah->foto)
                <img src="{{ asset('storage/' . $jamaah->foto) }}" alt="Profil" style="width: 64px; height: 64px; border-radius: 18px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            @else
                <div style="width: 64px; height: 64px; border-radius: 18px; background: #dff7ec; color: #0c8a63; display: grid; place-items: center; font-size: 1.5rem; font-weight: 700;">{{ $jamaah->inisial }}</div>
            @endif
            <div style="flex: 1;">
                <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ $jamaah->nama }}</h1>
                <p style="color: #7d8d83; margin: 4px 0 0;">{{ $jamaah->email ?? '-' }}</p>
            </div>
            <div>
                @if($jamaah->status_verifikasi === 'terverifikasi')
                    <span class="badge-soft-green" style="font-size: 0.9rem;"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                @elseif($jamaah->status_verifikasi === 'ditolak')
                    <span class="badge-soft-red" style="font-size: 0.9rem;"><i class="fas fa-times-circle"></i> Ditolak</span>
                @else
                    <span class="badge-soft-yellow" style="font-size: 0.9rem;"><i class="fas fa-clock"></i> Belum Verifikasi</span>
                @endif
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px;">Data Pribadi</h3>
                <form action="{{ route('admin.jamaah.update', $jamaah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $jamaah->nama) }}" required>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label fw-bold small">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $jamaah->email) }}"></div>
                        <div class="col-6"><label class="form-label fw-bold small">Telepon</label><input type="text" name="telepon" class="form-control" value="{{ old('telepon', $jamaah->telepon) }}"></div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label fw-bold small">NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik', $jamaah->nik) }}"></div>
                        <div class="col-6"><label class="form-label fw-bold small">Paspor</label><input type="text" name="pasport" class="form-control" value="{{ old('pasport', $jamaah->pasport) }}"></div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label fw-bold small">Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $jamaah->tempat_lahir) }}"></div>
                        <div class="col-6"><label class="form-label fw-bold small">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $jamaah->tanggal_lahir?->format('Y-m-d')) }}"></div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-bold small">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $jamaah->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $jamaah->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Alamat</label>
                        <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $jamaah->alamat) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-sm-green"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </form>
            </div>

            <div class="col-md-6">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px;">Verifikasi & Status</h3>
                <div style="background: #f7fff8; border-radius: 14px; padding: 16px; margin-bottom: 20px;">
                    <form action="{{ route('admin.jamaah.verify', $jamaah->id) }}" method="POST" style="display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap;">
                        @csrf
                        <div style="flex: 1; min-width: 180px;">
                            <label class="form-label fw-bold small">Ubah Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-select" id="verifyStatus-{{ $jamaah->id }}">
                                <option value="belum" {{ $jamaah->status_verifikasi === 'belum' ? 'selected' : '' }}>Belum Verifikasi</option>
                                <option value="terverifikasi" {{ $jamaah->status_verifikasi === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ $jamaah->status_verifikasi === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#tolakVerifikasi-{{ $jamaah->id }}" onclick="document.getElementById('verifyStatus-{{ $jamaah->id }}').value='ditolak'"><i class="fas fa-times text-danger"></i> Tolak</button>
                        <button type="submit" class="btn btn-sm-green"><i class="fas fa-check"></i> Update Status</button>
                    </form>
                </div>

                <!-- Modal Tolak Verifikasi -->
                <div class="modal fade" id="tolakVerifikasi-{{ $jamaah->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #ffe6e6;">
                                <h5 class="modal-title" style="color: #d4483c;"><i class="fas fa-exclamation-triangle"></i> Tolak Verifikasi Jamaah</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.jamaah.verify', $jamaah->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <p style="font-size: 0.9rem; color: #5c7264;">Anda akan menolak verifikasi <strong>{{ $jamaah->nama }}</strong>. Pesan ini akan dikirim ke jamaah.</p>
                                    <div class="mb-2">
                                        <label class="form-label fw-bold">Alasan Penolakan <span style="color: #d4483c;">*</span></label>
                                        <textarea name="alasan" rows="4" class="form-control" placeholder="Contoh: Dokumen tidak lengkap / NIK tidak valid / Foto paspor blur. Pesan ini akan dikirim ke jamaah." required minlength="5" maxlength="500"></textarea>
                                        <small class="text-muted">Min 5 karakter. Pesan ditampilkan ke jamaah.</small>
                                    </div>
                                    <input type="hidden" name="status_verifikasi" value="ditolak">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Tolak &amp; Kirim Pesan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px;">Dokumen Jamaah</h3>
                @php
                    $dokumenList = [
                        ['field' => 'foto_ktp', 'label' => 'KTP', 'icon' => 'fa-id-card'],
                        ['field' => 'foto_paspor', 'label' => 'Paspor', 'icon' => 'fa-passport'],
                        ['field' => 'foto', 'label' => 'Foto Diri', 'icon' => 'fa-user'],
                    ];
                    $jumlahDokumen = collect($dokumenList)->filter(fn ($d) => ! empty($jamaah->{$d['field']}))->count();
                @endphp
                <div style="background: #f7fff8; border-radius: 14px; padding: 16px; margin-bottom: 20px;">
                    @if($jumlahDokumen > 0)
                        <div style="font-size: 0.8rem; color: #7d8d83; margin-bottom: 12px;">
                            <i class="fas fa-paperclip"></i> {{ $jumlahDokumen }} dari {{ count($dokumenList) }} dokumen terunggah
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px;">
                            @foreach($dokumenList as $dok)
                                @php $path = $jamaah->{$dok['field']}; @endphp
                                @if(! empty($path))
                                    <div style="border: 1px solid #e2efe8; border-radius: 12px; overflow: hidden; background: #fff;">
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" title="Lihat {{ $dok['label'] }}">
                                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $dok['label'] }}" style="width: 100%; height: 110px; object-fit: cover; display: block;">
                                        </a>
                                        <div style="padding: 8px 10px; font-size: 0.78rem; display: flex; justify-content: space-between; align-items: center;">
                                            <span style="color: #4b6858;"><i class="fas {{ $dok['icon'] }}"></i> {{ $dok['label'] }}</span>
                                            <a href="{{ asset('storage/' . $path) }}" download title="Unduh {{ $dok['label'] }}" style="color: #0c8a63; text-decoration: none;"><i class="fas fa-download"></i></a>
                                        </div>
                                    </div>
                                @else
                                    <div style="border: 1px dashed #e2efe8; border-radius: 12px; padding: 16px; text-align: center; background: #fff; min-height: 110px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                        <i class="fas {{ $dok['icon'] }}" style="font-size: 1.4rem; color: #c5d3ca; margin-bottom: 6px;"></i>
                                        <span style="font-size: 0.78rem; color: #9ca9a2;">{{ $dok['label'] }}</span>
                                        <span style="font-size: 0.7rem; color: #b8c4bb;">belum ada</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 20px 0; color: #9ca9a2;">
                            <i class="fas fa-folder-open" style="font-size: 1.8rem; margin-bottom: 8px; opacity: 0.5;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">Jamaah belum mengunggah dokumen apapun.</p>
                        </div>
                    @endif
                </div>

                <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px;">Informasi Paket</h3>
                @if($paket)
                    <div style="background: #f7fff8; border: 1px solid #d7eedc; border-radius: 14px; padding: 16px; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <strong>{{ $paket->nama }}</strong>
                            <span class="badge-soft-green">{{ $paket->tipe_label }}</span>
                        </div>
                        <div style="color: #0c8a63; font-weight: 700; margin-bottom: 8px;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                        <div style="font-size: 0.85rem; color: #7d8d83;">
                            @if($paket->hotel)<div><i class="fas fa-hotel"></i> {{ $paket->hotel }}</div>@endif
                            @if($paket->maskapai)<div><i class="fas fa-plane"></i> {{ $paket->maskapai }}</div>@endif
                            @if($pendaftaran)<div><i class="fas fa-calendar"></i> Daftar: {{ $pendaftaran->tanggal_pendaftaran->format('d M Y') }}</div>@endif
                        </div>
                    </div>
                @else
                    <div style="background: #fff4e6; border-radius: 14px; padding: 16px; color: #b45309; text-align: center;">
                        <i class="fas fa-folder-open" style="font-size: 1.5rem; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">Jamaah belum memilih paket.</p>
                    </div>
                @endif

                @if($pembayaran)
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 20px 0 16px;">Status Pembayaran</h3>
                    <div style="background: #f7fff8; border-radius: 14px; padding: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span style="color: #7d8d83; font-size: 0.85rem;">Metode</span><strong style="font-size: 0.85rem;">{{ $pembayaran->metode }}</strong></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span style="color: #7d8d83; font-size: 0.85rem;">Total</span><strong style="font-size: 0.85rem;">Rp {{ number_format($pembayaran->total, 0, ',', '.') }}</strong></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;"><span style="color: #7d8d83; font-size: 0.85rem;">Status</span>
                            @if($pembayaran->status === 'terverifikasi')<span class="badge-soft-green">{{ $pembayaran->status_label }}</span>
                            @elseif($pembayaran->status === 'ditolak')<span class="badge-soft-red">{{ $pembayaran->status_label }}</span>
                            @else<span class="badge-soft-yellow">{{ $pembayaran->status_label }}</span>@endif
                        </div>
                        <a href="{{ route('admin.pembayaran') }}" class="btn btn-sm-green mt-2 w-100"><i class="fas fa-arrow-right"></i> Kelola Pembayaran</a>
                    </div>
                @endif
            </div>
        </div>

        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f0f4ef;">
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px;"><i class="fas fa-paper-plane text-success"></i> Riwayat Pesan ke Jamaah</h3>
            @if($riwayatNotifikasi->isNotEmpty())
                <div style="display: grid; gap: 10px;">
                    @foreach($riwayatNotifikasi as $notif)
                        <div style="background: {{ $notif->tipe === 'penolakan_verifikasi' || $notif->tipe === 'penolakan_pembayaran' ? '#fff5f5' : '#f7fff8' }}; border: 1px solid {{ $notif->tipe === 'penolakan_verifikasi' || $notif->tipe === 'penolakan_pembayaran' ? '#f5c2c2' : '#d7eedc' }}; border-left: 4px solid {{ $notif->tipe_warna }}; border-radius: 12px; padding: 14px 16px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 6px;">
                                <strong style="color: {{ $notif->tipe_warna }}; font-size: 0.88rem;"><i class="fas {{ $notif->dibaca ? 'fa-envelope-open' : 'fa-envelope' }}"></i> {{ $notif->judul }}</strong>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    @if(! $notif->dibaca)<span class="badge-soft-yellow" style="font-size: 0.68rem;">Belum dibaca</span>@else<span class="badge-soft-green" style="font-size: 0.68rem;">Dibaca</span>@endif
                                    <small style="color: #9ca9a2; font-size: 0.72rem;">{{ $notif->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                            <p style="margin: 0; color: #4b4040; font-size: 0.85rem; line-height: 1.5;">{{ $notif->pesan }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 24px; color: #9ca9a2; background: #fafafa; border-radius: 12px;">
                    <i class="fas fa-inbox" style="font-size: 1.6rem; margin-bottom: 8px; opacity: 0.5;"></i>
                    <p style="margin: 0; font-size: 0.88rem;">Belum ada pesan/notifikasi yang dikirim ke jamaah ini.</p>
                </div>
            @endif
        </div>

        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f0f4ef;">
            <form action="{{ route('admin.jamaah.destroy', $jamaah->id) }}" method="POST" onsubmit="return confirm('Hapus jamaah {{ $jamaah->nama }}? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i> Hapus Jamaah</button>
            </form>
        </div>
    </div>
@endsection
