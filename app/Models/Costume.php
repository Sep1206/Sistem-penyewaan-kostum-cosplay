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

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class);
    }
}
