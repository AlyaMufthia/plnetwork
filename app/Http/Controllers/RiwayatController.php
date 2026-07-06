<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use App\Models\GangguanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RiwayatExport;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatController extends Controller
{
    /**
     * Query dasar yang dipakai bareng oleh index, eksporPdf, dan eksporCsv
     * supaya filter status & pencarian selalu konsisten di ketiganya.
     */
    protected function filteredQuery(Request $request)
    {
        $query = Gangguan::query();

        if ($request->filled('status')) {
            $query->where('status_jaringan', $request->status);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('gardu_induk', 'like', "%{$cari}%")
                  ->orWhere('id_laporan', 'like', "%{$cari}%");
            });
        }

        return $query->latest();
    }

    public function index(Request $request)
    {
        $gangguans = $this->filteredQuery($request)->paginate(20)->appends($request->query());

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
            'catatan_perbaikan'   => 'nullable|string|max:1000', 
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

    /**
     * Ekspor PDF — route: /riwayat/ekspor-pdf
     */
    public function eksporPdf(Request $request)
    {
        $data = $this->filteredQuery($request)->get();

        $pdf = Pdf::loadView('exports.riwayat-pdf', ['data' => $data]);

        return $pdf->download('riwayat-gangguan-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Ekspor CSV — route: /riwayat/ekspor-csv
     */
    public function eksporCsv(Request $request)
    {
        $data = $this->filteredQuery($request)->get();

        $filename = 'riwayat-gangguan-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // BOM supaya karakter dibaca benar saat dibuka di Excel
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, ['No. Tiket', 'Unit', 'Status', 'Kategori', 'Penyebab Kendala', 'Tanggal']);

            foreach ($data as $row) {
            fputcsv($file, [
            $row->no_tiket ?? '-',
            $row->gardu_induk,
            $row->status_jaringan,
            $row->jenis_gangguan ?? '-',
            $row->catatan_perbaikan ?? '-',
            \Carbon\Carbon::parse($row->waktu_kejadian)->format('d-m-Y'),
            ]);
        }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor Excel — route: /riwayat/ekspor-excel
     */
    public function eksporExcel(Request $request)
    {
        $data = $this->filteredQuery($request)->get();

        $filename = 'riwayat-gangguan-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new RiwayatExport($data), $filename);
    }
}