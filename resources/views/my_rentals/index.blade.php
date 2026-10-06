@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Pesanan Saya</h2>

    <a href="{{ route('my_rentals.create') }}"
       class="bg-purple-600 text-white px-4 py-2 rounded-lg">
        + Pesan Kostum / Aksesoris
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full">

<thead class="bg-purple-600 text-white">
<tr>
    <th class="p-3">Item</th>
    <th class="p-3">Tanggal Sewa</th>
    <th class="p-3">Tanggal Kembali</th>
    <th class="p-3">Total</th>
    <th class="p-3">Status</th>
</tr>
</thead>

<tbody>

@forelse($rentals as $rental)

<tr class="border-b">
    <td class="p-3">
        @foreach($rental->items as $item)
            <div>{{ $item->nama }} <span class="text-gray-500">×{{ $item->jumlah }}</span></div>
        @endforeach
    </td>
    <td class="p-3">{{ $rental->tanggal_sewa->format('d/m/Y') }}</td>
    <td class="p-3">{{ $rental->tanggal_kembali->format('d/m/Y') }}</td>
    <td class="p-3">Rp{{ number_format($rental->total_harga, 0, ',', '.') }}</td>
    <td class="p-3"><x-status-badge :status="$rental->status" /></td>
</tr>

@empty

<tr>
    <td colspan="5" class="p-6 text-center text-gray-500">
        Belum ada pesanan. Tekan "Pesan Kostum / Aksesoris" untuk mulai.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
