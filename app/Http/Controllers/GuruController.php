<?php
// app/Http/Controllers/GuruController.php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::latest()->paginate(10);
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip|max:20',
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:50',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'email' => 'nullable|email|max:100|unique:guru,email',
            'telepon' => 'nullable|string|max:15'
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        // Allow admin to edit any teacher, or teacher to edit their own data
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized access');
        }
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        // Allow admin to update any teacher, or teacher to update their own data
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $guru->id_guru . ',id_guru|max:20',
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:50',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'email' => 'nullable|email|max:100|unique:guru,email,' . $guru->id_guru . ',id_guru',
            'telepon' => 'nullable|string|max:15'
        ]);

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function laporan()
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $guru = Guru::latest()->paginate(15);
        $totalGuru = Guru::count();
        $totalPerJabatan = Guru::selectRaw('jabatan, COUNT(*) as total')
            ->groupBy('jabatan')
            ->get();
        
        return view('laporan.guru', compact('guru', 'totalGuru', 'totalPerJabatan'));
    }
}
