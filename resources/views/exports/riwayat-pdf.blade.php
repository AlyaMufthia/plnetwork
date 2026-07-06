<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Gangguan</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: sans-serif; }
        body { padding: 24px; color:#111827; }

        .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; border-bottom:2px solid #173a84; padding-bottom:14px; }
        .header h1 { font-size:18px; color:#173a84; }
        .header p { font-size:10px; color:#6b7280; margin-top:4px; }
        .header .meta { text-align:right; font-size:10px; color:#6b7280; }

        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th { background:#173a84; color:#fff; font-size:10px; text-align:left; padding:8px 10px; text-transform:uppercase; }
        td { font-size:10px; padding:8px 10px; border-bottom:1px solid #e5e7eb; vertical-align:top; }
        tr:nth-child(even) td { background:#f9fafb; }

        .status { display:inline-block; padding:3px 8px; border-radius:4px; font-size:9px; font-weight:bold; }
        .status-up { background:#dcfce7; color:#15803d; }
        .status-down { background:#fef2f2; color:#dc2626; }

        .footer { margin-top:24px; text-align:center; font-size:9px; color:#9ca3af; border-top:1px solid #e5e7eb; padding-top:10px; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Riwayat Gangguan</h1>
            <p>PLNetwork Hub Asset Management System</p>
        </div>
        <div class="meta">
            Dicetak: {{ now()->format('d F Y, H:i') }} WIB<br>
            Total data: {{ $data->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:25%;">Unit</th>
                <th style="width:10%;">Status</th>
                <th style="width:30%;">Penyebab Kendala</th>
                <th style="width:15%;">No. Tiket</th>
                <th style="width:15%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->gardu_induk }}</td>
                <td>
                    @if($row->status_jaringan === 'UP')
                        <span class="status status-up">UP</span>
                    @else
                        <span class="status status-down">DOWN</span>
                    @endif
                </td>
                <td>{{ $row->catatan_perbaikan ?? '-' }}</td>
                <td>{{ $row->no_tiket ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($row->waktu_kejadian)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:20px; color:#9ca3af;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        POWERING NORTH SUMATERA SAFELY &bull; © {{ now()->year }} PLNetwork Hub Asset Management System. All maintenance records are digitally signed.
    </div>

</body>
</html>