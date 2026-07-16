<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PembayaranExport;
use App\Http\Controllers\Controller;
use App\Models\NotifikasiJamaah;
use App\Models\Pembayaran;
use App\Traits\ExportsInvoicePdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    use ExportsInvoicePdf;

    /**
     * Daftar seluruh pembayaran.
     */
    public function index(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');

        $query = Pembayaran::with(['pendaftaran.jamaah', 'pendaftaran.paketUmrah']);

        if ($status && in_array($status, ['menunggu', 'terverifikasi', 'ditolak'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('pendaftaran.jamaah', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pembayarans = $query->orderByDesc('created_at')->paginate(12);

        $totalVerified = Pembayaran::where('status', 'terverifikasi')->sum('total');
        $totalPending = Pembayaran::where('status', 'menunggu')->count();

        return view('admin.pembayaran', [
            'pembayarans' => $pembayarans,
            'totalVerified' => $totalVerified,
            'totalPending' => $totalPending,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Ubah status verifikasi pembayaran.
     */
    public function updateStatus(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $rules = [
            'status' => ['required', 'in:menunggu,terverifikasi,ditolak'],
        ];

        // Alasan wajib saat menolak.
        if ($request->status === 'ditolak') {
            $rules['alasan'] = ['required', 'string', 'min:5', 'max:500'];
        }

        $validated = $request->validate($rules);

        $pembayaran->update(['status' => $validated['status']]);

        // Sinkronisasi: jika pembayaran terverifikasi, update status pendaftaran.
        if ($validated['status'] === 'terverifikasi' && $pembayaran->pendaftaran) {
            $pembayaran->pendaftaran->update(['status' => 'aktif']);

            // Update status verifikasi jamaah juga.
            if ($pembayaran->pendaftaran->jamaah) {
                $pembayaran->pendaftaran->jamaah->update(['status_verifikasi' => 'terverifikasi']);
            }
        }

        // Simpan notifikasi penolakan untuk jamaah.
        if ($validated['status'] === 'ditolak' && $pembayaran->pendaftaran && $pembayaran->pendaftaran->jamaah) {
            NotifikasiJamaah::create([
                'jamaah_id' => $pembayaran->pendaftaran->jamaah->id,
                'tipe' => NotifikasiJamaah::TIPE_PENOLAKAN_PEMBAYARAN,
                'judul' => 'Pembayaran Ditolak',
                'pesan' => $validated['alasan'],
                'terkait_type' => Pembayaran::class,
                'terkait_id' => $pembayaran->id,
            ]);

            // Update status pendaftaran menjadi batal.
            $pembayaran->pendaftaran->update(['status' => 'batal']);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Export seluruh pembayaran ke file Excel (.xlsx) sesuai filter aktif.
     */
    public function export(Request $request)
    {
        $search = $request->query('q', '');
        $status = $request->query('status', '');

        $filename = 'laporan-pembayaran-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new PembayaranExport($search, $status), $filename);
    }

    /**
     * Unduh invoice/kuitansi PDF untuk satu pembayaran.
     */
    public function invoice($id)
    {
        $pembayaran = Pembayaran::with('pendaftaran.jamaah', 'pendaftaran.paketUmrah')->findOrFail($id);

        return $this->downloadPembayaranInvoice($pembayaran);
    }
}
