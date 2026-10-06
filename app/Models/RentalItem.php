<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    protected $fillable = [
        'rental_schedule_id',
        'costume_id',
        'accessory_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function rentalSchedule()
    {
        return $this->belongsTo(RentalSchedule::class);
    }

    public function costume()
    {
        return $this->belongsTo(Costume::class);
    }

    public function accessory()
    {
        return $this->belongsTo(Accessories::class);
    }

    public function getNamaAttribute(): string
    {
        return $this->costume?->nama_kostum
            ?? $this->accessory?->nama_aksesoris
            ?? '(data dihapus)';
    }

    public function getJenisAttribute(): string
    {
        return $this->costume_id ? 'Kostum' : 'Aksesoris';
    }
}
