@php
    $lamaK = $lamaK ?? collect();
    $lamaA = $lamaA ?? collect();
    $menahan = $menahan ?? false;
@endphp

<div class="space-y-6">

    <div>
        <h3 class="font-semibold mb-2">Kostum</h3>

        <div class="border rounded overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-left">Harga/hari</th>
                        <th class="p-2 text-left">Tersedia</th>
                        <th class="p-2 text-left">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($costumes as $c)
                    @php($tersedia = $c->stok + ($menahan ? ($lamaK[$c->id] ?? 0) : 0))
                    <tr class="border-t">
                        <td class="p-2">{{ $c->nama_kostum }} ({{ $c->ukuran }})</td>
                        <td class="p-2">Rp{{ number_format($c->harga_sewa, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $tersedia }}</td>
                        <td class="p-2">
                            <input type="number" name="kostum[{{ $c->id }}]" min="0" max="{{ $tersedia }}"
                                   value="{{ old('kostum.'.$c->id, $lamaK[$c->id] ?? (request('costume_id') == $c->id ? 1 : 0)) }}"
                                   @disabled($tersedia < 1)
                                   class="w-24 border p-2 rounded">
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-3 text-gray-500">Tidak ada kostum tersedia.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h3 class="font-semibold mb-2">Aksesoris</h3>

        <div class="border rounded overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-left">Harga/hari</th>
                        <th class="p-2 text-left">Tersedia</th>
                        <th class="p-2 text-left">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($accessories as $a)
                    @php($tersedia = $a->stok + ($menahan ? ($lamaA[$a->id] ?? 0) : 0))
                    <tr class="border-t">
                        <td class="p-2">{{ $a->nama_aksesoris }}</td>
                        <td class="p-2">Rp{{ number_format($a->harga_sewa, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $tersedia }}</td>
                        <td class="p-2">
                            <input type="number" name="aksesoris[{{ $a->id }}]" min="0" max="{{ $tersedia }}"
                                   value="{{ old('aksesoris.'.$a->id, $lamaA[$a->id] ?? (request('accessory_id') == $a->id ? 1 : 0)) }}"
                                   @disabled($tersedia < 1)
                                   class="w-24 border p-2 rounded">
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-3 text-gray-500">Tidak ada aksesoris tersedia.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-sm text-gray-500">
        Isi jumlah pada kostum dan/atau aksesoris yang ingin disewa (kosongkan atau 0 jika tidak dipilih).
    </p>

</div>
