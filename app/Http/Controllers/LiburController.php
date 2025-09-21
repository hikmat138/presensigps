<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiburNasional;

class LiburController extends Controller
{
    /**
     * Tampilkan daftar libur nasional
     */
    public function index()
    {
        $libur = LiburNasional::orderBy('tanggal','asc')->get();
        return view('jadwal.index', compact('libur'));
    }

    /**
     * Simpan data libur baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:100'
        ]);

        LiburNasional::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Libur berhasil ditambahkan.');
    }

    /**
     * Hapus data libur
     */
    public function destroy($id)
    {
        $libur = LiburNasional::findOrFail($id);
        $libur->delete();

        return back()->with('success', 'Libur berhasil dihapus.');
    }
}
