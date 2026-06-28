<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? \App\Models\User::first();
        return view('pengaturan', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user() ?? \App\Models\User::first();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'divisi' => 'nullable|string|max:255',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->divisi = $request->divisi;

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        // Ubah password
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil disimpan!');
    }
}