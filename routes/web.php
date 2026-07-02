<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;

Route::get('/register',   fn() => view('register'))->name('register');
Route::get('/login',      fn() => view('login'))->name('login');
Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
Route::get('/laporan',    fn() => view('laporan'))->name('laporan.index');
Route::post('/laporan',   [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
Route::post('/pengaturan',[PengaturanController::class, 'update'])->name('pengaturan.update');
Route::get('/dashboard/chart-data',  [DashboardController::class, 'chartData'])->name('dashboard.chart-data');
Route::get('/dashboard/status-data', [DashboardController::class, 'statusData'])->name('dashboard.status-data');

// Riwayat
Route::get('/riwayat',             [RiwayatController::class, 'index'])->name('riwayat.index');
Route::get('/riwayat/ekspor-pdf',  [RiwayatController::class, 'eksporPdf'])->name('riwayat.eksporPdf');
Route::get('/riwayat/ekspor-csv',  [RiwayatController::class, 'eksporCsv'])->name('riwayat.eksporCsv');
Route::get('/riwayat/ekspor-excel', [RiwayatController::class, 'eksporExcel'])->name('riwayat.eksporExcel');
Route::get('/riwayat/{id}',        [RiwayatController::class, 'show'])->name('riwayat.show');
Route::get('/riwayat/{id}/update', [RiwayatController::class, 'edit'])->name('riwayat.edit');
Route::put('/riwayat/{id}',        [RiwayatController::class, 'update'])->name('riwayat.update');