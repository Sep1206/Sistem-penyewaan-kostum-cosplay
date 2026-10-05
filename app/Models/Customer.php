<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'email',
        'alamat',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentalSchedules()
    {
        return $this->hasMany(RentalSchedule::class);
    }
}
