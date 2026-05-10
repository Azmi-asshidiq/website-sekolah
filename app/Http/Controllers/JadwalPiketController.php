<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPiket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JadwalPiketController extends Controller
{
    public function index(): View
    {
        $jadwalPiket = JadwalPiket::with(['guru'])
            ->where('is_active', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('id_guru');

        $guru = Guru::all();
        
        return view('jadwal-piket.index', compact('jadwalPiket', 'guru'));
    }

    public function create(): View
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        $guru = Guru::all();
        return view('jadwal-piket.create', compact('guru'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'hari' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'semester' => 'required|string|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|integer|min:2024|max:2030'
        ]);

        JadwalPiket::create([
            'id_guru' => $request->id_guru,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'is_active' => true,
        ]);

        return redirect()->route('jadwal-piket.index')
            ->with('success', 'Jadwal piket berhasil ditambahkan.');
    }

    public function show(JadwalPiket $jadwalPiket): View
    {
        $jadwalPiket->load('guru');
        return view('jadwal-piket.show', compact('jadwalPiket'));
    }

    public function edit(JadwalPiket $jadwalPiket): View
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        $jadwalPiket->load('guru');
        $guru = Guru::all();
        return view('jadwal-piket.edit', compact('jadwalPiket', 'guru'));
    }

    public function update(Request $request, JadwalPiket $jadwalPiket): RedirectResponse
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'hari' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'semester' => 'required|string|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|integer|min:2024|max:2030'
        ]);

        $jadwalPiket->update([
            'id_guru' => $request->id_guru,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('jadwal-piket.index')
            ->with('success', 'Jadwal piket berhasil diperbarui.');
    }

    public function destroy(JadwalPiket $jadwalPiket): RedirectResponse
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $jadwalPiket->delete();
        return redirect()->route('jadwal-piket.index')
            ->with('success', 'Jadwal piket berhasil dihapus.');
    }

    public function getJadwalHariIni(): View
    {
        $hariIni = now()->format('l'); // Monday, Tuesday, etc.
        $jadwalHariIni = JadwalPiket::with(['guru'])
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('semester', $this->getSemester())
                    ->where('tahun_ajaran', date('Y'));
            })
            ->get();

        return view('jadwal-piket.hari-ini', compact('jadwalHariIni'));
    }

    private function getSemester(): string
    {
        $bulan = date('n');
        return ($bulan >= 1 && $bulan <= 6) ? 'Genap' : 'Ganjil';
    }
}
