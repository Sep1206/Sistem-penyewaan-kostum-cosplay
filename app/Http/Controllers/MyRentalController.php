<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\RentalSchedule;
use Illuminate\Http\Request;

class MyRentalController extends Controller
{
    private function customer()
    {
        $customer = auth()->user()->customer;
        abort_unless($customer, 403, 'Akun ini tidak memiliki data customer.');

        return $customer;
    }

    public function index()
    {
        $rentals = $this->customer()->rentalSchedules()
            ->with('costume')->latest()->get();

        return view('my_rentals.index', compact('rentals'));
    }

    public function create()
    {
        $this->customer();
        $costumes = Costume::where('stok', '>', 0)->orderBy('nama_kostum')->get();

        return view('my_rentals.create', compact('costumes'));
    }

    public function store(Request $request)
    {
        $customer = $this->customer();

        $data = $request->validate([
            'costume_id' => 'required|exists:costumes,id',
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
        ]);

        $costume = Costume::findOrFail($data['costume_id']);

        if ($costume->stok < 1) {
            return back()->withInput()
                ->withErrors(['costume_id' => 'Stok kostum ini sedang habis.']);
        }

        // Total dihitung di server, bukan dari input form
        $customer->rentalSchedules()->create([
            'costume_id' => $costume->id,
            'tanggal_sewa' => $data['tanggal_sewa'],
            'tanggal_kembali' => $data['tanggal_kembali'],
            'total_harga' => RentalSchedule::hitungTotal($costume, $data['tanggal_sewa'], $data['tanggal_kembali']),
            'status' => 'menunggu',
        ]);

        return redirect()->route('my_rentals.index')
            ->with('success', 'Pesanan terkirim. Menunggu persetujuan admin.');
    }
}
