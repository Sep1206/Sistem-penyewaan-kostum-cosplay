@php($rental = $rental ?? null)

<select name="customer_id" class="w-full border p-3 rounded" required>
    <option value="">Pilih customer</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}"
            @selected(old('customer_id', $rental?->customer_id) == $customer->id)>
            {{ $customer->nama }} - {{ $customer->no_hp }}
        </option>
    @endforeach
</select>

<select name="costume_id" class="w-full border p-3 rounded" required>
    <option value="">Pilih kostum</option>
    @foreach($costumes as $costume)
        <option value="{{ $costume->id }}"
            @selected(old('costume_id', $rental?->costume_id) == $costume->id)>
            {{ $costume->nama_kostum }} ({{ $costume->ukuran }}) -
            Rp{{ number_format($costume->harga_sewa, 0, ',', '.') }}/hari - stok {{ $costume->stok }}
        </option>
    @endforeach
</select>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="block text-sm">Tanggal sewa
        <input type="date" name="tanggal_sewa" class="w-full border p-3 rounded mt-1" required
               value="{{ old('tanggal_sewa', $rental?->tanggal_sewa?->format('Y-m-d')) }}">
    </label>

    <label class="block text-sm">Tanggal kembali
        <input type="date" name="tanggal_kembali" class="w-full border p-3 rounded mt-1" required
               value="{{ old('tanggal_kembali', $rental?->tanggal_kembali?->format('Y-m-d')) }}">
    </label>
</div>

<label class="block text-sm">Status
    <select name="status" class="w-full border p-3 rounded mt-1" required>
        @foreach(\App\Models\RentalSchedule::STATUSES as $status)
            <option value="{{ $status }}"
                @selected(old('status', $rental?->status ?? 'menunggu') === $status)>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
</label>

<p class="text-sm text-gray-500">
    Total harga dihitung otomatis: harga sewa × jumlah hari.
    Stok kostum berkurang saat status "Disewa" dan kembali saat status berubah.
</p>
