@props(['status'])

@php
    $warna = match ($status) {
        'menunggu' => 'bg-yellow-100 text-yellow-800',
        'disetujui' => 'bg-blue-100 text-blue-800',
        'disewa' => 'bg-purple-100 text-purple-800',
        'dikembalikan' => 'bg-green-100 text-green-800',
        'ditolak' => 'bg-red-100 text-red-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="px-2 py-1 rounded text-sm {{ $warna }}">{{ ucfirst($status) }}</span>
