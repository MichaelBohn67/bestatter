<?php

namespace App\Http\Controllers;

use App\Models\FuneralService;
use App\Services\FuneralServiceCreator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FuneralServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $funeralServices = FuneralService::with(['customer', 'deceased'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('funeral-services.index', compact('funeralServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('funeral-services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FuneralServiceCreator $creator): RedirectResponse
    {
        $validated = $request->validate([
            // Deceased data
            'deceased_first_name' => 'required|string|max:255',
            'deceased_last_name' => 'required|string|max:255',
            'date_of_death' => 'nullable|date',

            // Customer data
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',

            // Service data
            'funeral_type' => 'nullable|string',
            'funeral_date' => 'nullable|date',
        ]);

        $creator->create($validated);

        return redirect()->route('funeral-services.index')
            ->with('success', 'Bestattungsauftrag erfolgreich angelegt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuneralService $funeralService): View
    {
        return view('funeral-services.show', compact('funeralService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuneralService $funeralService): View
    {
        return view('funeral-services.edit', compact('funeralService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuneralService $funeralService): RedirectResponse
    {
        // Update logic here
        return redirect()->route('funeral-services.index')
            ->with('success', 'Auftrag aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuneralService $funeralService): RedirectResponse
    {
        $funeralService->delete();
        return redirect()->route('funeral-services.index')
            ->with('success', 'Auftrag gelöscht.');
    }
}
