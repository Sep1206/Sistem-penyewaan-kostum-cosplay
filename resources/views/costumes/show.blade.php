@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">
    Detail Kostum
</h2>

<p><b>Nama Kostum:</b> {{ $costume->nama_kostum }}</p>
<p><b>Karakter:</b> {{ $costume->karakter }}</p>
<p><b>Kategori:</b> {{ $costume->kategori }}</p>
<p><b>Ukuran:</b> {{ $costume->ukuran }}</p>

<p>
    <b>Harga Sewa:</b>
    Rp{{ number_format($costume->harga_sewa, 0, ',', '.') }}
</p>

<p><b>Kondisi:</b> {{ $costume->kondisi }}</p>
<p><b>Stok:</b> {{ $costume->stok }}</p>

<a href="{{ route('costumes.index') }}"
   class="inline-block mt-5 bg-gray-600 text-white px-4 py-2 rounded">
    Kembali
</a>

</div>

@endsection