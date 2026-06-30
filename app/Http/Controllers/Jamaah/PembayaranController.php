<?php

namespace App\Http\Controllers\Jamaah;

use App\Http\Controllers\Controller;
use App\Models\PaketUmrah;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Traits\ExportsInvoicePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    use ExportsInvoicePdf;

    private const BIAYA_ADMIN = 250000;

    /**
     * Tampilkan halaman pembayaran untuk paket tertentu.
     */
    public function show($id)
    {
        $paket = PaketUmrah::where('status', 'aktif')->findOrFail($id);
        $user = Auth::user();
        $jamaah = $user->jamaah;

        $pendaftaran = $jamaah
            ? $jamaah->pendaftarans()->where('paket_umrah_id', $paket->id)->latest()->first()
            : null;

        // Jika belum mendaftar, arahkan ke pendaftaran.
        if (! $pendaftaran) {
            return redirect()->route('pendaftaran.show', $paket->id)
                ->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu.');
        }

        return view('pembayaran', [
            'paket' => $paket,
            'pendaftaran' => $pendaftaran,
            'biayaAdmin' => self::BIAYA_ADMIN,
            'total' => (float) $paket->harga + self::BIAYA_ADMIN,
        ]);
    }

    /**
     * Konfirmasi pembayaran: simpan record pembayaran + upload bukti.
     */
    public function confirm(Request $request, $id)
    {
        $paket = PaketUmrah::where('status', 'aktif')->findOrFail($id);
        $user = Auth::user();
        $jamaah = $user->jamaah;

        $pendaftaran = $jamaah
            ? $jamaah->pendaftarans()->where('paket_umrah_id', $paket->id)->latest()->first()
            : null;

        if (! $pendaftaran) {
            return redirect()->route('pendaftaran.show', $paket->id)
                ->with('error', 'Silakan lengkapi data pendaftaran terlebih dahulu.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string'],
            'proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $biayaAdmin = self::BIAYA_ADMIN;
        $jumlah = (float) $paket->harga;
        $total = $jumlah + $biayaAdmin;

        $dataPembayaran = [
            'pendaftaran_id' => $pendaftaran->id,
            'metode' => $validated['payment_method'],
            'jumlah' => $jumlah,
            'biaya_admin' => $biayaAdmin,
            'total' => $total,
            'tanggal_bayar' => now(),
            'status' => 'menunggu',
        ];

        if ($request->hasFile('proof')) {
            $dataPembayaran['bukti_pembayaran'] = $request->file('proof')->store('bukti-pembayaran', 'public');
        }

        $pembayaran = Pembayaran::create($dataPembayaran);

        // Update status pendaftaran menjadi aktif.
        $pendaftaran->update(['status' => 'aktif']);

        return redirect()->route('pembayaran.status', [$paket->id, $pembayaran->id])
            ->with('status', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }

    /**
     * Tampilkan status pembayaran.
     */
    public function status($paketId, $pembayaranId)
    {
        $paket = PaketUmrah::findOrFail($paketId);
        $pembayaran = Pembayaran::with('pendaftaran.jamaah')->findOrFail($pembayaranId);

        return view('status-pembayaran', [
            'paket' => $paket,
            'pembayaran' => $pembayaran,
        ]);
    }

    /**
     * Unduh invoice/kuitansi PDF untuk pembayaran milik jamaah yang login.
     */
    public function invoice($paketId, $pembayaranId)
    {
        $pembayaran = Pembayaran::with('pendaftaran.jamaah', 'pendaftaran.paketUmrah')
            ->findOrFail($pembayaranId);

        $jamaah = Auth::user()->jamaah;

        // Cek kepemilikan: pembayaran harus milik jamaah yang sedang login.
        if (! $jamaah || $pembayaran->pendaftaran->jamaah_id !== $jamaah->id) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        return $this->downloadPembayaranInvoice($pembayaran);
    }
}
