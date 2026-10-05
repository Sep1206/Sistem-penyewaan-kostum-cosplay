@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Edit Aksesoris
</h2>

<form action="{{ route('accessories.update', $accessory) }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

@csrf
@method('PUT')

<input name="nama_aksesoris"
       value="{{ $accessory->nama_aksesoris }}"
       class="w-full border p-3 rounded">

<input name="kategori"
       value="{{ $accessory->kategori }}"
       class="w-full border p-3 rounded">

<input name="harga_sewa"
       type="number"
       value="{{ $accessory->harga_sewa }}"
       class="w-full border p-3 rounded">

<input name="stok"
       type="number"
       value="{{ $accessory->stok }}"
       class="w-full border p-3 rounded">

<input name="kondisi"
       value="{{ $accessory->kondisi }}"
       class="w-full border p-3 rounded">

<textarea name="deskripsi"
          class="w-full border p-3 rounded">{{ $accessory->deskripsi }}</textarea>

<button class="bg-yellow-500 text-white px-5 py-3 rounded">
    Update
</button>

</form>

@endsection