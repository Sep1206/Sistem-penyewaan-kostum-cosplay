<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Penyewaan Kostum Cosplay</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-purple-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-wrap justify-between items-center gap-3">

            <a href="{{ url('/') }}" class="text-xl font-bold">Cosplay Rental</a>

            <div class="flex flex-wrap items-center gap-5">
                @auth
                    <a href="{{ route('costumes.index') }}" class="hover:text-purple-200">Kostum</a>
                    <a href="{{ route('accessories.index') }}" class="hover:text-purple-200">Aksesoris</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('customers.index') }}" class="hover:text-purple-200">Customer</a>
                        <a href="{{ route('rental_schedules.index') }}" class="hover:text-purple-200">Penyewaan</a>
                    @else
                        <a href="{{ route('my_rentals.index') }}" class="hover:text-purple-200">Pesanan Saya</a>
                    @endif

                    <span class="text-purple-200 text-sm">
                        {{ auth()->user()->name }}
                        ({{ auth()->user()->isAdmin() ? 'admin' : 'customer' }})
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="bg-purple-900 hover:bg-purple-800 px-3 py-1 rounded">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-purple-200">Masuk</a>
                    <a href="{{ route('register') }}" class="hover:text-purple-200">Daftar</a>
                @endauth
            </div>

        </div>
    </nav>

    <main class="max-w-7xl w-full mx-auto px-6 py-8 flex-1">

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

    <footer class="text-center text-gray-500 py-6">
        <p>© 2026 Sistem Penyewaan Kostum Cosplay</p>
    </footer>

</body>

</html>
