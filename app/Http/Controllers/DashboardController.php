<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUp   = Gangguan::where('status_jaringan', 'UP')->count();
        $totalDown = Gangguan::where('status_jaringan', 'DOWN')->count();
        $total     = $totalUp + $totalDown;

        // 3 laporan UP terbaru
        $rekapanUp = Gangguan::where('status_jaringan', 'UP')
                        ->latest('waktu_kejadian')
                        ->take(3)
                        ->get();

        // Rekapan penyebab gangguan dari DB
        $penyebabStats = Gangguan::selectRaw('jenis_gangguan, status_jaringan, COUNT(*) as frekuensi')
                        ->groupBy('jenis_gangguan', 'status_jaringan')
                        ->orderByDesc('frekuensi')
                        ->get();

        // Chart default (harian) untuk load pertama kali
        $chartData = $this->getChartData('harian');

        return view('dashboard', compact(
            'totalUp', 'totalDown', 'total', 'rekapanUp', 'penyebabStats', 'chartData'
        ));
    }

    // ✅ Endpoint AJAX — dipanggil saat filter periode diganti (Harian/Bulanan/Tahunan)
    public function chartData(Request $request)
    {
        $period = $request->get('period', 'harian');
        return response()->json($this->getChartData($period));
    }

    // ✅ Endpoint AJAX — dipanggil polling tiap beberapa detik untuk refresh data dashboard
    public function statusData()
    {
        $totalUp   = Gangguan::where('status_jaringan', 'UP')->count();
        $totalDown = Gangguan::where('status_jaringan', 'DOWN')->count();
        $total     = $totalUp + $totalDown;

        $rekapanUp = Gangguan::where('status_jaringan', 'UP')
                        ->latest('waktu_kejadian')
                        ->take(3)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id'       => $item->id,
                                'gardu'    => $item->gardu_induk,
                                'ip'       => $item->ip_address ?? '-',
                                'penyebab' => $item->jenis_gangguan ?? '-',
                                'waktu'    => \Carbon\Carbon::parse($item->waktu_kejadian)->diffForHumans(),
                                'url'      => route('riwayat.show', $item->id),
                            ];
                        });

        $penyebabStats = Gangguan::selectRaw('jenis_gangguan, status_jaringan, COUNT(*) as frekuensi')
                        ->groupBy('jenis_gangguan', 'status_jaringan')
                        ->orderByDesc('frekuensi')
                        ->get();

        return response()->json([
            'totalUp'       => $totalUp,
            'totalDown'     => $totalDown,
            'total'         => $total,
            'rekapanUp'     => $rekapanUp,
            'penyebabStats' => $penyebabStats,
            'last_updated'  => now()->format('H:i'),
        ]);
    }

    // ✅ Logic query per periode, terpusat di satu fungsi (hanya 1 query per periode)
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
            $data   = array_map(fn($d) => $rows[$d] ?? 0, $labels);

        } elseif ($period === 'tahunan') {
            $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

            $rows = Gangguan::where('status_jaringan', 'DOWN')
                ->whereYear('waktu_kejadian', now()->year)
                ->selectRaw('MONTH(waktu_kejadian) as m, COUNT(*) as c')
                ->groupBy('m')
                ->pluck('c', 'm');

            $labels = $namaBulan;
            $data   = [];
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
            $data   = [];
            for ($h = 0; $h <= 24; $h += 2) {
                $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                $data[]   = $rows[$h] ?? 0;
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }
}