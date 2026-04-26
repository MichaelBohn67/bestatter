<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Deceased;
use App\Models\FuneralService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuneralService>
 */
class FuneralServiceFactory extends Factory
{
    protected $model = FuneralService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deceased_id' => Deceased::factory(),
            'customer_id' => Customer::factory(),
            'order_number' => $this->faker->unique()->bothify('FS-#####'),
            'status' => $this->faker->randomElement(['draft', 'active', 'completed', 'cancelled']),
            'funeral_type' => $this->faker->randomElement(['Erdbestattung', 'Feuerbestattung', 'Seebestattung']),
            'funeral_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'funeral_location' => $this->faker->address(),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
