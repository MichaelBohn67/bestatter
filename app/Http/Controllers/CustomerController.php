<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = Customer::orderBy('last_name')->paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCustomer($request);

        $customer = Customer::create($this->extractCustomerData($validated));

        $addressData = $this->extractAddressData($validated);
        if (!empty($addressData)) {
            $customer->address()->create($addressData);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Auftraggeber erfolgreich angelegt.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        $customer->load('address');

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $this->validateCustomer($request);

        $customer->update($this->extractCustomerData($validated));

        $addressData = $this->extractAddressData($validated);
        if (!empty($addressData)) {
            if ($customer->address) {
                $customer->address->update($addressData);
            } else {
                $customer->address()->create($addressData);
            }
        }

        return redirect()->route('customers.index')
            ->with('success', 'Auftraggeber erfolgreich aktualisiert.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateCustomer(Request $request): array
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'relationship_to_deceased' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'address_house_number' => 'nullable|string|max:255',
            'address_postal_code' => 'nullable|string|max:16',
            'address_city' => 'nullable|string|max:255',
            'address_state' => 'nullable|string|max:255',
            'address_country' => 'nullable|string|max:255',
            'address_additional_info' => 'nullable|string|max:255',
        ]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function extractCustomerData(array $data): array
    {
        $addressLine = trim(sprintf(
            '%s %s',
            $data['address_street'] ?? '',
            $data['address_house_number'] ?? ''
        ));

        return [
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'relationship_to_deceased' => $data['relationship_to_deceased'] ?? null,
            'address' => $addressLine !== '' ? $addressLine : null,
            'city' => $data['address_city'] ?? null,
            'zip' => $data['address_postal_code'] ?? null,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function extractAddressData(array $data): array
    {
        $address = [
            'street' => $data['address_street'] ?? null,
            'house_number' => $data['address_house_number'] ?? null,
            'postal_code' => $data['address_postal_code'] ?? null,
            'city' => $data['address_city'] ?? null,
            'state' => $data['address_state'] ?? null,
            'country' => $data['address_country'] ?? null,
            'additional_info' => $data['address_additional_info'] ?? null,
        ];

        return array_filter($address, static fn($value) => $value !== null && $value !== '');
    }
}
