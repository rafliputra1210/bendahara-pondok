<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Riwayat Transaksi - Cetak</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;background:#fff;color:#111;padding:10px}
    h2{margin:0 0 10px}
    .stats{display:flex;gap:14px;margin:10px 0 16px}
    .card{border:1px solid #ddd;border-radius:8px;padding:10px;width:33%}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #ccc;padding:6px 8px;font-size:12px}
    th{text-align:left;background:#f7f7f7}
    .right{text-align:right}
  </style>
</head>
<body onload="window.print()">
  <h2>Riwayat Transaksi</h2>

  <div class="stats">
    <div class="card"><div>Total Masuk</div><strong>Rp {{ number_format($totalMasuk,0,',','.') }}</strong></div>
    <div class="card"><div>Total Keluar</div><strong>Rp {{ number_format($totalKeluar,0,',','.') }}</strong></div>
    <div class="card"><div>Saldo</div><strong>Rp {{ number_format($totalMasuk-$totalKeluar,0,',','.') }}</strong></div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:40px">#</th>
        <th style="width:110px">Tanggal</th>
        <th style="width:110px">Jenis</th>
        <th>Keterangan</th>
        <th style="width:140px">Jumlah</th>
        <th style="width:110px">Sumber</th>
      </tr>
    </thead>
    <tbody>
    @foreach($rows as $i => $row)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ \Illuminate\Support\Optional::make($row->tanggal)->format('d M Y') }}</td>
        <td>{{ ucfirst($row->jenis) }}</td>
        <td>{{ $row->keterangan }}</td>
        <td class="right">Rp {{ number_format($row->jumlah,0,',','.') }}</td>
        <td>{{ $row->sumber }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</body>
</html>
