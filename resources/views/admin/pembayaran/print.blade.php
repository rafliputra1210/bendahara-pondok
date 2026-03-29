<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran #{{ $pembayaran->id }}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            margin: 0;
            padding: 24px;
            background: #f3f4f6;
        }

        .receipt {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 24px 28px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
            position: relative;
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
            font-weight: 700;
            font-size: 18px;
            color: #111827;
        }

        .brand span {
            display: block;
            font-weight: 500;
            font-size: 13px;
            color: #6b7280;
        }

        .receipt-title {
            text-align: right;
        }

        .receipt-title h2 {
            margin: 0;
            font-size: 18px;
            color: #111827;
        }

        .receipt-title span {
            font-size: 13px;
            color: #6b7280;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 14px 0 4px;
            font-size: 13px;
            color: #4b5563;
        }

        .info-row span {
            display: block;
        }

        .section-title {
            margin-top: 18px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #9ca3af;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 14px;
        }

        th, td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .text-right {
            text-align: right;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #ecfdf3;
            color: #15803d;
            font-weight: 600;
        }

        .status-badge span.dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #22c55e;
        }

        .status-unpaid {
            background: #fef2f2;
            color: #b91c1c;
        }

        .status-unpaid span.dot {
            background: #ef4444;
        }

        .total-row td {
            border-top: 1px solid #e5e7eb;
            border-bottom: none;
            font-weight: 700;
            font-size: 15px;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6b7280;
        }

        .signature {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
        }

        .signature-space {
            margin-top: 40px;
            border-top: 1px solid #d1d5db;
            width: 180px;
            margin-left: auto;
            margin-right: 0;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                border-radius: 0;
            }
            .no-print {
                display: none !important;
            }
        }

        .no-print-btn {
            position: fixed;
            right: 24px;
            bottom: 24px;
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            background: #111827;
            color: #f9fafb;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(15,23,42,0.35);
        }

        .no-print-btn:hover {
            background: #020617;
        }
    </style>
</head>
<body>

<div class="receipt">
    <div class="receipt-header">
        <div class="brand">
            SIM Bendahara Pondok
            <span>Bukti Pembayaran Santri</span>
        </div>
        <div class="receipt-title">
            <h2>Bukti Pembayaran</h2>
            <span>ID #{{ $pembayaran->id }}</span><br>
            <span>
                Tanggal:
                {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <div class="info-row">
        <div>
            <span><strong>Nama Santri</strong></span>
            <span>{{ $pembayaran->nama_santri }}</span>
        </div>
        <div style="text-align:right;">
            <span><strong>Status</strong></span>
            @php
                $lunas = strtolower($pembayaran->status ?? '') === 'lunas';
            @endphp
            @if($lunas)
                <span class="status-badge">
                    <span class="dot"></span> Lunas
                </span>
            @else
                <span class="status-badge status-unpaid">
                    <span class="dot"></span> Belum Lunas
                </span>
            @endif
        </div>
    </div>

    <div class="section-title">Rincian Pembayaran</div>
    <table>
        <thead>
        <tr>
            <th>Keterangan</th>
            <th class="text-right">Jumlah (Rp)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $pembayaran->keterangan }}</td>
            <td class="text-right">
                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
            </td>
        </tr>
        <tr class="total-row">
            <td>Total Dibayar</td>
            <td class="text-right">
                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
            </td>
        </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Mengetahui,</p>
        <div class="signature-space"></div>
        <p style="margin-top: 4px;">Bendahara</p>
    </div>

    <div class="footer">
        <div>
            Dicetak dari sistem SIM Bendahara Pondok.<br>
            Dokumen ini sah walaupun tanpa tanda tangan basah.
        </div>
        <div style="text-align:right;">
            Dicetak pada:<br>
            {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>

<button class="no-print-btn no-print" onclick="window.print()">
    Cetak / Simpan PDF
</button>

</body>
</html>
