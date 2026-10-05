@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Data Customer</h2>

    <a href="{{ route('customers.create') }}"
       class="bg-purple-600 text-white px-4 py-2 rounded-lg">
        + Tambah Customer
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">
    <thead class="bg-purple-600 text-white">
        <tr>
            <th class="p-3">Nama</th>
            <th class="p-3">No HP</th>
            <th class="p-3">Email</th>
            <th class="p-3">Jenis Kelamin</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($customers as $customer)
        <tr class="border-b">

            <td class="p-3">{{ $customer->nama }}</td>
            <td class="p-3">{{ $customer->no_hp }}</td>
            <td class="p-3">{{ $customer->email }}</td>
            <td class="p-3">{{ $customer->jenis_kelamin }}</td>

            <td class="p-3 space-x-2">

                <a href="{{ route('customers.show', $customer) }}"
                   class="text-blue-600">
                    Detail
                </a>

                <a href="{{ route('customers.edit', $customer) }}"
                   class="text-yellow-600">
                    Edit
                </a>

                <form action="{{ route('customers.destroy', $customer) }}"
                      method="POST"
                      class="inline">

                    @csrf
                    @method('DELETE')

                    <button class="text-red-600"
                            onclick="return confirm('Hapus data ini?')">
                        Hapus
                    </button>

                </form>

            </td>
        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection