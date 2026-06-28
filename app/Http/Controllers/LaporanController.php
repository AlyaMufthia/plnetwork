<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gangguan;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'unit'     => 'required|string',
            'status'   => 'required|in:DOWN,UP',
            'penyebab' => 'required|string',
        ]);

        Gangguan::create([
            'id_laporan'        => 'LAP-' . now()->format('YmdHis'),
            'gardu_induk'       => $request->unit,
            'waktu_kejadian'    => now(),
            'status'            => 'on_progress',
            'tahapan'           => 1,
            'jenis_gangguan'    => $request->status,
            'catatan_perbaikan' => $request->detail,
        ]);

        return redirect()->route('riwayat.index')->with('success', 'Laporan berhasil dikirim!');
    }
}