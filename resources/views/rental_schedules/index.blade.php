@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Jadwal Penyewaan</h2>

    <a href="{{ route('rental_schedules.create') }}"
       class="bg-purple-600 text-white px-4 py-2 rounded-lg">
        + Tambah Penyewaan
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full">

<thead class="bg-purple-600 text-white">
<tr>
    <th class="p-3">Customer</th>
    <th class="p-3">Kostum</th>
    <th class="p-3">Tanggal Sewa</th>
    <th class="p-3">Tanggal Kembali</th>
    <th class="p-3">Total</th>
    <th class="p-3">Status</th>
    <th class="p-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($rentalSchedules as $rental)

<tr class="border-b">
    <td class="p-3">{{ $rental->customer->nama }}</td>
    <td class="p-3">{{ $rental->costume->nama_kostum }}</td>
    <td class="p-3">{{ $rental->tanggal_sewa->format('d/m/Y') }}</td>
    <td class="p-3">{{ $rental->tanggal_kembali->format('d/m/Y') }}</td>
    <td class="p-3">Rp{{ number_format($rental->total_harga, 0, ',', '.') }}</td>
    <td class="p-3"><x-status-badge :status="$rental->status" /></td>

    <td class="p-3 space-x-2 whitespace-nowrap">
        <a href="{{ route('rental_schedules.show', $rental) }}" class="text-blue-600">Detail</a>
        <a href="{{ route('rental_schedules.edit', $rental) }}" class="text-yellow-600">Edit</a>

        <form action="{{ route('rental_schedules.destroy', $rental) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button class="text-red-600" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
    </td>
</tr>

@empty

<tr>
    <td colspan="7" class="p-6 text-center text-gray-500">Belum ada penyewaan.</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
