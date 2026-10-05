@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Masuk</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <input name="email" type="email" value="{{ old('email') }}"
               placeholder="Email" class="w-full border p-3 rounded" required autofocus>

        <input name="password" type="password"
               placeholder="Password" class="w-full border p-3 rounded" required>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember"> Ingat saya
        </label>

        <button class="w-full bg-purple-600 text-white px-5 py-3 rounded">Masuk</button>
    </form>

    <p class="mt-4 text-sm text-gray-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-purple-700">Daftar sebagai customer</a>
    </p>

</div>

@endsection
