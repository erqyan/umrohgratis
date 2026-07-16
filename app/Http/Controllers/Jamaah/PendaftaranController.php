<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\PaketUmrah;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan riwayat/status pendaftaran jamaah.
     */
    public function index()
    {
        $user = Auth::user();
        $jamaah = $user->jamaah;

        $riwayat = $jamaah
            ? $jamaah->pendaftarans()->with('paketUmrah', 'pembayaranTerakhir')->latest()->get()
            : collect();

        return view('riwayat-pendaftaran', [
            'user' => $user,
            'jamaah' => $jamaah,
            'riwayat' => $riwayat,
        ]);
    }

    /**
     * Tampilkan form pendaftaran untuk paket tertentu.
     */
    public function show($id)
    {
        $paket = PaketUmrah::where('status', 'aktif')->findOrFail($id);
        $user = Auth::user();
        $jamaah = $user->jamaah;

        // Cek apakah sudah ada pendaftaran draft/pending untuk paket ini.
        $pendaftaran = $jamaah
            ? $jamaah->pendaftarans()->where('paket_umrah_id', $paket->id)->latest()->first()
            : null;

        // Draft tersimpan di session (alur draft dari commit sebelumnya).
        $draft = session('pendaftaran_draft.' . $id, []);

        return view('pendaftaran', [
            'paket' => $paket,
            'draft' => $draft,
            'pendaftaran' => $pendaftaran,
            'jamaah' => $jamaah,
        ]);
    }

    /**
     * Simpan data pendaftaran sebagai draft (session).
     */
    public function draft(Request $request, $id)
    {
        $paket = PaketUmrah::where('status', 'aktif')->findOrFail($id);

        $draft = $request->only([
            'fullName',
            'nik',
            'birthPlace',
            'birthDate',
            'gender',
            'phone',
            'email',
            'passport',
            'address',
        ]);

        session(['pendaftaran_draft.' . $id => $draft]);

        return redirect()->route('pendaftaran.show', $paket->id)
            ->with('status', 'Draft pendaftaran berhasil disimpan. Anda dapat melanjutkan kapan saja.');
    }

    /**
     * Submit pendaftaran: simpan data jamaah + buat record pendaftaran.
     */
    public function submit(Request $request, $id)
    {
        $paket = PaketUmrah::where('status', 'aktif')->findOrFail($id);
        $user = Auth::user();

        // Cek kuota — tolak jika paket sudah penuh.
        if ($paket->kuota_penuh) {
            return redirect()->route('dashboard')
                ->with('error', 'Maaf, kuota paket "' . $paket->nama . '" sudah penuh.');
        }

        $validated = $request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:32'],
            'birthPlace' => ['required', 'string', 'max:100'],
            'birthDate' => ['required', 'date'],
            'gender' => ['required', 'in:L,P'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email'],
            'passport' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string'],
            'file_passport' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'file_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $jenisKelamin = $validated['gender'] === 'L' ? 'laki-laki' : 'perempuan';

        $dataJamaah = [
            'nama' => $validated['fullName'],
            'nik' => $validated['nik'],
            'tempat_lahir' => $validated['birthPlace'],
            'tanggal_lahir' => $validated['birthDate'],
            'jenis_kelamin' => $jenisKelamin,
            'telepon' => $validated['phone'],
            'email' => $validated['email'],
            'pasport' => $validated['passport'],
            'alamat' => $validated['address'],
            'status_verifikasi' => 'belum',
        ];

        // Upload dokumen (opsional).
        if ($request->hasFile('file_passport')) {
            $dataJamaah['foto_paspor'] = $request->file('file_passport')->store('dokumen', 'public');
        }
        if ($request->hasFile('file_photo')) {
            $dataJamaah['foto_ktp'] = $request->file('file_photo')->store('dokumen', 'public');
        }

        if ($user->jamaah) {
            $user->jamaah()->update($dataJamaah);
            $jamaah = $user->jamaah->fresh();
        } else {
            $dataJamaah['user_id'] = $user->id;
            $jamaah = Jamaah::create($dataJamaah);
        }

        // Buat record pendaftaran baru (status pending).
        Pendaftaran::create([
            'jamaah_id' => $jamaah->id,
            'paket_umrah_id' => $paket->id,
            'tanggal_pendaftaran' => now(),
            'status' => 'pending',
        ]);

        // Bersihkan draft.
        session()->forget('pendaftaran_draft.' . $id);

        return redirect()->route('pembayaran.show', $paket->id)
            ->with('status', 'Data pendaftaran berhasil dikirim. Lanjutkan ke pembayaran.');
    }
}
