<?php

namespace App\Http\Controllers;

use App\Models\Accessories;
use App\Models\Costume;
use App\Models\Customer;
use App\Models\RentalSchedule;
use App\Services\RentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RentalScheduleController extends Controller
{
    public function __construct(private RentalService $service)
    {
    }

    // Browse
    public function index()
    {
        $rentalSchedules = RentalSchedule::with(['customer', 'items.costume', 'items.accessory'])
            ->latest()->get();

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
        [$kostum, $aksesoris] = RentalService::itemDariInput($data);

        $this->service->buat($this->header($data), $kostum, $aksesoris);

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil ditambahkan!');
    }

    // Read
    public function show(RentalSchedule $rental_schedule)
    {
        $rental_schedule->load(['customer', 'items.costume', 'items.accessory']);

        return view('rental_schedules.show', ['rental' => $rental_schedule]);
    }

    // Edit - form
    public function edit(RentalSchedule $rental_schedule)
    {
        $rental_schedule->load('items');

        return view('rental_schedules.edit', [
            'rental' => $rental_schedule,
            'lamaK' => $rental_schedule->items->whereNotNull('costume_id')->pluck('jumlah', 'costume_id'),
            'lamaA' => $rental_schedule->items->whereNotNull('accessory_id')->pluck('jumlah', 'accessory_id'),
            'menahan' => $rental_schedule->menahanStok(),
        ] + $this->pilihan());
    }

    // Edit - simpan
    public function update(Request $request, RentalSchedule $rental_schedule)
    {
        $data = $this->validasi($request);
        [$kostum, $aksesoris] = RentalService::itemDariInput($data);

        $this->service->perbarui($rental_schedule, $this->header($data), $kostum, $aksesoris);

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil diperbarui!');
    }

    // Delete
    public function destroy(RentalSchedule $rental_schedule)
    {
        $this->service->hapus($rental_schedule);

        return redirect()->route('rental_schedules.index')
            ->with('success', 'Penyewaan berhasil dihapus!');
    }

    private function pilihan(): array
    {
        return [
            'customers' => Customer::orderBy('nama')->get(),
            'costumes' => Costume::orderBy('nama_kostum')->get(),
            'accessories' => Accessories::orderBy('nama_aksesoris')->get(),
        ];
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
            'status' => 'required|in:'.implode(',', RentalSchedule::STATUSES),
        ] + RentalService::ATURAN_ITEM);
    }

    private function header(array $data): array
    {
        return Arr::only($data, ['customer_id', 'tanggal_sewa', 'tanggal_kembali', 'status']);
    }
}
