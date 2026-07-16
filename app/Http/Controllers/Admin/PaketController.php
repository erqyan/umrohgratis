<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketUmrah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Daftar seluruh paket umrah.
     */
    public function index(Request $request)
    {
        $search = $request->query('q', '');

        $query = PaketUmrah::query()->withCount('pendaftaranKuota as pendaftaran_kuota_count');

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('tipe', 'like', "%{$search}%");
        }

        $pakets = $query->orderByDesc('created_at')->paginate(12);

        return view('admin.paket', [
            'pakets' => $pakets,
            'search' => $search,
        ]);
    }

    /**
     * Simpan paket baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:reguler,plus,vip'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:1'],
            'durasi' => ['required', 'integer', 'min:1'],
            'kuota' => ['nullable', 'integer', 'min:1'],
            'hotel' => ['nullable', 'string', 'max:255'],
            'maskapai' => ['nullable', 'string', 'max:255'],
            'tanggal_berangkat' => ['nullable', 'date', 'after_or_equal:today'],
            'lokasi_keberangkatan' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'fasilitas' => ['nullable', 'string'],
            'itinerary' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Upload gambar.
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('paket-umrah', 'public');
        }

        // Parse fasilitas & itinerary dari textarea (baris baru) ke array.
        if (! empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(array_filter(
                array_map('trim', explode("\n", $validated['fasilitas']))
            ));
        }
        if (! empty($validated['itinerary'])) {
            $lines = array_filter(array_map('trim', explode("\n", $validated['itinerary'])));
            $itinerary = [];
            foreach ($lines as $i => $line) {
                $parts = array_pad(explode('|', $line, 3), 3, '');
                $itinerary[] = [
                    'day' => trim($parts[0]) ?: ('Hari ' . ($i + 1)),
                    'title' => trim($parts[1]),
                    'desc' => trim($parts[2]),
                ];
            }
            $validated['itinerary'] = $itinerary;
        }

        PaketUmrah::create($validated);

        return redirect()->route('admin.paket')
            ->with('success', 'Paket umrah berhasil ditambahkan.');
    }

    /**
     * Update paket.
     */
    public function update(Request $request, $id)
    {
        $paket = PaketUmrah::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:reguler,plus,vip'],
            'deskripsi' => ['nullable', 'string'],
            'harga' => ['required', 'numeric', 'min:1'],
            'durasi' => ['required', 'integer', 'min:1'],
            'kuota' => ['nullable', 'integer', 'min:1'],
            'hotel' => ['nullable', 'string', 'max:255'],
            'maskapai' => ['nullable', 'string', 'max:255'],
            'tanggal_berangkat' => ['nullable', 'date', 'after_or_equal:today'],
            'lokasi_keberangkatan' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
            'fasilitas' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if (! empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(array_filter(
                array_map('trim', explode("\n", $validated['fasilitas']))
            ));
        } else {
            $validated['fasilitas'] = null;
        }

        // Kuota kosong = tidak terbatas (null).
        $validated['kuota'] = $validated['kuota'] ?? null;

        // Upload gambar baru, hapus lama jika ada.
        if ($request->hasFile('image')) {
            if ($paket->image && Storage::disk('public')->exists($paket->image)) {
                Storage::disk('public')->delete($paket->image);
            }
            $validated['image'] = $request->file('image')->store('paket-umrah', 'public');
        } elseif ($request->boolean('remove_image')) {
            // Hapus gambar lama tanpa mengganti.
            if ($paket->image && Storage::disk('public')->exists($paket->image)) {
                Storage::disk('public')->delete($paket->image);
            }
            $validated['image'] = null;
        }

        $paket->update($validated);

        return back()->with('success', 'Paket umrah berhasil diperbarui.');
    }

    /**
     * Hapus paket.
     */
    public function destroy($id)
    {
        $paket = PaketUmrah::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.paket')
            ->with('success', 'Paket umrah berhasil dihapus.');
    }
}
