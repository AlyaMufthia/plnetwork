<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $now   = Carbon::now();

        /* ────────────────────────────────────────────────
         | 1. KARTU RINGKASAN
         |───────────────────────────────────────────────*/

        // Jumlah gangguan dalam 24 jam terakhir (berdasarkan waktu_kejadian)
        $totalPerJam = Gangguan::whereBetween('waktu_kejadian', [
            $now->copy()->subHours(24),
            $now,
        ])->count();

        // Jumlah gangguan hari ini
        $totalHariIni = Gangguan::whereDate('waktu_kejadian', $today)->count();

        // Jumlah gangguan bulan ini
        $totalBulanIni = Gangguan::whereMonth('waktu_kejadian', $now->month)
            ->whereYear('waktu_kejadian', $now->year)
            ->count();


        /* ────────────────────────────────────────────────
         | 2. TABEL REKAP HARIAN (7 hari terakhir)
         |───────────────────────────────────────────────*/

        $rekapHarian = Gangguan::select(
                DB::raw('DATE(waktu_kejadian) as tanggal'),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status_jaringan = 'DOWN' THEN 1 ELSE 0 END) as `down`"),
                DB::raw("SUM(CASE WHEN status_jaringan = 'UP' THEN 1 ELSE 0 END) as up")
            )
            ->where('waktu_kejadian', '>=', $today->copy()->subDays(6))
            ->groupBy('tanggal')
            ->orderByDesc('tanggal')
            ->get();


        /* ────────────────────────────────────────────────
         | 3. TABEL REKAP BULANAN (12 bulan terakhir)
         |───────────────────────────────────────────────*/

        $rekapBulanan = Gangguan::select(
                DB::raw('MONTH(waktu_kejadian) as bulan'),
                DB::raw('YEAR(waktu_kejadian) as tahun'),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status_jaringan = 'DOWN' THEN 1 ELSE 0 END) as `down`"),
                DB::raw("SUM(CASE WHEN status_jaringan = 'UP' THEN 1 ELSE 0 END) as up")
            )
            ->where('waktu_kejadian', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();


        /* ────────────────────────────────────────────────
         | 4. DATA GRAFIK — HARIAN (per jam, hari ini)
         |───────────────────────────────────────────────*/

        $labelHarian = [];
        $dataHarian  = [];

        for ($jam = 0; $jam <= 24; $jam += 2) {
            $labelHarian[] = str_pad($jam, 2, '0', STR_PAD_LEFT) . ':00';

            $dataHarian[] = Gangguan::whereDate('waktu_kejadian', $today)
                ->whereTime('waktu_kejadian', '>=', sprintf('%02d:00:00', $jam))
                ->whereTime('waktu_kejadian', '<', sprintf('%02d:59:59', min($jam + 1, 23)))
                ->where('status_jaringan', 'DOWN')
                ->count();
        }


        /* ────────────────────────────────────────────────
         | 5. DATA GRAFIK — BULANAN (per bulan, tahun berjalan)
         |───────────────────────────────────────────────*/

        $namaBulan = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des',
        ];

        $labelBulanan = $namaBulan;
        $dataBulanan  = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataBulanan[] = Gangguan::whereMonth('waktu_kejadian', $bulan)
                ->whereYear('waktu_kejadian', $now->year)
                ->where('status_jaringan', 'DOWN')
                ->count();
        }


        /* ────────────────────────────────────────────────
         | 6. DATA GRAFIK — TAHUNAN (5 tahun terakhir)
         |───────────────────────────────────────────────*/

        $labelTahunan = [];
        $dataTahunan  = [];

        for ($i = 4; $i >= 0; $i--) {
            $tahun = $now->year - $i;
            $labelTahunan[] = (string) $tahun;

            $dataTahunan[] = Gangguan::whereYear('waktu_kejadian', $tahun)
                ->where('status_jaringan', 'DOWN')
                ->count();
        }


        return view('laporan', compact(
            'totalPerJam',
            'totalHariIni',
            'totalBulanIni',
            'rekapHarian',
            'rekapBulanan',
            'labelHarian',
            'dataHarian',
            'labelBulanan',
            'dataBulanan',
            'labelTahunan',
            'dataTahunan'
        ));
    }

    // ✅ Menyimpan laporan gangguan baru dari form "Input Gangguan"
    //    lalu redirect ke halaman Riwayat.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit'         => ['required', 'string', 'max:255'],
            'status'       => ['required', 'in:UP,DOWN'],
            'lokasi_gardu' => ['nullable', 'string', 'max:255'],
            'kategori'     => ['required', 'string', 'max:100'],
            'penyebab'     => ['required', 'string'],
        ], [
            'unit.required'     => 'Unit / Lokasi Utama wajib dipilih.',
            'status.required'   => 'Status Gangguan wajib dipilih.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'penyebab.required' => 'Penyebab Kendala wajib diisi.',
        ]);

        // Gabungkan "Lokasi Gardu" ke catatan perbaikan karena belum ada
        // kolom khusus untuk itu di tabel gangguan.
        $catatan = $validated['penyebab'];
        if (!empty($validated['lokasi_gardu'])) {
            $catatan = "Lokasi Gardu: {$validated['lokasi_gardu']}\n\n{$catatan}";
        }

        Gangguan::create([
            'id_laporan'        => $this->generateIdLaporan(),
            'no_tiket'          => $this->generateNoTiket(),
            'ip_address'        => null, // form belum mengirim IP unit secara terpisah
            'gardu_induk'       => $validated['unit'],
            'waktu_kejadian'    => now(),
            // 'status' TIDAK diisi di sini — biarkan default DB ('on_progress'),
            // karena kolom ini adalah status PENANGANAN tiket (on_progress/paused/resolved),
            // bukan status jaringan (UP/DOWN).
            'status_jaringan'   => $validated['status'],       // UP / DOWN
            // 'tahapan' TIDAK diisi — biarkan default DB (1), karena kolom ini
            // bertipe tinyint (angka tahap), bukan teks.
            'jenis_gangguan'    => $validated['kategori'],
            'catatan_perbaikan' => $catatan,
        ]);

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Laporan gangguan berhasil dikirim.');
    }

    // Generate nomor tiket unik, contoh: TRB-20260707-4821
    private function generateNoTiket(): string
    {
        do {
            $noTiket = 'TRB-' . now()->format('Ymd') . '-' . random_int(1000, 9999);
        } while (Gangguan::where('no_tiket', $noTiket)->exists());

        return $noTiket;
    }

    // Generate id_laporan unik (kolom ini varchar UNIQUE, bukan foreign key),
    // contoh: LAP-20260707-4821
    private function generateIdLaporan(): string
    {
        do {
            $idLaporan = 'LAP-' . now()->format('Ymd') . '-' . random_int(1000, 9999);
        } while (Gangguan::where('id_laporan', $idLaporan)->exists());

        return $idLaporan;
    }
}