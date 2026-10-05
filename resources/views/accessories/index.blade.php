@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Data Aksesoris</h2>

    @if(auth()->user()->isAdmin())
        <a href="{{ route('accessories.create') }}"
           class="bg-purple-600 text-white px-4 py-2 rounded-lg">
            + Tambah Aksesoris
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full">

<thead class="bg-purple-600 text-white">
<tr>
    <th class="p-3">Nama Aksesoris</th>
    <th class="p-3">Kategori</th>
    <th class="p-3">Harga Sewa</th>
    <th class="p-3">Stok</th>
    <th class="p-3">Kondisi</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($accessories as $accessory)

<tr class="border-b">
    <td class="p-3">{{ $accessory->nama_aksesoris }}</td>
    <td class="p-3">{{ $accessory->kategori }}</td>
    <td class="p-3">Rp{{ number_format($accessory->harga_sewa, 0, ',', '.') }}</td>
    <td class="p-3">{{ $accessory->stok }}</td>
    <td class="p-3">{{ $accessory->kondisi }}</td>

    <td class="p-3 space-x-2 whitespace-nowrap">

        <a href="{{ route('accessories.show', $accessory) }}" class="text-blue-600">Detail</a>

        @if(auth()->user()->isAdmin())

            <a href="{{ route('accessories.edit', $accessory) }}" class="text-yellow-600">Edit</a>

            <form action="{{ route('accessories.destroy', $accessory) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600" onclick="return confirm('Hapus data ini?')">Hapus</button>
            </form>

        @endif

    </td>
</tr>

@empty

<tr>
    <td colspan="6" class="p-6 text-center text-gray-500">Belum ada data aksesoris.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
