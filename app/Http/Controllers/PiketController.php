<?php
// app/Http/Controllers/PiketController.php

namespace App\Http\Controllers;

use App\Models\Piket;
use App\Models\Guru;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function index()
    {
        $piket = Piket::with('guru')->latest()->paginate(10);
        
        // Group by guru for better display
        $jadwalPiket = $piket->groupBy('id_guru');
        
        return view('jadwal-piket.index', compact('piket', 'jadwalPiket'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru = Guru::all();
        return view('piket.create', compact('guru'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'tanggal' => 'required|date'
        ]);

        Piket::create($request->all());

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil ditambahkan.');
    }

    public function edit(Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru = Guru::all();
        return view('piket.edit', compact('piket', 'guru'));
    }

    public function update(Request $request, Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'tanggal' => 'required|date'
        ]);

        $piket->update($request->all());

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil diperbarui.');
    }

    public function show(Piket $piket)
    {
        $piket->load('guru');
        return view('piket.show', compact('piket'));
    }

    public function destroy(Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $piket->delete();

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil dihapus.');
    }

    public function laporan()
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $piket = Piket::with('guru')->latest()->paginate(15);
        $totalPiket = Piket::count();
        $piketBulanIni = Piket::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        
        return view('laporan.piket', compact('piket', 'totalPiket', 'piketBulanIni'));
    }
}
