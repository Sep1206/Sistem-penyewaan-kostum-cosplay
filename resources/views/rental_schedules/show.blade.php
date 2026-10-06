@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow space-y-1">

    <h2 class="text-2xl font-bold mb-6">Detail Penyewaan</h2>

    <p><b>Customer:</b> {{ $rental->customer->nama }} ({{ $rental->customer->no_hp }})</p>
    <p><b>Tanggal sewa:</b> {{ $rental->tanggal_sewa->format('d/m/Y') }}</p>
    <p><b>Tanggal kembali:</b> {{ $rental->tanggal_kembali->format('d/m/Y') }}</p>
    <p><b>Status:</b> <x-status-badge :status="$rental->status" /></p>

    <div class="border rounded overflow-x-auto mt-4">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Jenis</th>
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2 text-left">Harga/hari</th>
                    <th class="p-2 text-left">Jumlah</th>
                    <th class="p-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @foreach($rental->items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->jenis }}</td>
                    <td class="p-2">{{ $item->nama }}</td>
                    <td class="p-2">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="p-2">{{ $item->jumlah }}</td>
                    <td class="p-2">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-4 text-lg"><b>Total:</b> Rp{{ number_format($rental->total_harga, 0, ',', '.') }}</p>

    <a href="{{ route('rental_schedules.index') }}"
       class="inline-block mt-5 bg-gray-600 text-white px-4 py-2 rounded">
        Kembali
    </a>

</div>

@endsection
