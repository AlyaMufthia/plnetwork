<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use App\Models\GangguanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatController extends Controller
{
    public function index()
    {
        $gangguans = Gangguan::latest()->paginate(20);
        return view('riwayat', compact('gangguans'));
    }

    public function show($id)
    {
        $gangguan = Gangguan::with('logs')->findOrFail($id);
        return view('riwayat-detail', compact('gangguan'));
    }

    public function edit($id)
    {
        $gangguan = Gangguan::with('logs')->findOrFail($id);
        return view('riwayat-update', compact('gangguan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status'              => 'required|in:on_progress,paused,resolved',
            'tahapan'             => 'required|integer|between:1,4',
            'logs'                => 'required|array|min:1',
            'logs.*.tanggal'      => 'required|date',
            'logs.*.tahapan'      => 'required|integer|between:1,4',
            'logs.*.deskripsi'    => 'required|min:10',
            'catatan_perbaikan'   => 'nullable|string|max:1000', // ✅ Baru
            'foto_lokasi'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_petugas'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $gangguan = Gangguan::findOrFail($id);

        // ✅ Update status & tahapan
        $gangguan->status  = $request->status;
        $gangguan->tahapan = $request->tahapan;

        // ✅ Update ringkasan insiden (id_laporan, gardu_induk, waktu_kejadian)
        if ($request->filled('id_laporan')) {
            $gangguan->id_laporan = $request->id_laporan;
        }
        if ($request->filled('gardu_induk')) {
            $gangguan->gardu_induk = $request->gardu_induk;
        }
        if ($request->filled('waktu_kejadian')) {
            $gangguan->waktu_kejadian = $request->waktu_kejadian;
        }

        // ✅ Update catatan perbaikan (boleh kosong untuk hapus catatan)
        $gangguan->catatan_perbaikan = $request->input('catatan_perbaikan');

        // ✅ Upload foto_lokasi — hapus lama dulu kalau ada yang baru
        if ($request->hasFile('foto_lokasi')) {
            if ($gangguan->foto_lokasi && Storage::disk('public')->exists($gangguan->foto_lokasi)) {
                Storage::disk('public')->delete($gangguan->foto_lokasi);
            }
            $gangguan->foto_lokasi = $request->file('foto_lokasi')
                ->store('foto_gangguan', 'public');
        }

        // ✅ Upload foto_petugas — hapus lama dulu kalau ada yang baru
        if ($request->hasFile('foto_petugas')) {
            if ($gangguan->foto_petugas && Storage::disk('public')->exists($gangguan->foto_petugas)) {
                Storage::disk('public')->delete($gangguan->foto_petugas);
            }
            $gangguan->foto_petugas = $request->file('foto_petugas')
                ->store('foto_gangguan', 'public');
        }

        $gangguan->save();

        // ✅ Hapus semua log lama, replace dengan yang baru
        $gangguan->logs()->delete();

        foreach ($request->logs as $log) {
            GangguanLog::create([
                'gangguan_id' => $gangguan->id,
                'tanggal'     => $log['tanggal'],
                'tahapan'     => $log['tahapan'],
                'deskripsi'   => $log['deskripsi'],
            ]);
        }

        return redirect()
            ->route('riwayat.show', $gangguan->id)
            ->with('success', 'Perubahan berhasil disimpan!');
    }
}