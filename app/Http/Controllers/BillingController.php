<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\FuneralService;
use App\Services\BillingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $billings = Billing::with(['funeralService.deceased'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('billings.index', compact('billings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $funeralServices = FuneralService::with('deceased')
            ->orderBy('order_number')
            ->get();

        return view('billings.create', compact('funeralServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, BillingService $service): RedirectResponse
    {
        $validated = $this->validateBilling($request);

        $service->create($validated);

        return redirect()->route('billings.index')
            ->with('success', 'Rechnungsdaten erfolgreich angelegt.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing): View
    {
        $funeralServices = FuneralService::with('deceased')
            ->orderBy('order_number')
            ->get();

        return view('billings.edit', compact('billing', 'funeralServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Billing $billing, BillingService $service): RedirectResponse
    {
        $validated = $this->validateBilling($request, $billing->id);

        $service->update($billing, $validated);

        return redirect()->route('billings.index')
            ->with('success', 'Rechnungsdaten erfolgreich aktualisiert.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateBilling(Request $request, ?int $billingId = null): array
    {
        return $request->validate([
            'funeral_service_id' => [
                'required',
                'exists:funeral_services,id',
                Rule::unique('billings', 'funeral_service_id')->ignore($billingId),
            ],
            'invoice_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('billings', 'invoice_number')->ignore($billingId),
            ],
            'status' => 'required|string|max:50',
            'issued_at' => 'nullable|date',
            'due_at' => 'nullable|date|after_or_equal:issued_at',
            'subtotal' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
    }
}
