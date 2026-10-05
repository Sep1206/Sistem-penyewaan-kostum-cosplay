@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Daftar Customer</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        <input name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
               class="w-full border p-3 rounded" required>

        <input name="email" type="email" value="{{ old('email') }}" placeholder="Email"
               class="w-full border p-3 rounded" required>

        <input name="no_hp" value="{{ old('no_hp') }}" placeholder="No HP"
               class="w-full border p-3 rounded" required>

        <textarea name="alamat" placeholder="Alamat"
                  class="w-full border p-3 rounded" required>{{ old('alamat') }}</textarea>

        <select name="jenis_kelamin" class="w-full border p-3 rounded" required>
            <option value="">Jenis kelamin</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
        </select>

        <input name="password" type="password" placeholder="Password (min. 8 karakter)"
               class="w-full border p-3 rounded" required>

        <input name="password_confirmation" type="password" placeholder="Ulangi password"
               class="w-full border p-3 rounded" required>

        <button class="w-full bg-purple-600 text-white px-5 py-3 rounded">Buat akun</button>
    </form>

    <p class="mt-4 text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-purple-700">Masuk</a>
    </p>

</div>

@endsection
