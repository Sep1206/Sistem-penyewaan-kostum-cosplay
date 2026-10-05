<?php

namespace App\Http\Controllers;

use App\Models\Accessories;
use Illuminate\Http\Request;

class AccessoriesController extends Controller
{
    public function index()
    {
        $accessories = Accessories::all();
        return view('accessories.index', compact('accessories'));
    }

    public function create()
    {
        return view('accessories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aksesoris' => 'required',
            'kategori' => 'required',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|integer',
            'kondisi' => 'required',
            'deskripsi' => 'nullable',
        ]);

        Accessories::create($data);

        return redirect()->route('accessories.index')
            ->with('success', 'Aksesoris berhasil ditambahkan!');
    }

    public function show(Accessories $accessory)
    {
        return view('accessories.show', compact('accessory'));
    }

    public function edit(Accessories $accessory)
    {
        return view('accessories.edit', compact('accessory'));
    }

    public function update(Request $request, Accessories $accessory)
    {
        $data = $request->validate([
            'nama_aksesoris' => 'required',
            'kategori' => 'required',
            'harga_sewa' => 'required|numeric',
            'stok' => 'required|integer',
            'kondisi' => 'required',
            'deskripsi' => 'nullable',
        ]);

        $accessory->update($data);

        return redirect()->route('accessories.index')
            ->with('success', 'Aksesoris berhasil diperbarui!');
    }

    public function destroy(Accessories $accessory)
    {
        $accessory->delete();

        return redirect()->route('accessories.index')
            ->with('success', 'Aksesoris berhasil dihapus!');
    }
}