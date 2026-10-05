@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Tambah Aksesoris
</h2>

<form action="{{ route('accessories.store') }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

@csrf

<input name="nama_aksesoris"
       placeholder="Nama Aksesoris"
       class="w-full border p-3 rounded">

<input name="kategori"
       placeholder="Kategori"
       class="w-full border p-3 rounded">

<input name="harga_sewa"
       type="number"
       placeholder="Harga Sewa"
       class="w-full border p-3 rounded">

<input name="stok"
       type="number"
       placeholder="Stok"
       class="w-full border p-3 rounded">

<input name="kondisi"
       placeholder="Kondisi"
       class="w-full border p-3 rounded">

<textarea name="deskripsi"
          placeholder="Deskripsi"
          class="w-full border p-3 rounded"></textarea>

<button class="bg-purple-600 text-white px-5 py-3 rounded">
    Simpan
</button>

</form>

@endsection