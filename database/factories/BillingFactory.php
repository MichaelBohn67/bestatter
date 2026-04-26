<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\FuneralService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Billing>
 */
class BillingFactory extends Factory
{
    protected $model = Billing::class;

    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 10000);
        $taxRate = $this->faker->randomFloat(2, 0, 19);
        $taxAmount = round($subtotal * ($taxRate / 100), 2);
        $total = round($subtotal + $taxAmount, 2);

        return [
            'funeral_service_id' => FuneralService::factory(),
            'invoice_number' => strtoupper($this->faker->bothify('INV-#####')),
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
            'issued_at' => $this->faker->date(),
            'due_at' => $this->faker->date(),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'notes' => $this->faker->sentence(),
        ];
    }
}
