@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6">Edit Penyewaan</h2>

<form action="{{ route('rental_schedules.update', $rental) }}" method="POST"
      class="bg-white p-6 rounded-xl shadow space-y-4">
    @csrf
    @method('PUT')

    @include('rental_schedules._form')

    <button class="bg-purple-600 text-white px-5 py-3 rounded">Simpan perubahan</button>
    <a href="{{ route('rental_schedules.index') }}" class="px-3 text-gray-600">Batal</a>
</form>

@endsection
