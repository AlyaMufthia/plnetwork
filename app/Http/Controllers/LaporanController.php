<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gangguan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'unit'     => 'required|string',
            'status'   => 'required|in:DOWN,UP',
            'penyebab' => 'required|string',
        ]);

        $waktuKejadian = now();

        $gangguan = DB::transaction(function () use ($request, $waktuKejadian) {

            // ✅ Hitung urutan tiket hari ini (lock supaya tidak bentrok kalau ada input bersamaan)
            $tanggalKode = $waktuKejadian->format('dmY'); // contoh: 30062026

            $urutan = Gangguan::where('no_tiket', 'like', $tanggalKode . '-%')
                ->lockForUpdate()
                ->count() + 1;

            // Format nomor tiket: DDMMYYYY-XXXX -> 30062026-0001
            $noTiket = $tanggalKode . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);

            return Gangguan::create([
                'id_laporan'        => 'LAP-' . $waktuKejadian->format('YmdHis'),
                'no_tiket'          => $noTiket,
                'gardu_induk'       => $request->unit,
                'waktu_kejadian'    => $waktuKejadian,
                'status'            => 'on_progress',
                'status_jaringan'   => $request->status,   // UP / DOWN
                'tahapan'           => 1,
                'jenis_gangguan'    => $request->penyebab,  // Gangguan Jaringan, dll
                'catatan_perbaikan' => $request->detail,
            ]);
        });

        return redirect()->route('riwayat.index')->with('success', 'Laporan berhasil dikirim! No. Tiket: ' . $gangguan->no_tiket);
    }
}