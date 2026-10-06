<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RentalSchedule extends Model
{
    public const STATUSES = ['menunggu', 'disetujui', 'disewa', 'dikembalikan', 'ditolak'];

    // Status di mana barang masih "terpakai" sehingga stok berkurang.
    public const STATUS_TAHAN_STOK = ['menunggu', 'disetujui', 'disewa'];

    protected $fillable = [
        'customer_id',
        'tanggal_sewa',
        'tanggal_kembali',
        'total_harga',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sewa' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(RentalItem::class);
    }

    public function menahanStok(): bool
    {
        return in_array($this->status, self::STATUS_TAHAN_STOK, true);
    }

    /** Jumlah hari sewa (minimal 1 hari). */
    public static function hitungHari(Carbon $mulai, Carbon $selesai): int
    {
        return max(1, (int) $mulai->diffInDays($selesai));
    }
}
