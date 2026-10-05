<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use Illuminate\Http\Request;

class CostumeController extends Controller
{
    // Browse
    public function index()
    {
        $costumes = Costume::all();

        return view('costumes.index', compact('costumes'));
    }

    // Add - form
    public function create()
    {
        return view('costumes.create');
    }

    // Add - simpan
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kostum' => 'required',
            'karakter' => 'required',
            'kategori' => 'required',
            'ukuran' => 'required',
            'harga_sewa' => 'required|numeric',
            'kondisi' => 'required',
            'stok' => 'required|integer',
        ]);

        Costume::create($data);

        return redirect()->route('costumes.index')
            ->with('success', 'Kostum berhasil ditambahkan!');
    }

    // Read
    public function show(Costume $costume)
    {
        return view('costumes.show', compact('costume'));
    }

    // Edit - form
    public function edit(Costume $costume)
    {
        return view('costumes.edit', compact('costume'));
    }

    // Edit - simpan
    public function update(Request $request, Costume $costume)
    {
        $data = $request->validate([
            'nama_kostum' => 'required',
            'karakter' => 'required',
            'kategori' => 'required',
            'ukuran' => 'required',
            'harga_sewa' => 'required|numeric',
            'kondisi' => 'required',
            'stok' => 'required|integer',
        ]);

        $costume->update($data);

        return redirect()->route('costumes.index')
            ->with('success', 'Kostum berhasil diperbarui!');
    }

    // Delete
    public function destroy(Costume $costume)
    {
        $costume->delete();

        return redirect()->route('costumes.index')
            ->with('success', 'Kostum berhasil dihapus!');
    }
}