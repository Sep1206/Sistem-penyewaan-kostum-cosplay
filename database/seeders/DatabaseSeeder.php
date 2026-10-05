<?php

namespace Database\Seeders;

use App\Models\Accessories;
use App\Models\Costume;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (role tidak ada di $fillable, jadi pakai forceCreate)
        User::forceCreate([
            'name' => 'Admin',
            'email' => 'admin@cosplay.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Contoh customer yang punya akun login
        $user = User::create([
            'name' => 'Rina Customer',
            'email' => 'customer@cosplay.test',
            'password' => 'password',
        ]);

        Customer::create([
            'user_id' => $user->id,
            'nama' => 'Rina Customer',
            'email' => 'customer@cosplay.test',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Contoh No. 1, Samarinda',
            'jenis_kelamin' => 'Perempuan',
        ]);

        $kostum = [
            ['Naruto Uzumaki', 'Naruto', 'Anime', 'M', 75000, 'Baik', 3],
            ['Hatsune Miku', 'Vocaloid', 'Anime', 'S', 90000, 'Baik', 2],
            ['Spider-Man', 'Marvel', 'Superhero', 'L', 100000, 'Baik', 2],
            ['Zoro Roronoa', 'One Piece', 'Anime', 'L', 80000, 'Baik', 1],
        ];
        foreach ($kostum as [$nama, $karakter, $kategori, $ukuran, $harga, $kondisi, $stok]) {
            Costume::create([
                'nama_kostum' => $nama,
                'karakter' => $karakter,
                'kategori' => $kategori,
                'ukuran' => $ukuran,
                'harga_sewa' => $harga,
                'kondisi' => $kondisi,
                'stok' => $stok,
            ]);
        }

        Accessories::create([
            'nama_aksesoris' => 'Wig Pirang Panjang',
            'kategori' => 'Wig',
            'harga_sewa' => 25000,
            'stok' => 5,
            'kondisi' => 'Baik',
            'deskripsi' => 'Wig pirang panjang tahan panas.',
        ]);
    }
}
