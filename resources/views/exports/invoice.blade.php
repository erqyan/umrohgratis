<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $pembayaran->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", "Segoe UI", Arial, sans-serif;
            color: #1b1b18;
            font-size: 12px;
            line-height: 1.5;
        }
        .page { padding: 40px; }
        /* Header / Kop Surat */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #0c8a63;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo {
            width: 46px; height: 46px; border-radius: 10px;
            background: #0c8a63; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: bold;
        }
        .brand-name { font-size: 20px; font-weight: bold; color: #0c8a63; }
        .brand-tag { font-size: 10px; color: #6b7a70; }
        .invoice-meta { text-align: right; }
        .invoice-title {
            font-size: 24px; font-weight: bold; color: #0c8a63;
            letter-spacing: 1px;
        }
        .invoice-meta .meta-row { font-size: 11px; color: #4b5563; margin-top: 2px; }
        .invoice-meta .meta-row strong { color: #1b1b18; }

        /* Info dua kolom */
        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 24px;
        }
        .info-block { flex: 1; }
        .info-label {
            font-size: 9px; font-weight: bold; text-transform: uppercase;
            letter-spacing: .06em; color: #0c8a63; margin-bottom: 6px;
        }
        .info-value { font-size: 12px; color: #1b1b18; }
        .info-value strong { font-size: 13px; }

        /* Tabel rincian */
        .section-title {
            font-size: 11px; font-weight: bold; text-transform: uppercase;
            letter-spacing: .06em; color: #4b5563;
            margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        thead th {
            background: #0c8a63; color: #fff;
            font-size: 10px; font-weight: bold;
            text-align: left; padding: 10px 12px;
        }
        thead th.right { text-align: right; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #e8eee9; font-size: 11px; }
        tbody td.right { text-align: right; }
        tfoot td {
            padding: 10px 12px; font-size: 12px; font-weight: bold;
            border-top: 2px solid #0c8a63;
        }
        tfoot td.right { text-align: right; }
        .grand-total td {
            font-size: 15px; color: #0c8a63;
            background: #f0f5f3;
        }

        /* Status badge */
        .status-wrap { margin-top: 20px; }
        .badge {
            display: inline-block; padding: 6px 14px; border-radius: 999px;
            font-size: 11px; font-weight: bold;
        }
        .badge-verified { background: #e8f5f0; color: #0c8a63; }
        .badge-pending { background: #fff4e6; color: #b45309; }
        .badge-rejected { background: #ffe6e6; color: #d4483c; }

        /* Footer tanda tangan */
        .footer-grid {
            display: flex; justify-content: space-between;
            margin-top: 50px; gap: 24px;
        }
        .sign-block { text-align: center; width: 200px; }
        .sign-label { font-size: 11px; color: #4b5563; margin-bottom: 60px; }
        .sign-name { font-size: 12px; font-weight: bold; border-top: 1px solid #1b1b18; padding-top: 6px; }

        .note {
            margin-top: 30px; padding: 12px 16px;
            background: #f7faf7; border-left: 3px solid #0c8a63;
            font-size: 10px; color: #5c7264;
        }
        .doc-foot {
            margin-top: 24px; text-align: center;
            font-size: 9px; color: #9ca9a2;
            border-top: 1px solid #e8eee9; padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="page">
        {{-- Header / Kop --}}
        <div class="header">
            <div class="brand">
                <div class="brand-logo">M</div>
                <div>
                    <div class="brand-name">Smart Umrah</div>
                    <div class="brand-tag">Travel Umrah Resmi &amp; Terpercaya</div>
                    <div class="brand-tag">support@smartumrah.id &middot; +62 812-3456-7890</div>
                </div>
            </div>
            <div class="invoice-meta">
                <div class="invoice-title">INVOICE</div>
                <div class="meta-row"><strong>No:</strong> INV-{{ str_pad((string) $pembayaran->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="meta-row"><strong>Tanggal:</strong> {{ $pembayaran->created_at->format('d F Y') }}</div>
                <div class="meta-row"><strong>Jatuh Tempo:</strong> 24 jam sejak terbit</div>
            </div>
        </div>

        {{-- Info Jamaah & Paket --}}
        <div class="info-grid">
            <div class="info-block">
                <div class="info-label">Dibebankan Kepada</div>
                <div class="info-value"><strong>{{ $pembayaran->pendaftaran->jamaah->nama ?? '-' }}</strong></div>
                <div class="info-value">{{ $pembayaran->pendaftaran->jamaah->email ?? '-' }}</div>
                <div class="info-value">{{ $pembayaran->pendaftaran->jamaah->telepon ?? '-' }}</div>
                @if($pembayaran->pendaftaran->jamaah->alamat ?? null)
                    <div class="info-value">{{ $pembayaran->pendaftaran->jamaah->alamat }}</div>
                @endif
            </div>
            <div class="info-block">
                <div class="info-label">Perjalanan</div>
                <div class="info-value"><strong>{{ $pembayaran->pendaftaran->paketUmrah->nama ?? '-' }}</strong></div>
                <div class="info-value">{{ $pembayaran->pendaftaran->paketUmrah->durasi_text ?? '-' }}</div>
                <div class="info-value">Hotel: {{ $pembayaran->pendaftaran->paketUmrah->hotel ?? '-' }} &middot; {{ $pembayaran->pendaftaran->paketUmrah->maskapai ?? '-' }}</div>
            </div>
        </div>

        {{-- Tabel rincian biaya --}}
        <div class="section-title">Rincian Pembayaran</div>
        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paket Umrah — {{ $pembayaran->pendaftaran->paketUmrah->nama ?? '-' }}</td>
                    <td class="right">Rp {{ number_format((float) $pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Admin</td>
                    <td class="right">Rp {{ number_format((float) $pembayaran->biaya_admin, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot class="grand-total">
                <tr>
                    <td class="right">Total Pembayaran</td>
                    <td class="right">Rp {{ number_format((float) $pembayaran->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="status-wrap">
            <div class="info-label" style="margin-bottom: 6px;">Status Pembayaran</div>
            @if($pembayaran->status === 'terverifikasi')
                <span class="badge badge-verified">&#10003; Terverifikasi</span>
            @elseif($pembayaran->status === 'ditolak')
                <span class="badge badge-rejected">&#10007; Ditolak</span>
            @else
                <span class="badge badge-pending">Menunggu Verifikasi</span>
            @endif
            <div style="margin-top: 8px; font-size: 11px; color: #4b5563;">
                <strong>Metode:</strong> {{ $pembayaran->metode }}
            </div>
        </div>

        <div class="note">
            <strong>Catatan:</strong> Selesaikan pembayaran dalam 24 jam untuk menghindari pembatalan otomatis.
            Bukti pembayaran ini merupakan dokumen resmi dari Smart Umrah. Simpan sebagai bukti transaksi Anda.
        </div>

        {{-- Footer tanda tangan --}}
        <div class="footer-grid">
            <div class="sign-block">
                <div class="sign-label">Jamaah,</div>
                <div class="sign-name">{{ $pembayaran->pendaftaran->jamaah->nama ?? '-' }}</div>
            </div>
            <div class="sign-block">
                <div class="sign-label">Hormat Kami,<br>{{ $pembayaran->created_at->format('d F Y') }}</div>
                <div class="sign-name">Smart Umrah</div>
            </div>
        </div>

        <div class="doc-foot">
            Dokumen ini dibuat secara elektronik melalui sistem Smart Umrah &middot; Halaman 1 dari 1
        </div>
    </div>
</body>
</html>
