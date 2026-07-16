@extends("layouts.jamaah", ["user" => $user])

@section("title", "Profil Saya")

@section("content")
<div class="container-fluid p-0">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Profil Saya</h1>
            <p style="color: #7d8d83; font-size: 0.9rem; margin: 4px 0 0;">Kelola data diri dan dokumen perjalanan ibadah Anda</p>
        </div>
        <div>
            @if($jamaah)
                @if($jamaah->status_verifikasi === 'terverifikasi')
                    <span class="badge bg-success px-3 py-2 rounded-pill" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.02em;">
                        <i class="fa-solid fa-circle-check me-1"></i> Terverifikasi
                    </span>
                @elseif($jamaah->status_verifikasi === 'ditolak')
                    <span class="badge bg-danger px-3 py-2 rounded-pill" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.02em;">
                        <i class="fa-solid fa-circle-xmark me-1"></i> Ditolak
                    </span>
                @else
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.02em;">
                        <i class="fa-solid fa-clock me-1"></i> Menunggu Verifikasi
                    </span>
                @endif
            @else
                <span class="badge bg-secondary px-3 py-2 rounded-pill" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.02em;">
                    Belum Lengkap
                </span>
            @endif
        </div>
    </div>

    @if($jamaah && $jamaah->status_verifikasi === 'ditolak')
        <div class="alert alert-danger d-flex align-items-center gap-3 mb-4 border-0 shadow-sm" style="border-radius: 12px; background-color: #fff2f2;">
            <div class="bg-danger text-white rounded-circle d-grid place-items-center" style="width: 40px; height: 40px; font-size: 1.2rem; flex-shrink: 0; display: grid; align-content: center; justify-content: center;">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <div>
                <strong class="d-block text-danger mb-1" style="font-size: 0.95rem;">Verifikasi Data Ditolak</strong>
                <span style="font-size: 0.85rem; color: #5c4848;">Silakan periksa kembali data diri dan dokumen yang diunggah. Lakukan perbaikan data di bawah ini lalu simpan kembali.</span>
            </div>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- Left Side: Profile Photo & Doc Status -->
            <div class="col-lg-4 col-md-5">
                <div class="card border-0 shadow-sm text-center p-4 mb-4" style="border-radius: 16px; background: #fff;">
                    <div class="position-relative d-inline-block mx-auto mb-3" style="width: 130px; height: 130px;">
                        @if($jamaah && $jamaah->foto)
                            <img src="{{ asset('storage/' . $jamaah->foto) }}" alt="Foto Profil" class="rounded-circle border border-3 border-success-subtle shadow-sm" style="width: 130px; height: 130px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-grid place-items-center font-weight-bold shadow-sm" style="width: 130px; height: 130px; font-size: 3rem; display: grid; align-content: center; justify-content: center; font-weight: 700; border: 3px solid #e8f5f0;">
                                {{ strtoupper(mb_substr(trim($user->name ?? 'J'), 0, 1)) }}
                            </div>
                        @endif
                        <label for="foto-upload" class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle shadow d-grid place-items-center" style="width: 38px; height: 38px; cursor: pointer; border: 3px solid #fff; transition: all 0.2s; display: grid; align-content: center; justify-content: center; margin: 0;">
                            <i class="fa-solid fa-camera" style="font-size: 0.9rem;"></i>
                            <input type="file" id="foto-upload" name="foto" class="d-none" accept="image/*" onchange="previewProfilePhoto(this)">
                        </label>
                    </div>
                    
                    <h5 class="fw-bold mb-1" style="font-size: 1.1rem; color: #1b1b18;">{{ $user->name }}</h5>
                    <p class="text-muted mb-3" style="font-size: 0.8rem;">{{ $user->email }}</p>
                    
                    <div class="text-start p-3 bg-light rounded-3" style="font-size: 0.8rem;">
                        <span class="text-muted d-block mb-2">Persentase Dokumen</span>
                        <div class="progress mb-2" style="height: 8px; border-radius: 4px;">
                            @php
                                $percent = $jamaah ? ($jamaah->jumlah_dokumen / 3) * 100 : 0;
                                $progressColor = $percent === 100 ? '#0c8a63' : ($percent >= 33 ? '#ffc107' : '#dc3545');
                            @endphp
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%; background-color: {{ $progressColor }};" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted fw-semibold">
                            <span>{{ $jamaah ? $jamaah->jumlah_dokumen : 0 }}/3 Dokumen Lengkap</span>
                            <span>{{ round($percent) }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Document Upload Box (KTP & Passport) -->
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: #fff;">
                    <h5 class="fw-bold mb-3" style="font-size: 1rem; color: #1b1b18;"><i class="fa-solid fa-folder-open text-success me-2"></i> Dokumen Pendukung</h5>
                    
                    <!-- KTP Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary mb-2" style="font-size: 0.85rem;">Foto KTP</label>
                        <div class="p-3 border rounded-3 bg-light text-center position-relative" style="border-style: dashed !important; border-color: #cbd5e1 !important;">
                            @if($jamaah && $jamaah->foto_ktp)
                                <div class="mb-2">
                                    <img id="preview-ktp" src="{{ asset('storage/' . $jamaah->foto_ktp) }}" alt="Preview KTP" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                </div>
                                <span class="d-block text-success fw-semibold mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-check"></i> KTP Terunggah</span>
                            @else
                                <div class="mb-2 text-muted" id="ktp-icon-container">
                                    <i class="fa-solid fa-address-card" style="font-size: 1.8rem; color: #94a3b8;"></i>
                                </div>
                                <span class="d-block text-muted mb-1" id="ktp-status-text" style="font-size: 0.75rem;">Belum ada KTP</span>
                            @endif
                            
                            <label for="file_photo" class="btn btn-outline-success btn-sm w-100 mt-2" style="font-size: 0.75rem; font-weight: 600; border-radius: 8px;">
                                Pilih Foto KTP
                                <input type="file" id="file_photo" name="foto_ktp" class="d-none" accept="image/*" onchange="previewDocument(this, 'preview-ktp', 'ktp-icon-container', 'ktp-status-text')">
                            </label>
                        </div>
                    </div>

                    <!-- Passport Upload -->
                    <div>
                        <label class="form-label fw-semibold text-secondary mb-2" style="font-size: 0.85rem;">Foto Paspor</label>
                        <div class="p-3 border rounded-3 bg-light text-center position-relative" style="border-style: dashed !important; border-color: #cbd5e1 !important;">
                            @if($jamaah && $jamaah->foto_paspor)
                                <div class="mb-2">
                                    <img id="preview-paspor" src="{{ asset('storage/' . $jamaah->foto_paspor) }}" alt="Preview Paspor" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                </div>
                                <span class="d-block text-success fw-semibold mb-1" style="font-size: 0.75rem;"><i class="fa-solid fa-circle-check"></i> Paspor Terunggah</span>
                            @else
                                <div class="mb-2 text-muted" id="paspor-icon-container">
                                    <i class="fa-solid fa-passport" style="font-size: 1.8rem; color: #94a3b8;"></i>
                                </div>
                                <span class="d-block text-muted mb-1" id="paspor-status-text" style="font-size: 0.75rem;">Belum ada Paspor</span>
                            @endif
                            
                            <label for="file_passport" class="btn btn-outline-success btn-sm w-100 mt-2" style="font-size: 0.75rem; font-weight: 600; border-radius: 8px;">
                                Pilih Foto Paspor
                                <input type="file" id="file_passport" name="foto_paspor" class="d-none" accept="image/*" onchange="previewDocument(this, 'preview-paspor', 'paspor-icon-container', 'paspor-status-text')">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Personal Data Form -->
            <div class="col-lg-8 col-md-7">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: #fff;">
                    <h5 class="fw-bold mb-4" style="font-size: 1.1rem; color: #1b1b18; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                        <i class="fa-solid fa-user-check text-success me-2"></i> Data Diri Jamaah
                    </h5>

                    <div class="row g-3">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Nama Lengkap (sesuai KTP)</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $jamaah->nama ?? $user->name) }}" required style="border-radius: 10px; font-size: 0.9rem;">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">No. NIK (KTP)</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $jamaah->nik ?? '') }}" placeholder="Masukkan 16 digit NIK" style="border-radius: 10px; font-size: 0.9rem;">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $jamaah->email ?? $user->email) }}" required style="border-radius: 10px; font-size: 0.9rem;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-6">
                            <label for="telepon" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $jamaah->telepon ?? $user->phone) }}" required style="border-radius: 10px; font-size: 0.9rem;">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $jamaah->tempat_lahir ?? '') }}" placeholder="Contoh: Jakarta" style="border-radius: 10px; font-size: 0.9rem;">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', ($jamaah && $jamaah->tanggal_lahir) ? $jamaah->tanggal_lahir->format('Y-m-d') : '') }}" style="border-radius: 10px; font-size: 0.9rem;">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" style="border-radius: 10px; font-size: 0.9rem;">
                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $jamaah->jenis_kelamin ?? '') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $jamaah->jenis_kelamin ?? '') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor Paspor -->
                        <div class="col-md-6">
                            <label for="pasport" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Nomor Paspor</label>
                            <input type="text" class="form-control @error('pasport') is-invalid @enderror" id="pasport" name="pasport" value="{{ old('pasport', $jamaah->pasport ?? '') }}" placeholder="Contoh: B123456" required style="border-radius: 10px; font-size: 0.9rem;">
                            @error('pasport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="col-12">
                            <label for="alamat" class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap tempat tinggal Anda" style="border-radius: 10px; font-size: 0.9rem;">{{ old('alamat', $jamaah->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success px-4 py-2 fw-semibold" style="border-radius: 10px; background-color: #0c8a63; border-color: #0c8a63; font-size: 0.9rem; transition: all 0.2s;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview foto profil sebelum di-submit
    function previewProfilePhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Cari img profil lama atau gantikan div initial
                const parent = input.closest('.position-relative');
                let img = parent.querySelector('img');
                
                if (!img) {
                    // Buat element img baru menggantikan div initial
                    const initialDiv = parent.querySelector('.rounded-circle');
                    initialDiv.style.display = 'none';
                    
                    img = document.createElement('img');
                    img.className = 'rounded-circle border border-3 border-success-subtle shadow-sm';
                    img.style.width = '130px';
                    img.style.height = '130px';
                    img.style.objectFit = 'cover';
                    parent.insertBefore(img, parent.firstChild);
                }
                
                img.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview KTP / Paspor sebelum di-submit
    function previewDocument(input, previewId, iconContainerId, statusTextId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const parent = input.closest('.p-3');
                let img = document.getElementById(previewId);
                
                // Sembunyikan icon container jika ada
                const iconContainer = document.getElementById(iconContainerId);
                if (iconContainer) {
                    iconContainer.style.display = 'none';
                }
                
                if (!img) {
                    // Buat preview image container jika belum ada
                    const mbDiv = document.createElement('div');
                    mbDiv.className = 'mb-2';
                    
                    img = document.createElement('img');
                    img.id = previewId;
                    img.className = 'img-fluid rounded';
                    img.style.maxHeight = '100px';
                    img.style.objectFit = 'cover';
                    mbDiv.appendChild(img);
                    
                    parent.insertBefore(mbDiv, parent.firstChild);
                }
                
                img.src = e.target.result;
                img.style.display = 'inline-block';
                
                // Ubah status text
                const statusText = document.getElementById(statusTextId);
                if (statusText) {
                    statusText.className = 'd-block text-success fw-semibold mb-1';
                    statusText.innerHTML = '<i class="fa-solid fa-circle-check"></i> Siap Diunggah';
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
