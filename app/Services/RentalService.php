<?php

namespace App\Services;

use App\Models\Accessories;
use App\Models\Costume;
use App\Models\RentalSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Semua logika item sewa, total harga, dan stok ada di sini
 * supaya admin dan customer memakai aturan yang sama.
 *
 * Stok berkurang selama status: menunggu, disetujui, disewa.
 * Stok kembali saat status: dikembalikan / ditolak, atau data dihapus.
 */
class RentalService
{
    public const ATURAN_ITEM = [
        'kostum' => 'nullable|array',
        'kostum.*' => 'nullable|integer|min:0|max:999',
        'aksesoris' => 'nullable|array',
        'aksesoris.*' => 'nullable|integer|min:0|max:999',
    ];

    /** Ubah input form menjadi [id => jumlah] yang jumlahnya > 0. */
    public static function itemDariInput(array $data): array
    {
        $bersih = fn ($x) => array_filter(
            array_map('intval', $x ?? []),
            fn ($jumlah) => $jumlah > 0
        );

        return [$bersih($data['kostum'] ?? []), $bersih($data['aksesoris'] ?? [])];
    }

    public function buat(array $header, array $kostum, array $aksesoris): RentalSchedule
    {
        return DB::transaction(function () use ($header, $kostum, $aksesoris) {
            $rental = RentalSchedule::create($header + ['total_harga' => 0]);
            $this->isi($rental, $kostum, $aksesoris);

            return $rental;
        });
    }

    public function perbarui(RentalSchedule $rental, array $header, array $kostum, array $aksesoris): RentalSchedule
    {
        return DB::transaction(function () use ($rental, $header, $kostum, $aksesoris) {
            $this->lepasStok($rental);   // pakai item & status yang lama
            $rental->items()->delete();
            $rental->update($header);
            $this->isi($rental, $kostum, $aksesoris);

            return $rental;
        });
    }

    public function hapus(RentalSchedule $rental): void
    {
        DB::transaction(function () use ($rental) {
            $this->lepasStok($rental);
            $rental->delete();
        });
    }

    private function isi(RentalSchedule $rental, array $kostum, array $aksesoris): void
    {
        $hari = RentalSchedule::hitungHari($rental->tanggal_sewa, $rental->tanggal_kembali);
        $total = 0;

        foreach (Costume::whereIn('id', array_keys($kostum))->get() as $costume) {
            $jumlah = $kostum[$costume->id];
            $subtotal = $costume->harga_sewa * $jumlah * $hari;

            $rental->items()->create([
                'costume_id' => $costume->id,
                'jumlah' => $jumlah,
                'harga_satuan' => $costume->harga_sewa,
                'subtotal' => $subtotal,
            ]);
            $total += $subtotal;
        }

        foreach (Accessories::whereIn('id', array_keys($aksesoris))->get() as $aksesorisItem) {
            $jumlah = $aksesoris[$aksesorisItem->id];
            $subtotal = $aksesorisItem->harga_sewa * $jumlah * $hari;

            $rental->items()->create([
                'accessory_id' => $aksesorisItem->id,
                'jumlah' => $jumlah,
                'harga_satuan' => $aksesorisItem->harga_sewa,
                'subtotal' => $subtotal,
            ]);
            $total += $subtotal;
        }

        if ($rental->items()->count() === 0) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu kostum atau aksesoris (jumlah lebih dari 0).',
            ]);
        }

        $rental->update(['total_harga' => $total]);

        if ($rental->menahanStok()) {
            $this->ambilStok($rental);
        }
    }

    private function ambilStok(RentalSchedule $rental): void
    {
        foreach ($rental->items()->get() as $item) {
            $barang = $item->costume_id
                ? Costume::lockForUpdate()->findOrFail($item->costume_id)
                : Accessories::lockForUpdate()->findOrFail($item->accessory_id);

            if ($barang->stok < $item->jumlah) {
                $nama = $barang->nama_kostum ?? $barang->nama_aksesoris;

                throw ValidationException::withMessages([
                    'items' => "Stok \"{$nama}\" tidak cukup (tersedia {$barang->stok}, diminta {$item->jumlah}).",
                ]);
            }

            $barang->decrement('stok', $item->jumlah);
        }
    }

    private function lepasStok(RentalSchedule $rental): void
    {
        if (! $rental->menahanStok()) {
            return;
        }

        foreach ($rental->items()->get() as $item) {
            if ($item->costume_id) {
                Costume::whereKey($item->costume_id)->increment('stok', $item->jumlah);
            } else {
                Accessories::whereKey($item->accessory_id)->increment('stok', $item->jumlah);
            }
        }
    }
}
