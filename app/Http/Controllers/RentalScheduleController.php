<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Customer;
use App\Models\RentalSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RentalScheduleController extends Controller
{
    // Browse
    public function index()
    {
        $rentalSchedules = RentalSchedule::with(['customer', 'costume'])->latest()->get();

        return view('rental_schedules.index', compact('rentalSchedules'));
    }

    // Add - form
    public function create()
    {
        return view('rental_schedules.create', $this->pilihan());
    }

    // Add - simpan
    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['total_harga'] = $this->total($data);

        DB::transaction(function () use ($data) {
            $rental = RentalSchedule::create($data);
            $this->ambilStokJikaDisewa($rental);
        });

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil ditambahkan!');
    }

    // Read
    public function show(RentalSchedule $rental_schedule)
    {
        $rental_schedule->load(['customer', 'costume']);

        return view('rental_schedules.show', ['rental' => $rental_schedule]);
    }

    // Edit - form
    public function edit(RentalSchedule $rental_schedule)
    {
        return view('rental_schedules.edit', ['rental' => $rental_schedule] + $this->pilihan());
    }

    // Edit - simpan
    public function update(Request $request, RentalSchedule $rental_schedule)
    {
        $data = $this->validasi($request);
        $data['total_harga'] = $this->total($data);

        DB::transaction(function () use ($rental_schedule, $data) {
            $this->kembalikanStokJikaDisewa($rental_schedule);
            $rental_schedule->update($data);
            $this->ambilStokJikaDisewa($rental_schedule->fresh());
        });

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil diperbarui!');
    }

    // Delete
    public function destroy(RentalSchedule $rental_schedule)
    {
        DB::transaction(function () use ($rental_schedule) {
            $this->kembalikanStokJikaDisewa($rental_schedule);
            $rental_schedule->delete();
        });

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil dihapus!');
    }

    private function pilihan(): array
    {
        return [
            'customers' => Customer::orderBy('nama')->get(),
            'costumes' => Costume::orderBy('nama_kostum')->get(),
        ];
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'costume_id' => 'required|exists:costumes,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
            'status' => 'required|in:'.implode(',', RentalSchedule::STATUSES),
        ]);
    }

    private function total(array $data): float
    {
        return RentalSchedule::hitungTotal(
            Costume::findOrFail($data['costume_id']),
            $data['tanggal_sewa'],
            $data['tanggal_kembali']
        );
    }

    // Stok berkurang saat status "disewa", kembali saat status berubah/dihapus.
    private function ambilStokJikaDisewa(RentalSchedule $rental): void
    {
        if ($rental->status !== 'disewa') {
            return;
        }

        $costume = Costume::findOrFail($rental->costume_id);

        if ($costume->stok < 1) {
            throw ValidationException::withMessages([
                'costume_id' => 'Stok kostum "'.$costume->nama_kostum.'" habis.',
            ]);
        }

        $costume->decrement('stok');
    }

    private function kembalikanStokJikaDisewa(RentalSchedule $rental): void
    {
        if ($rental->status === 'disewa') {
            Costume::whereKey($rental->costume_id)->increment('stok');
        }
    }
}
