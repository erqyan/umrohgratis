<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembayaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected string $search;
    protected string $status;

    public function __construct(string $search = '', string $status = '')
    {
        $this->search = $search;
        $this->status = $status;
    }

    /**
     * Ambil koleksi pembayaran sesuai filter (sama dengan filter di halaman admin).
     */
    public function collection()
    {
        $query = Pembayaran::with(['pendaftaran.jamaah', 'pendaftaran.paketUmrah']);

        if ($this->status && in_array($this->status, ['menunggu', 'terverifikasi', 'ditolak'])) {
            $query->where('status', $this->status);
        }

        if ($this->search) {
            $query->whereHas('pendaftaran.jamaah', function ($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        return $query->orderByDesc('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Jamaah',
            'Email',
            'Telepon',
            'Paket Umrah',
            'Metode Bayar',
            'Harga Paket',
            'Biaya Admin',
            'Total',
            'Tanggal Bayar',
            'Status',
        ];
    }

    /**
     * @param Pembayaran $pembayaran
     */
    public function map($pembayaran): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pembayaran->pendaftaran->jamaah->nama ?? '-',
            $pembayaran->pendaftaran->jamaah->email ?? '-',
            $pembayaran->pendaftaran->jamaah->telepon ?? '-',
            $pembayaran->pendaftaran->paketUmrah->nama ?? '-',
            $pembayaran->metode,
            (float) $pembayaran->jumlah,
            (float) $pembayaran->biaya_admin,
            (float) $pembayaran->total,
            $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d-m-Y') : '-',
            $pembayaran->status_label,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Baris header: tebal, latar hijau muda, teks putih.
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0C8A63']],
            ],
        ];
    }
}
