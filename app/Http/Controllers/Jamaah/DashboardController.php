<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\NotifikasiJamaah;
use App\Models\PaketUmrah;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard utama jamaah.
     */
    public function index()
    {
        $user = Auth::user();
        $jamaah = $user->jamaah;

        // Ambil pendaftaran aktif jamaah (jika ada).
        $pendaftaranAktif = $jamaah
            ? $jamaah->pendaftarans()->with('paketUmrah', 'pembayaranTerakhir')->latest()->first()
            : null;

        // Paket tersedia untuk dipilih (sembunyikan yang kuota penuh).
        $pakets = PaketUmrah::where('status', 'aktif')
            ->withCount('pendaftaranKuota as pendaftaran_kuota_count')
            ->orderBy('harga')
            ->get()
            ->filter(fn ($p) => $p->kuota === null || $p->kuota_terpakai < $p->kuota);

        // Notifikasi penolakan yang belum dibaca.
        $notifikasiBelumDibaca = $jamaah
            ? NotifikasiJamaah::where('jamaah_id', $jamaah->id)->where('dibaca', false)->latest()->take(5)->get()
            : collect();

        // Riwayat pendaftaran.
        $riwayat = $jamaah
            ? $jamaah->pendaftarans()->with('paketUmrah', 'pembayaranTerakhir')->latest()->take(5)->get()
            : collect();

        return view('dashboard', [
            'user' => $user,
            'jamaah' => $jamaah,
            'pendaftaranAktif' => $pendaftaranAktif,
            'pakets' => $pakets,
            'riwayat' => $riwayat,
            'notifikasiBelumDibaca' => $notifikasiBelumDibaca,
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function tandaiDibaca($id)
    {
        $user = Auth::user();
        $jamaah = $user->jamaah;

        $notifikasi = NotifikasiJamaah::findOrFail($id);

        // Pastikan notifikasi milik jamaah yang login.
        if (! $jamaah || $notifikasi->jamaah_id !== $jamaah->id) {
            abort(403, 'Anda tidak memiliki akses ke notifikasi ini.');
        }

        $notifikasi->update(['dibaca' => true]);

        return back()->with('status', 'Notifikasi ditandai sudah dibaca.');
    }
}
