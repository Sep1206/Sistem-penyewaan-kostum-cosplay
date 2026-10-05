@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow space-y-1">

    <h2 class="text-2xl font-bold mb-6">Detail Penyewaan</h2>

    <p><b>Customer:</b> {{ $rental->customer->nama }} ({{ $rental->customer->no_hp }})</p>
    <p><b>Kostum:</b> {{ $rental->costume->nama_kostum }} - ukuran {{ $rental->costume->ukuran }}</p>
    <p><b>Tanggal sewa:</b> {{ $rental->tanggal_sewa->format('d/m/Y') }}</p>
    <p><b>Tanggal kembali:</b> {{ $rental->tanggal_kembali->format('d/m/Y') }}</p>
    <p><b>Total:</b> Rp{{ number_format($rental->total_harga, 0, ',', '.') }}</p>
    <p><b>Status:</b> <x-status-badge :status="$rental->status" /></p>

    <a href="{{ route('rental_schedules.index') }}"
       class="inline-block mt-5 bg-gray-600 text-white px-4 py-2 rounded">
        Kembali
    </a>

</div>

@endsection
