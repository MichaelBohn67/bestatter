<?php

namespace Database\Factories;

use App\Models\Deceased;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deceased>
 */
class DeceasedFactory extends Factory
{
    protected $model = Deceased::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->date('Y-m-d', '-70 years'),
            'date_of_death' => $this->faker->date('Y-m-d', 'now'),
            'place_of_death' => $this->faker->city(),
            'last_address' => $this->faker->address(),
            'religion' => $this->faker->randomElement(['Catholic', 'Protestant', 'None', 'Other']),
        ];
    }
}
