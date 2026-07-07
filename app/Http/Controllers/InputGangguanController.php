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
            'kategori' => 'required|string',
            'penyebab' => 'required|string',
        ]);

        $waktuKejadian = now();

        $gangguan = DB::transaction(function () use ($request, $waktuKejadian) {

            $counter = DB::table('tiket_counters')->lockForUpdate()->first();

            if (!$counter) {
                DB::table('tiket_counters')->insert(['last_number' => 0]);
                $counter = DB::table('tiket_counters')->lockForUpdate()->first();
            }

            $urutan = $counter->last_number + 1;

            DB::table('tiket_counters')
                ->where('id', $counter->id)
                ->update(['last_number' => $urutan]);

            $tanggalKode = $waktuKejadian->format('dmY');
            $noTiket = 'GGN-' . $tanggalKode . '-' . str_pad($urutan, 5, '0', STR_PAD_LEFT);

            return Gangguan::create([
                'id_laporan'        => 'LAP-' . $waktuKejadian->format('YmdHis'),
                'no_tiket'          => $noTiket,
                'gardu_induk'       => $request->unit,
                'waktu_kejadian'    => $waktuKejadian,
                'status'            => 'on_progress',
                'status_jaringan'   => $request->status,
                'tahapan'           => 1,
                'jenis_gangguan'    => $request->kategori,   // ✅ sekarang diisi KATEGORI (KABEL, POWER, dll)
                'catatan_perbaikan' => $request->penyebab,   // ✅ diisi deskripsi/penyebab kendala
            ]);
        });

        return redirect()->route('riwayat.index')->with('success', 'Laporan berhasil dikirim! No. Tiket: ' . $gangguan->no_tiket);
    }
}