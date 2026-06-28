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

        // Data chart DOWN per 2 jam (13 titik)
        $chartDown = [];
        for ($h = 0; $h <= 24; $h += 2) {
            $count = Gangguan::where('status_jaringan', 'DOWN')
                ->whereDate('waktu_kejadian', today())
                ->whereRaw('HOUR(waktu_kejadian) = ?', [$h])
                ->count();
            $chartDown[] = $count;
        }

        return view('dashboard', compact(
            'totalUp', 'totalDown', 'total', 'rekapanUp', 'penyebabStats', 'chartDown'
        ));
    }
}