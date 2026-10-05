@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">
        Detail Customer
    </h2>

    <p><b>Nama:</b> {{ $customer->nama }}</p>
    <p><b>No HP:</b> {{ $customer->no_hp }}</p>
    <p><b>Email:</b> {{ $customer->email }}</p>
    <p><b>Alamat:</b> {{ $customer->alamat }}</p>
    <p><b>Jenis Kelamin:</b> {{ $customer->jenis_kelamin }}</p>

    <a href="{{ route('customers.index') }}"
       class="inline-block mt-5 bg-gray-600 text-white px-4 py-2 rounded">
        Kembali
    </a>

</div>

@endsection