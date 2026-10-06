@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Pesan Kostum &amp; Aksesoris</h2>

<form action="{{ route('my_rentals.store') }}" method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4 max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block text-sm">Tanggal sewa
            <input type="date" name="tanggal_sewa" value="{{ old('tanggal_sewa') }}"
                   min="{{ now()->toDateString() }}" class="w-full border p-3 rounded mt-1" required>
        </label>

        <label class="block text-sm">Tanggal kembali
            <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}"
                   min="{{ now()->addDay()->toDateString() }}" class="w-full border p-3 rounded mt-1" required>
        </label>
    </div>

    @include('rental_schedules._items')

    <p class="text-sm text-gray-500">
        Total = harga sewa × jumlah × jumlah hari, dihitung otomatis. Pesanan menunggu persetujuan admin
        dan stok langsung dipesankan untuk Anda.
    </p>

    <button class="bg-purple-600 text-white px-5 py-3 rounded">Kirim pesanan</button>
    <a href="{{ route('costumes.index') }}" class="px-3 text-gray-600">Batal</a>
</form>

@endsection
