<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalSchedule extends Model
{
    public const STATUSES = ['menunggu', 'disetujui', 'disewa', 'dikembalikan', 'ditolak'];

    protected $fillable = [
        'customer_id',
        'costume_id',
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

    public function costume()
    {
        return $this->belongsTo(Costume::class);
    }

    /** Hitung total: harga sewa x jumlah hari (minimal 1 hari). */
    public static function hitungTotal(Costume $costume, string $mulai, string $selesai): float
    {
        $hari = max(1, (int) \Carbon\Carbon::parse($mulai)->diffInDays(\Carbon\Carbon::parse($selesai)));

        return $costume->harga_sewa * $hari;
    }
}
