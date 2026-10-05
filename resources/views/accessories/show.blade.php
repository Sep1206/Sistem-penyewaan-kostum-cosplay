@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">
    Detail Aksesoris
</h2>

<p><b>Nama:</b> {{ $accessory->nama_aksesoris }}</p>
<p><b>Kategori:</b> {{ $accessory->kategori }}</p>
<p><b>Harga:</b> Rp{{ number_format($accessory->harga_sewa, 0, ',', '.') }}</p>
<p><b>Stok:</b> {{ $accessory->stok }}</p>
<p><b>Kondisi:</b> {{ $accessory->kondisi }}</p>
<p><b>Deskripsi:</b> {{ $accessory->deskripsi }}</p>

<a href="{{ route('accessories.index') }}"
   class="inline-block mt-5 bg-gray-600 text-white px-4 py-2 rounded">
    Kembali
</a>

</div>

@endsection