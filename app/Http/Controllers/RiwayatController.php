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
        // Catatan: validasi ini disesuaikan persis dengan field yang benar-benar
        // dikirim oleh form di riwayat-update.blade.php.
        //  - 'status_jaringan' (bukan 'status') menampung nilai DOWN/UP dari kartu status.
        //  - 'tahapan' sekarang 1-6 (Down, Persiapan, Mobilisasi, Eksekusi, Finalisasi, Up).
        //    Field ini adalah tahapan TERKINI tiket (dipakai buat stepper & status kerja).
        //  - 'logs.*.tahapan' BARU: tiap catatan log sekarang bawa tahapan-nya sendiri
        //    (dikirim dari hidden input logs[i][tahapan] di form), diisi otomatis oleh JS
        //    saat user klik salah satu bulatan tahapan di stepper. Kalau kosong (mis. entri
        //    lama sebelum fitur ini ada), fallback ke tahapan tiket saat ini.
        //  - 'logs.*.foto' baru: foto opsional per catatan log.
        $request->validate([
            'status_jaringan'     => 'required|in:DOWN,UP',
            'tahapan'             => 'required|integer|between:1,6',
            'logs'                => 'required|array|min:1',
            'logs.*.tanggal'      => 'required|date',
            'logs.*.deskripsi'    => 'required|min:10',
            'logs.*.tahapan'      => 'nullable|integer|between:1,6',
            'logs.*.foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'no_tiket'            => 'nullable|string|max:100',
            'gardu_induk'         => 'nullable|string|max:255',
            'waktu_kejadian'      => 'nullable|date',
            'catatan_perbaikan'   => 'nullable|string|max:1000',
            'foto_lokasi'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_petugas'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $gangguan = Gangguan::findOrFail($id);

        // ✅ Update status jaringan (DOWN/UP) & tahapan pengerjaan tiket
        $gangguan->status_jaringan = $request->status_jaringan;
        $gangguan->tahapan         = $request->tahapan;

        // ✅ Status kerja tiket mengikuti tahapan secara otomatis:
        //    kalau sudah sampai tahap terakhir ("Up" = 6), tiket dianggap selesai.
        $gangguan->status = $request->tahapan >= 6 ? 'resolved' : 'on_progress';

        // ✅ Update ringkasan insiden (no_tiket, gardu_induk, waktu_kejadian)
        if ($request->filled('no_tiket')) {
            $gangguan->no_tiket = $request->no_tiket;
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
        $gangguan->logs()->delete();

        foreach ($request->logs as $i => $log) {
            $fotoPath = $log['existing_foto'] ?? null;

            if ($request->hasFile("logs.$i.foto")) {
                if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $fotoPath = $request->file("logs.$i.foto")->store('foto_log', 'public');
            }

            GangguanLog::create([
                'gangguan_id' => $gangguan->id,
                'tanggal'     => $log['tanggal'],
                'tahapan'     => $log['tahapan'] ?? $gangguan->tahapan,
                'deskripsi'   => $log['deskripsi'],
                'foto'        => $fotoPath,
            ]);
        }

        return redirect()
            ->route('riwayat.index')
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