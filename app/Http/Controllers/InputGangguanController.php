<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InputGangguanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit'         => 'required|string|max:255',
            'status'       => 'required|in:DOWN,UP',
            'lokasi_gardu' => 'nullable|string|max:255',
            'kategori'     => 'required|string|max:50',
            'penyebab'     => 'required|string',
        ], [
            'unit.required'     => 'Unit / Lokasi Utama wajib dipilih.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'penyebab.required' => 'Penyebab kendala wajib diisi.',
        ]);

        // Coba ambil IP address dari string unit, misal "10.43.51.1 (GI BINJAI 150)"
        preg_match('/\b\d{1,3}(?:\.\d{1,3}){3}\b/', $validated['unit'], $matches);
        $ipAddress = $matches[0] ?? null;

        Gangguan::create([
            'id_laporan'        => 'LAP-' . now()->format('Ymdhis') . '-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT),
            'no_tiket'          => null,
            'ip_address'        => $ipAddress,
            'gardu_induk'       => $validated['unit'],
            'waktu_kejadian'    => now(),
            'status'            => 'on_progress',
            'tahapan'           => 1,
            'jenis_gangguan'    => $validated['kategori'],
            'status_jaringan'   => $validated['status'],
            'foto_lokasi'       => null,
            'foto_petugas'      => null,
            'catatan_perbaikan' => $validated['penyebab'],
        ]);

        return redirect()
            ->route('inputgangguan.index')
            ->with('success', 'Data gangguan berhasil dikirim.');
    }
}