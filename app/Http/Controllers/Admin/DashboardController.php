<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\PaketUmrah;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    /**
     * Halaman dashboard utama admin.
     */
    public function index()
    {
        $totalJamaah = Jamaah::count();
        $paketAktif = PaketUmrah::where('status', 'aktif')->count();
        $belumVerifikasi = Jamaah::where('status_verifikasi', 'belum')->count();
        $sudahVerifikasi = Jamaah::where('status_verifikasi', 'terverifikasi')->count();
        $pendapatan = Pembayaran::where('status', 'terverifikasi')->sum('total');
        $pendaftaranPending = Pendaftaran::where('status', 'pending')->count();

        return view('admin.dashboard', [
            'totalJamaah' => $totalJamaah,
            'paketAktif' => $paketAktif,
            'belumVerifikasi' => $belumVerifikasi,
            'sudahVerifikasi' => $sudahVerifikasi,
            'pendapatan' => $pendapatan,
            'pendaftaranPending' => $pendaftaranPending,
        ]);
    }
}
