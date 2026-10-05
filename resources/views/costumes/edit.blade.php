@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Edit Kostum
</h2>

<form action="{{ route('costumes.update', $costume) }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

@csrf
@method('PUT')

<input name="nama_kostum"
       value="{{ $costume->nama_kostum }}"
       class="w-full border p-3 rounded">

<input name="karakter"
       value="{{ $costume->karakter }}"
       class="w-full border p-3 rounded">

<input name="kategori"
       value="{{ $costume->kategori }}"
       class="w-full border p-3 rounded">

<input name="ukuran"
       value="{{ $costume->ukuran }}"
       class="w-full border p-3 rounded">

<input name="harga_sewa"
       type="number"
       value="{{ $costume->harga_sewa }}"
       class="w-full border p-3 rounded">

<input name="kondisi"
       value="{{ $costume->kondisi }}"
       class="w-full border p-3 rounded">

<input name="stok"
       type="number"
       value="{{ $costume->stok }}"
       class="w-full border p-3 rounded">

<button class="bg-yellow-500 text-white px-5 py-3 rounded">
    Update
</button>

</form>

@endsection