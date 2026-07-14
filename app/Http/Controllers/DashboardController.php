<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUp = Gangguan::where('status_jaringan', 'UP')->count();
        $totalDown = Gangguan::where('status_jaringan', 'DOWN')->count();
        $total = $totalUp + $totalDown;

        // 3 laporan UP terbaru
        $rekapanUp = Gangguan::where('status_jaringan', 'UP')
            ->latest('waktu_kejadian')
            ->take(3)
            ->get();

        // Semua unit yang pernah DOWN, diurut dari paling sering (bisa discroll di view)
        $rekapanDown = $this->getRekapanDown();

        // Rekapan penyebab gangguan dari DB
        $penyebabStats = Gangguan::selectRaw('jenis_gangguan, status_jaringan, COUNT(*) as frekuensi')
            ->groupBy('jenis_gangguan', 'status_jaringan')
            ->orderByDesc('frekuensi')
            ->get();

        // Chart default (harian) untuk load pertama kali — sekarang dipakai di halaman Laporan
        $chartData = $this->getChartData('harian');

        return view('dashboard', compact(
            'totalUp',
            'totalDown',
            'total',
            'rekapanUp',
            'rekapanDown',
            'penyebabStats',
            'chartData'
        ));
    }

    // Endpoint AJAX — dipanggil saat filter periode diganti (Harian/Bulanan/Tahunan) di halaman Laporan
    public function chartData(Request $request)
    {
        $period = $request->get('period', 'harian');
        return response()->json($this->getChartData($period));
    }

    // Endpoint AJAX — dipanggil polling tiap beberapa detik untuk refresh data dashboard
    public function statusData()
    {
        $totalUp = Gangguan::where('status_jaringan', 'UP')->count();
        $totalDown = Gangguan::where('status_jaringan', 'DOWN')->count();
        $total = $totalUp + $totalDown;

        $rekapanUp = Gangguan::where('status_jaringan', 'UP')
            ->latest('waktu_kejadian')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'gardu' => $item->gardu_induk,
                    'ip' => $item->ip_address ?? '-',
                    'penyebab' => $item->jenis_gangguan ?? '-',
                    'waktu' => \Carbon\Carbon::parse($item->waktu_kejadian)->diffForHumans(),
                    'url' => route('riwayat.show', $item->id),
                ];
            });

        $rekapanDown = $this->getRekapanDown()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'gardu' => $item->gardu_induk,
                    'penyebab' => $item->jenis_gangguan ?? '-',
                    'frekuensi' => $item->frekuensi,
                    'waktu' => $item->waktu_kejadian
                        ? \Carbon\Carbon::parse($item->waktu_kejadian)->diffForHumans()
                        : '-',
                    'url' => $item->id ? route('riwayat.show', $item->id) : '#',
                ];
            });

        $penyebabStats = Gangguan::selectRaw('jenis_gangguan, status_jaringan, COUNT(*) as frekuensi')
            ->groupBy('jenis_gangguan', 'status_jaringan')
            ->orderByDesc('frekuensi')
            ->get();

        return response()->json([
            'totalUp' => $totalUp,
            'totalDown' => $totalDown,
            'total' => $total,
            'rekapanUp' => $rekapanUp,
            'rekapanDown' => $rekapanDown,
            'penyebabStats' => $penyebabStats,
            'last_updated' => now()->format('H:i'),
        ]);
    }

    //    SEMUA unit (gardu) yang pernah mengalami DOWN, diurut dari paling sering,
    //    lengkap dengan kategori & waktu kejadian TERAKHIR untuk masing-masing unit.
    //    Tidak lagi dibatasi top 3 — ditampilkan semua dan bisa discroll di view.
    private function getRekapanDown()
    {
        // 1) Hitung frekuensi DOWN per unit, urut dari yang paling sering
        $topUnit = Gangguan::where('status_jaringan', 'DOWN')
            ->selectRaw('gardu_induk, COUNT(*) as frekuensi')
            ->groupBy('gardu_induk')
            ->orderByDesc('frekuensi')
            ->get();

        // 2) Untuk tiap unit, ambil kejadian DOWN yang paling baru (kategori & waktu)
        return $topUnit->map(function ($unit) {
            $latest = Gangguan::where('status_jaringan', 'DOWN')
                ->where('gardu_induk', $unit->gardu_induk)
                ->latest('waktu_kejadian')
                ->first();

            return (object) [
                'id' => $latest->id ?? null,
                'gardu_induk' => $unit->gardu_induk,
                'frekuensi' => $unit->frekuensi,
                'jenis_gangguan' => $latest->jenis_gangguan ?? null,
                'waktu_kejadian' => $latest->waktu_kejadian ?? null,
            ];
        });
    }

    // Logic query per periode, terpusat di satu fungsi (hanya 1 query per periode)
    // Dipakai oleh halaman Laporan untuk grafik "Pemantauan Alarm DOWN"
    private function getChartData(string $period): array
    {
        if ($period === 'bulanan') {
            $daysInMonth = now()->daysInMonth;

            $rows = Gangguan::where('status_jaringan', 'DOWN')
                ->whereYear('waktu_kejadian', now()->year)
                ->whereMonth('waktu_kejadian', now()->month)
                ->selectRaw('DAY(waktu_kejadian) as d, COUNT(*) as c')
                ->groupBy('d')
                ->pluck('c', 'd');

            $labels = range(1, $daysInMonth);
            $data = array_map(fn($d) => $rows[$d] ?? 0, $labels);

        } elseif ($period === 'tahunan') {
            $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            $rows = Gangguan::where('status_jaringan', 'DOWN')
                ->whereYear('waktu_kejadian', now()->year)
                ->selectRaw('MONTH(waktu_kejadian) as m, COUNT(*) as c')
                ->groupBy('m')
                ->pluck('c', 'm');

            $labels = $namaBulan;
            $data = [];
            for ($m = 1; $m <= 12; $m++) {
                $data[] = $rows[$m] ?? 0;
            }

        } else { // harian (default)
            $rows = Gangguan::where('status_jaringan', 'DOWN')
                ->whereDate('waktu_kejadian', today())
                ->selectRaw('HOUR(waktu_kejadian) as h, COUNT(*) as c')
                ->groupBy('h')
                ->pluck('c', 'h');

            $labels = [];
            $data = [];
            for ($h = 0; $h <= 24; $h += 2) {
                $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                $data[] = $rows[$h] ?? 0;
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }
}