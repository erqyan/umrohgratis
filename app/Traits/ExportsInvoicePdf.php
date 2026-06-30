<?php

namespace App\Traits;

use App\Models\Pembayaran;
use Dompdf\Dompdf;
use Illuminate\Http\Response;

/**
 * Helper generate invoice PDF dari record Pembayaran.
 * Dipakai bersama oleh controller Jamaah & Admin.
 */
trait ExportsInvoicePdf
{
    /**
     * Render invoice pembayaran menjadi response PDF untuk diunduh.
     */
    protected function downloadPembayaranInvoice(Pembayaran $pembayaran): Response
    {
        $pembayaran->load('pendaftaran.jamaah', 'pendaftaran.paketUmrah');

        $html = view('exports.invoice', compact('pembayaran'))->render();

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $filename = 'invoice-' . str_pad((string) $pembayaran->id, 5, '0', STR_PAD_LEFT) . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
