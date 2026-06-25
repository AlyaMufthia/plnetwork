<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiwayatController;

Route::get("/register",   fn() => view("register"))->name("register");
Route::get("/login",      fn() => view("login"))->name("login");
Route::get("/dashboard",  fn() => view("dashboard"))->name("dashboard");
Route::get("/laporan",    fn() => view("laporan"))->name("laporan.index");
Route::get("/pengaturan", fn() => view("pengaturan"))->name("pengaturan.index");

Route::get("/riwayat",             [RiwayatController::class, "index"])->name("riwayat.index");
Route::get("/riwayat/{id}",        [RiwayatController::class, "show"])->name("riwayat.show");
Route::get("/riwayat/{id}/update", [RiwayatController::class, "edit"])->name("riwayat.edit");
Route::put("/riwayat/{id}",        [RiwayatController::class, "update"])->name("riwayat.update");
