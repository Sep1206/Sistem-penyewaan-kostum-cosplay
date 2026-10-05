@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Tambah Kostum
</h2>

<form action="{{ route('costumes.store') }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

@csrf

<input name="nama_kostum"
       placeholder="Nama Kostum"
       class="w-full border p-3 rounded">

<input name="karakter"
       placeholder="Karakter"
       class="w-full border p-3 rounded">

<input name="kategori"
       placeholder="Kategori"
       class="w-full border p-3 rounded">

<input name="ukuran"
       placeholder="Ukuran"
       class="w-full border p-3 rounded">

<input name="harga_sewa"
       type="number"
       placeholder="Harga Sewa"
       class="w-full border p-3 rounded">

<input name="kondisi"
       placeholder="Kondisi"
       class="w-full border p-3 rounded">

<input name="stok"
       type="number"
       placeholder="Stok"
       class="w-full border p-3 rounded">

<button class="bg-purple-600 text-white px-5 py-3 rounded">
    Simpan
</button>

</form>

@endsection