<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'nullable|email',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'nullable|email',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil diperbarui!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}