<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    public function index(): View
    {
        $pelanggaran = Pelanggaran::with(['siswa', 'guru'])
            ->latest()
            ->paginate(10);

        return view('pelanggaran.index', compact('pelanggaran'));
    }

    public function create(): View
    {
        $siswa = Siswa::all();
        return view('pelanggaran.create', compact('siswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'tanggal' => 'required|date',
            'jenis_pelanggaran' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'sanksi' => 'nullable|string',
            'poin' => 'required|integer|min:0|max:100'
        ]);

        Pelanggaran::create([
            'id_siswa' => $request->id_siswa,
            'id_guru' => null, // Will be set by the system or can be updated later
            'tanggal' => $request->tanggal,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'keterangan' => $request->keterangan,
            'sanksi' => $request->sanksi,
            'poin' => $request->poin,
        ]);

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil ditambahkan');
    }

    public function show(Pelanggaran $pelanggaran): View
    {
        $pelanggaran->load(['siswa', 'guru']);
        return view('pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran): View
    {
        $pelanggaran->load(['siswa', 'guru']);
        $siswa = Siswa::all();
        return view('pelanggaran.edit', compact('pelanggaran', 'siswa'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran): RedirectResponse
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'tanggal' => 'required|date',
            'jenis_pelanggaran' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'sanksi' => 'nullable|string',
            'poin' => 'required|integer|min:0|max:100'
        ]);

        $pelanggaran->update([
            'id_siswa' => $request->id_siswa,
            'id_guru' => $pelanggaran->id_guru, // Keep existing guru assignment
            'tanggal' => $request->tanggal,
            'jenis_pelanggaran' => $request->jenis_pelanggaran,
            'keterangan' => $request->keterangan,
            'sanksi' => $request->sanksi,
            'poin' => $request->poin,
        ]);

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran): RedirectResponse
    {
        $pelanggaran->delete();
        return redirect()->route('pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus');
    }

    public function rekap(): View
    {
        $rekap = Pelanggaran::with(['siswa'])
            ->selectRaw('
                pelanggaran.id_siswa,
                COUNT(*) as jumlah_pelanggaran,
                SUM(pelanggaran.poin) as total_poin
            ')
            ->groupBy('pelanggaran.id_siswa')
            ->orderBy('total_poin', 'desc')
            ->get();

        return view('pelanggaran.rekap', compact('rekap'));
    }

    public function laporan(): View
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $pelanggaran = Pelanggaran::with(['siswa', 'guru'])->latest()->paginate(15);
        $totalPelanggaran = Pelanggaran::count();
        $pelanggaranBulanIni = Pelanggaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();
        $totalPoin = Pelanggaran::sum('poin');
        $rerataPoin = Pelanggaran::avg('poin');
        
        return view('laporan.pelanggaran', compact('pelanggaran', 'totalPelanggaran', 'pelanggaranBulanIni', 'totalPoin', 'rerataPoin'));
    }
}
