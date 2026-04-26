<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Deceased;
use App\Models\FuneralService;
use Illuminate\Support\Str;

class FuneralServiceCreator
{
    /**
     * Create a new funeral service with associated deceased and customer records.
     *
     * @param array $data
     * @return FuneralService
     */
    public function create(array $data): FuneralService
    {
        // Create Deceased
        $deceased = Deceased::create([
            'first_name' => $data['deceased_first_name'],
            'last_name' => $data['deceased_last_name'],
            'date_of_death' => $data['date_of_death'] ?? null,
        ]);

        // Create Customer
        $customer = Customer::create([
            'first_name' => $data['customer_first_name'],
            'last_name' => $data['customer_last_name'],
            'email' => $data['customer_email'] ?? null,
            'phone' => $data['customer_phone'] ?? null,
        ]);

        // Create Funeral Service
        return FuneralService::create([
            'deceased_id' => $deceased->id,
            'customer_id' => $customer->id,
            'order_number' => $this->generateOrderNumber(),
            'funeral_type' => $data['funeral_type'] ?? null,
            'funeral_date' => $data['funeral_date'] ?? null,
            'status' => 'draft',
        ]);
    }

    /**
     * Generate a unique order number.
     *
     * @return string
     */
    protected function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(Str::random(8));
    }
}
