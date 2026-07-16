<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\PaketUmrah;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Tampilkan daftar paket umrah.
     */
    public function index()
    {
        $pakets = PaketUmrah::where('status', 'aktif')
            ->withCount('pendaftaranKuota as pendaftaran_kuota_count')
            ->orderBy('harga')
            ->get()
            ->filter(fn ($p) => $p->kuota === null || $p->kuota_terpakai < $p->kuota);

        return view('paket', [
            'pakets' => $pakets,
        ]);
    }

    /**
     * Tampilkan detail paket umrah.
     */
    public function show($id)
    {
        $paket = PaketUmrah::where('status', 'aktif')
            ->withCount('pendaftaranKuota as pendaftaran_kuota_count')
            ->findOrFail($id);
        $pakets = PaketUmrah::where('status', 'aktif')
            ->withCount('pendaftaranKuota as pendaftaran_kuota_count')
            ->orderBy('harga')
            ->get()
            ->filter(fn ($p) => $p->kuota === null || $p->kuota_terpakai < $p->kuota);

        return view('paket-detail', [
            'paket' => $paket,
            'pakets' => $pakets,
        ]);
    }
}
