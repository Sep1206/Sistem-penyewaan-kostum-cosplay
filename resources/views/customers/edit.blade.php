@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Edit Customer</h2>

<form action="{{ route('customers.update', $customer) }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">

    @csrf
    @method('PUT')

    <input name="nama"
           value="{{ $customer->nama }}"
           class="w-full border p-3 rounded">

    <input name="no_hp"
           value="{{ $customer->no_hp }}"
           class="w-full border p-3 rounded">

    <input name="email"
           type="email"
           value="{{ $customer->email }}"
           class="w-full border p-3 rounded">

    <textarea name="alamat"
              class="w-full border p-3 rounded">{{ $customer->alamat }}</textarea>

    <select name="jenis_kelamin"
            class="w-full border p-3 rounded">

        <option value="Laki-laki"
            {{ $customer->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
            Laki-laki
        </option>

        <option value="Perempuan"
            {{ $customer->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
            Perempuan
        </option>

    </select>

    <button class="bg-yellow-500 text-white px-5 py-3 rounded">
        Update
    </button>

</form>

@endsection