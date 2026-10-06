<?php

namespace App\Http\Controllers;

use App\Models\Accessories;
use App\Models\Costume;
use App\Services\RentalService;
use Illuminate\Http\Request;

class MyRentalController extends Controller
{
    public function __construct(private RentalService $service)
    {
    }

    private function customer()
    {
        $customer = auth()->user()->customer;
        abort_unless($customer, 403, 'Akun ini tidak memiliki data customer.');

        return $customer;
    }

    public function index()
    {
        $rentals = $this->customer()->rentalSchedules()
            ->with(['items.costume', 'items.accessory'])->latest()->get();

        return view('my_rentals.index', compact('rentals'));
    }

    public function create()
    {
        $this->customer();

        return view('my_rentals.create', [
            'costumes' => Costume::where('stok', '>', 0)->orderBy('nama_kostum')->get(),
            'accessories' => Accessories::where('stok', '>', 0)->orderBy('nama_aksesoris')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $customer = $this->customer();

        $data = $request->validate([
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
        ] + RentalService::ATURAN_ITEM);

        [$kostum, $aksesoris] = RentalService::itemDariInput($data);

        // Status awal selalu "menunggu"; stok langsung dikurangi (dipesan).
        $this->service->buat([
            'customer_id' => $customer->id,
            'tanggal_sewa' => $data['tanggal_sewa'],
            'tanggal_kembali' => $data['tanggal_kembali'],
            'status' => 'menunggu',
        ], $kostum, $aksesoris);

        return redirect()->route('my_rentals.index')
            ->with('success', 'Pesanan terkirim. Menunggu persetujuan admin.');
    }
}
