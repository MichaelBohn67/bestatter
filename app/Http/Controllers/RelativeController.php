<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use App\Models\Relative;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RelativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $relatives = Relative::with('deceased')
            ->orderBy('last_name')
            ->paginate(10);

        return view('relatives.index', compact('relatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $deceased = Deceased::orderBy('last_name')->get();

        return view('relatives.create', compact('deceased'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'deceased_id' => 'required|exists:deceased,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'address_street' => 'nullable|string|max:255',
            'address_house_number' => 'nullable|string|max:255',
            'address_postal_code' => 'nullable|string|max:16',
            'address_city' => 'nullable|string|max:255',
            'address_state' => 'nullable|string|max:255',
            'address_country' => 'nullable|string|max:255',
            'address_additional_info' => 'nullable|string|max:255',
        ]);

        $relative = Relative::create($validated);

        $addressData = $this->extractAddressData($validated);
        if (!empty($addressData)) {
            $relative->address()->create($addressData);
        }

        return redirect()->route('relatives.index')
            ->with('success', 'Angehöriger erfolgreich angelegt.');
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
