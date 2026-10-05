<?php

namespace Tests\Feature;

use App\Models\Costume;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SistemTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::forceCreate([
            'name' => 'Admin', 'email' => 'a@test.id', 'password' => 'password', 'role' => 'admin',
        ]);
    }

    private function customer(): User
    {
        $user = User::create(['name' => 'Rina', 'email' => 'r@test.id', 'password' => 'password']);
        Customer::create([
            'user_id' => $user->id, 'nama' => 'Rina', 'no_hp' => '0812',
            'alamat' => 'Samarinda', 'jenis_kelamin' => 'Perempuan',
        ]);

        return $user;
    }

    private function kostum(int $stok = 2): Costume
    {
        return Costume::create([
            'nama_kostum' => 'Naruto', 'karakter' => 'Naruto', 'kategori' => 'Anime',
            'ukuran' => 'M', 'harga_sewa' => 75000, 'kondisi' => 'Baik', 'stok' => $stok,
        ]);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get(route('costumes.index'))->assertRedirect(route('login'));
    }

    public function test_register_membuat_user_customer(): void
    {
        $this->post('/register', [
            'name' => 'Budi', 'email' => 'budi@test.id',
            'password' => 'password123', 'password_confirmation' => 'password123',
            'no_hp' => '0813', 'alamat' => 'Jl. A', 'jenis_kelamin' => 'Laki-laki',
        ])->assertRedirect(route('costumes.index'));

        $user = User::where('email', 'budi@test.id')->first();
        $this->assertSame('customer', $user->role);
        $this->assertNotNull($user->customer);
    }

    public function test_customer_tidak_bisa_masuk_halaman_admin(): void
    {
        $this->actingAs($this->customer())
            ->get(route('customers.index'))->assertForbidden();
    }

    public function test_admin_bisa_tambah_kostum(): void
    {
        $this->actingAs($this->admin())->post(route('costumes.store'), [
            'nama_kostum' => 'Miku', 'karakter' => 'Vocaloid', 'kategori' => 'Anime',
            'ukuran' => 'S', 'harga_sewa' => 90000, 'kondisi' => 'Baik', 'stok' => 2,
        ])->assertRedirect(route('costumes.index'));

        $this->assertDatabaseHas('costumes', ['nama_kostum' => 'Miku']);
    }

    public function test_customer_memesan_total_dihitung_server(): void
    {
        $kostum = $this->kostum();

        $this->actingAs($this->customer())->post(route('my_rentals.store'), [
            'costume_id' => $kostum->id,
            'tanggal_sewa' => now()->addDay()->toDateString(),
            'tanggal_kembali' => now()->addDays(4)->toDateString(),
        ])->assertRedirect(route('my_rentals.index'));

        $this->assertDatabaseHas('rental_schedules', [
            'costume_id' => $kostum->id, 'status' => 'menunggu', 'total_harga' => 225000,
        ]);
    }

    public function test_stok_berkurang_saat_status_disewa_dan_kembali_saat_dikembalikan(): void
    {
        $admin = $this->admin();
        $kostum = $this->kostum(2);
        $cust = $this->customer()->customer;

        $payload = [
            'customer_id' => $cust->id, 'costume_id' => $kostum->id,
            'tanggal_sewa' => '2026-11-01', 'tanggal_kembali' => '2026-11-03', 'status' => 'disewa',
        ];

        $this->actingAs($admin)->post(route('rental_schedules.store'), $payload);
        $this->assertSame(1, $kostum->fresh()->stok);

        $rental = $cust->rentalSchedules()->first();
        $this->actingAs($admin)->put(route('rental_schedules.update', $rental), $payload['status'] ? array_merge($payload, ['status' => 'dikembalikan']) : []);
        $this->assertSame(2, $kostum->fresh()->stok);
    }
}
