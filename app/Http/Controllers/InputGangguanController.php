<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InputGangguanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit'         => 'required|string|max:255',
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

        // Generate nomor tiket otomatis & unik, format: GGN-ddmmyyyy-00023
        // Nomor urut TERUS bertambah (tidak reset per hari), diambil dari
        // tabel tiket_counters dengan row locking supaya aman dari race condition
        // kalau ada beberapa laporan masuk bersamaan.
        $noTiket = DB::transaction(function () {
            $counter = DB::table('tiket_counters')->lockForUpdate()->first();

            if (!$counter) {
                $newNumber = 1;
                DB::table('tiket_counters')->insert([
                    'last_number' => $newNumber,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            } else {
                $newNumber = $counter->last_number + 1;
                DB::table('tiket_counters')
                    ->where('id', $counter->id)
                    ->update([
                        'last_number' => $newNumber,
                        'updated_at'  => now(),
                    ]);
            }

            return 'GGN-' . now()->format('dmY') . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        });

        Gangguan::create([
            'id_laporan'        => 'LAP-' . now()->format('Ymdhis') . '-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT),
            'no_tiket'          => $noTiket,
            'ip_address'        => $ipAddress,
            'gardu_induk'       => $validated['unit'],
            'waktu_kejadian'    => now(),
            'status'            => 'on_progress',
            'tahapan'           => 1,
            'jenis_gangguan'    => $validated['kategori'],
            'foto_lokasi'       => null,
            'foto_petugas'      => null,
            'catatan_perbaikan' => $validated['penyebab'],
        ]);

        return redirect()
            ->route('riwayat.index')
            ->with('success', "Data gangguan berhasil dikirim. No. Tiket: {$noTiket}");
    }
}