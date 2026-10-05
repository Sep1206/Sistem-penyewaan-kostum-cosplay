@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Data Kostum</h2>

    @if(auth()->user()->isAdmin())
        <a href="{{ route('costumes.create') }}"
           class="bg-purple-600 text-white px-4 py-2 rounded-lg">
            + Tambah Kostum
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
    <th class="p-3">Nama Kostum</th>
    <th class="p-3">Karakter</th>
    <th class="p-3">Kategori</th>
    <th class="p-3">Ukuran</th>
    <th class="p-3">Harga Sewa</th>
    <th class="p-3">Kondisi</th>
    <th class="p-3">Stok</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($costumes as $costume)

<tr class="border-b">
    <td class="p-3">{{ $costume->nama_kostum }}</td>
    <td class="p-3">{{ $costume->karakter }}</td>
    <td class="p-3">{{ $costume->kategori }}</td>
    <td class="p-3">{{ $costume->ukuran }}</td>
    <td class="p-3">Rp{{ number_format($costume->harga_sewa, 0, ',', '.') }}</td>
    <td class="p-3">{{ $costume->kondisi }}</td>
    <td class="p-3">{{ $costume->stok }}</td>

    <td class="p-3 space-x-2 whitespace-nowrap">

        <a href="{{ route('costumes.show', $costume) }}" class="text-blue-600">Detail</a>

        @if(auth()->user()->isAdmin())

            <a href="{{ route('costumes.edit', $costume) }}" class="text-yellow-600">Edit</a>

            <form action="{{ route('costumes.destroy', $costume) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600" onclick="return confirm('Hapus data ini?')">Hapus</button>
            </form>

        @elseif($costume->stok > 0)

            <a href="{{ route('my_rentals.create', ['costume_id' => $costume->id]) }}"
               class="text-purple-700 font-semibold">Pesan</a>

        @else

            <span class="text-gray-400">Stok habis</span>

        @endif

    </td>
</tr>

@empty

<tr>
    <td colspan="8" class="p-6 text-center text-gray-500">Belum ada data kostum.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
