@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Tambah Customer</h2>

<form action="{{ route('customers.store') }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

    @csrf

    <input name="nama"
           placeholder="Nama"
           class="w-full border p-3 rounded">

    <input name="no_hp"
           placeholder="Nomor HP"
           class="w-full border p-3 rounded">

    <input name="email"
           type="email"
           placeholder="Email"
           class="w-full border p-3 rounded">

    <textarea name="alamat"
              placeholder="Alamat"
              class="w-full border p-3 rounded"></textarea>

    <select name="jenis_kelamin"
            class="w-full border p-3 rounded">

        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>

    </select>

    <button class="bg-purple-600 text-white px-5 py-3 rounded">
        Simpan
    </button>

</form>

@endsection