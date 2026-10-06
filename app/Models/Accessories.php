<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
    protected $fillable = [
        'nama_aksesoris',
        'kategori',
        'harga_sewa',
        'stok',
        'kondisi',
        'deskripsi',
    ];

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class, 'accessory_id');
    }
}
