<?php

namespace App\Services;

use App\Models\Billing;

class BillingService
{
    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): Billing
    {
        return Billing::create($this->normalize($data));
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Billing $billing, array $data): Billing
    {
        $billing->update($this->normalize($data));

        return $billing;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function normalize(array $data): array
    {
        $subtotal = isset($data['subtotal']) ? (float) $data['subtotal'] : null;
        $taxRate = isset($data['tax_rate']) ? (float) $data['tax_rate'] : null;

        if ($subtotal !== null && $taxRate !== null) {
            $taxAmount = round($subtotal * ($taxRate / 100), 2);
            $total = round($subtotal + $taxAmount, 2);
        } else {
            $taxAmount = null;
            $total = null;
        }

        return [
            'funeral_service_id' => $data['funeral_service_id'] ?? null,
            'invoice_number' => $data['invoice_number'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'issued_at' => $data['issued_at'] ?? null,
            'due_at' => $data['due_at'] ?? null,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'notes' => $data['notes'] ?? null,
        ];
    }
}
