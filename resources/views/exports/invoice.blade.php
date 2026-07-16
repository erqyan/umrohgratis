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
        
        /* Brand & Kop */
        .brand-logo {
            width: 44px; height: 44px; border-radius: 8px;
            background: #0c8a63; color: #fff;
            font-size: 22px; font-weight: bold;
            text-align: center;
            line-height: 44px;
        }
        .brand-name { font-size: 20px; font-weight: bold; color: #0c8a63; }
        .brand-tag { font-size: 10px; color: #6b7a70; }
        .invoice-title {
            font-size: 24px; font-weight: bold; color: #0c8a63;
            letter-spacing: 1px;
        }
        .meta-row { font-size: 11px; color: #4b5563; margin-top: 2px; }
        .meta-row strong { color: #1b1b18; }

        /* Block Data */
        .info-label {
            font-size: 9px; font-weight: bold; text-transform: uppercase;
            letter-spacing: .06em; color: #0c8a63; margin-bottom: 6px;
        }
        .info-value { font-size: 11px; color: #4b5563; margin-bottom: 2px; }
        .info-value strong { font-size: 12px; color: #1b1b18; }

        /* Table Rincian */
        .section-title {
            font-size: 11px; font-weight: bold; text-transform: uppercase;
            letter-spacing: .06em; color: #4b5563;
            margin-bottom: 10px;
        }
        table.items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items-table th {
            background: #0c8a63; color: #fff;
            font-size: 10px; font-weight: bold;
            text-align: left; padding: 10px 12px;
            border: none;
        }
        table.items-table td { padding: 10px 12px; border-bottom: 1px solid #e8eee9; font-size: 11px; }
        table.items-table tfoot td {
            padding: 12px; font-size: 12px; font-weight: bold;
            border-top: 2px solid #0c8a63;
        }
        table.items-table .grand-total td {
            font-size: 14px; color: #0c8a63;
            background: #f0f5f3;
        }

        /* Status Badge */
        .badge {
            display: inline-block; padding: 6px 14px; border-radius: 999px;
            font-size: 11px; font-weight: bold;
        }
        .badge-verified { background: #e8f5f0; color: #0c8a63; }
        .badge-pending { background: #fff4e6; color: #b45309; }
        .badge-rejected { background: #ffe6e6; color: #d4483c; }

        /* Footer Tanda Tangan */
        .sign-label { font-size: 11px; color: #4b5563; margin-bottom: 60px; }
        .sign-name { font-size: 12px; font-weight: bold; border-top: 1px solid #1b1b18; padding-top: 6px; }

        .note {
            margin-top: 30px; padding: 12px 16px;
            background: #f7faf7; border-left: 3px solid #0c8a63;
            font-size: 10px; color: #5c7264;
            border-radius: 0 8px 8px 0;
        }
        .doc-foot {
            margin-top: 40px; text-align: center;
            font-size: 9px; color: #9ca9a2;
            border-top: 1px solid #e8eee9; padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="page">
        {{-- Kop Surat & Meta Invoice (Table-based 2 columns) --}}
        <table style="width: 100%; border-bottom: 3px solid #0c8a63; padding-bottom: 18px; margin-bottom: 24px; border-collapse: collapse;">
            <tr>
                <td style="vertical-align: top; text-align: left; padding: 0; width: 60%;">
                    <table style="border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: top; padding: 0; width: 70px;">
                                @php
                                    $logoPath = public_path('images/logo.jpg');
                                    $logoBase64 = '';
                                    if (file_exists($logoPath)) {
                                        $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
                                    }
                                @endphp
                                @if($logoBase64)
                                    <img src="{{ $logoBase64 }}" alt="Logo" style="width: 60px; height: auto; object-fit: contain;">
                                @endif
                            </td>
                            <td style="vertical-align: top; padding: 0 0 0 12px;">
                                <div class="brand-name" style="font-size: 15px; font-weight: 800; line-height: 1.2;">PT. KHOTIMAH AHMAD TOUR & TRAVEL</div>
                                <div class="brand-tag">Travel Umrah Resmi &amp; Terpercaya &middot; Smart Umrah</div>
                                <div class="brand-tag">ptkatt22@gmail.com &middot; +62 813-2587-4378</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top; text-align: right; padding: 0; width: 40%;">
                    <div class="invoice-title">INVOICE</div>
                    <div class="meta-row"><strong>No:</strong> INV-{{ str_pad((string) $pembayaran->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="meta-row"><strong>Tanggal:</strong> {{ $pembayaran->created_at->format('d F Y') }}</div>
                    <div class="meta-row"><strong>Jatuh Tempo:</strong> 24 jam sejak terbit</div>
                </td>
            </tr>
        </table>

        {{-- Info Jamaah & Perjalanan (Table-based 2 columns) --}}
        <table style="width: 100%; margin-bottom: 24px; border-collapse: collapse;">
            <tr>
                <td style="vertical-align: top; padding: 0; width: 50%;">
                    <div class="info-label">Dibebankan Kepada</div>
                    <div class="info-value"><strong>{{ $pembayaran->pendaftaran->jamaah->nama ?? '-' }}</strong></div>
                    <div class="info-value">{{ $pembayaran->pendaftaran->jamaah->email ?? '-' }}</div>
                    <div class="info-value">{{ $pembayaran->pendaftaran->jamaah->telepon ?? '-' }}</div>
                    @if($pembayaran->pendaftaran->jamaah->alamat ?? null)
                        <div class="info-value" style="width: 90%; word-wrap: break-word;">{{ $pembayaran->pendaftaran->jamaah->alamat }}</div>
                    @endif
                </td>
                <td style="vertical-align: top; padding: 0; width: 50%;">
                    <div class="info-label">Perjalanan</div>
                    <div class="info-value"><strong>{{ $pembayaran->pendaftaran->paketUmrah->nama ?? '-' }}</strong></div>
                    <div class="info-value">{{ $pembayaran->pendaftaran->paketUmrah->durasi_text ?? '-' }}</div>
                    <div class="info-value">Hotel: {{ $pembayaran->pendaftaran->paketUmrah->hotel ?? '-' }}</div>
                    <div class="info-value">Maskapai: {{ $pembayaran->pendaftaran->paketUmrah->maskapai ?? '-' }}</div>
                </td>
            </tr>
        </table>

        {{-- Tabel Rincian Biaya --}}
        <div class="section-title">Rincian Pembayaran</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th style="text-align: right; width: 150px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paket Umrah — {{ $pembayaran->pendaftaran->paketUmrah->nama ?? '-' }}</td>
                    <td style="text-align: right; font-weight: bold; color: #1b1b18;">Rp {{ number_format((float) $pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Admin</td>
                    <td style="text-align: right; font-weight: bold; color: #1b1b18;">Rp {{ number_format((float) $pembayaran->biaya_admin, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="grand-total">
                    <td style="text-align: right;">Total Pembayaran</td>
                    <td style="text-align: right; font-weight: 800;">Rp {{ number_format((float) $pembayaran->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- Status & Metode --}}
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px;">
            <tr>
                <td style="padding: 0; vertical-align: top;">
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
                </td>
            </tr>
        </table>

        <div class="note">
            <strong>Catatan:</strong> Selesaikan pembayaran dalam 24 jam untuk menghindari pembatalan otomatis.
            Bukti pembayaran ini merupakan dokumen resmi dari PT. KHOTIMAH AHMAD TOUR & TRAVEL. Simpan sebagai bukti transaksi Anda.
        </div>

        {{-- Tanda Tangan (Table-based 2 columns) --}}
        <table style="width: 100%; margin-top: 50px; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top; padding: 0;">
                    <div class="sign-label">Jamaah,</div>
                    <div class="sign-name" style="display: inline-block; width: 160px;">{{ $pembayaran->pendaftaran->jamaah->nama ?? '-' }}</div>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top; padding: 0;">
                    <div class="sign-label">Hormat Kami,<br>{{ $pembayaran->created_at->format('d F Y') }}</div>
                    <div class="sign-name" style="display: inline-block; width: 220px;">PT. KHOTIMAH AHMAD TOUR & TRAVEL</div>
                </td>
            </tr>
        </table>

        <div class="doc-foot">
            Dokumen ini dibuat secara elektronik melalui sistem Smart Umrah &middot; PT. KHOTIMAH AHMAD TOUR & TRAVEL &middot; Halaman 1 dari 1
        </div>
    </div>
</body>
</html>
