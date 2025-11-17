<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
  *{ font-family: DejaVu Sans, Arial, Helvetica, sans-serif; }
  body{ font-size:12px; color:#111; }
  .head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px; }
  h2{ margin:0 0 6px 0; font-size:18px; }
  .summary div{ line-height:1.4; }
  .table{ width:100%; border-collapse:collapse; }
  .table th,.table td{ border:1px solid #ddd; padding:6px 8px; }
  .table th{ background:#f2f2f2; }
  .text-right{ text-align:right; }
  .text-center{ text-align:center; }
  .w-8{ width:8%; } .w-14{ width:14%; } .w-16{ width:16%; } .w-20{ width:20%; }
  .footnote{ margin-top:8px; font-size:11px; color:#666; }
</style>
</head>
<body>
  <div class="head">
    <div>
      <h2>Riwayat Transaksi</h2>
      <div style="font-size:11px">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <div class="summary">
      <div>Total Masuk : <strong>Rp {{ number_format($totalMasuk,0,',','.') }}</strong></div>
      <div>Total Keluar: <strong>Rp {{ number_format($totalKeluar,0,',','.') }}</strong></div>
      <div>Saldo       : <strong>Rp {{ number_format($saldo,0,',','.') }}</strong></div>
    </div>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th class="w-8">#</th>
        <th class="w-14">Tanggal</th>
        <th class="w-14">Jenis</th>
        <th>Keterangan</th>
        <th class="w-20">Jumlah</th>
        <th class="w-16">Sumber</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $i => $row)
        <tr>
          <td class="text-center">{{ $i + 1 }}</td>
          <td>{{ \Illuminate\Support\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
          <td>{{ strtolower($row->jenis)==='pemasukan' ? 'Pemasukan' : 'Pengeluaran' }}</td>
          <td>{{ $row->keterangan }}</td>
          <td class="text-right">Rp {{ number_format($row->jumlah,0,',','.') }}</td>
          <td>{{ $row->sumber }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footnote">*Dokumen ini dibuat otomatis oleh SIM Bendahara.</div>
</body>
</html>
