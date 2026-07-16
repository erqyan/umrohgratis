<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotifikasiJamaah;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Daftar seluruh pendaftaran.
     */
    public function index(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');

        $query = Pendaftaran::with(['jamaah', 'paketUmrah', 'pembayaranTerakhir']);

        if ($search) {
            $query->whereHas('jamaah', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status && in_array($status, ['draft', 'pending', 'aktif', 'selesai', 'batal'])) {
            $query->where('status', $status);
        }

        $pendaftarans = $query->orderByDesc('tanggal_pendaftaran')->paginate(12);

        return view('admin.pendaftaran', [
            'pendaftarans' => $pendaftarans,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Ubah status pendaftaran.
     */
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $rules = [
            'status' => ['required', 'in:draft,pending,aktif,selesai,batal'],
        ];

        // Alasan wajib saat membatalkan.
        if ($request->status === 'batal') {
            $rules['alasan'] = ['required', 'string', 'min:5', 'max:500'];
        }

        $validated = $request->validate($rules);

        $statusLama = $pendaftaran->status;
        $pendaftaran->update(['status' => $validated['status']]);

        // Notifikasi ke jamaah saat pendaftarannya dibatalkan.
        if ($validated['status'] === 'batal' && $statusLama !== 'batal' && $pendaftaran->jamaah) {
            NotifikasiJamaah::create([
                'jamaah_id' => $pendaftaran->jamaah->id,
                'tipe' => 'pembatalan_pendaftaran',
                'judul' => 'Pendaftaran Dibatalkan',
                'pesan' => $validated['alasan'],
                'terkait_type' => Pendaftaran::class,
                'terkait_id' => $pendaftaran->id,
            ]);
        }

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
