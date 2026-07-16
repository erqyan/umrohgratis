<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil jamaah.
     */
    public function show()
    {
        $user = Auth::user();
        $jamaah = $user->jamaah;

        return view('profile', [
            'user' => $user,
            'jamaah' => $jamaah,
        ]);
    }

    /**
     * Update profil jamaah.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $jamaah = $user->jamaah;

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'nik' => ['nullable', 'string', 'max:32'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:laki-laki,perempuan'],
            'pasport' => ['required', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'foto_ktp' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'foto_paspor' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $dataJamaah = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'nik' => $validated['nik'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pasport' => $validated['pasport'],
            'alamat' => $validated['alamat'],
        ];

        // Upload foto profil
        if ($request->hasFile('foto')) {
            if ($jamaah && $jamaah->foto) {
                Storage::disk('public')->delete($jamaah->foto);
            }
            $dataJamaah['foto'] = $request->file('foto')->store('profil', 'public');
        }

        // Upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            if ($jamaah && $jamaah->foto_ktp) {
                Storage::disk('public')->delete($jamaah->foto_ktp);
            }
            $dataJamaah['foto_ktp'] = $request->file('foto_ktp')->store('dokumen', 'public');
        }

        // Upload foto paspor
        if ($request->hasFile('foto_paspor')) {
            if ($jamaah && $jamaah->foto_paspor) {
                Storage::disk('public')->delete($jamaah->foto_paspor);
            }
            $dataJamaah['foto_paspor'] = $request->file('foto_paspor')->store('dokumen', 'public');
        }

        if ($jamaah) {
            $jamaah->update($dataJamaah);
        } else {
            $dataJamaah['user_id'] = $user->id;
            $dataJamaah['status_verifikasi'] = 'belum';
            $jamaah = Jamaah::create($dataJamaah);
        }

        // Sinkronisasi data user
        $user->update([
            'name' => $validated['nama'],
            'email' => $validated['email'],
            'phone' => $validated['telepon'],
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
