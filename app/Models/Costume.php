<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    protected $fillable = [
        'nama_kostum',
        'karakter',
        'kategori',
        'ukuran',
        'harga_sewa',
        'kondisi',
        'stok',
    ];

    public function rentalSchedules()
    {
        return $this->hasMany(RentalSchedule::class);
    }
}
