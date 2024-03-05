<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'vehicle_make' => $this->faker->randomElement([
                'Toyota',
                'Ford',
                'Volkswagen',
                'Audi',
                'BMW',
            ]),
            'vehicle_model' => $this->faker->randomElement([
                'Corolla',
                'Fiesta',
                'Golf',
                'A3',
                '3 Series',
            ]),
            'start_at' => $startAt = $this->faker->dateTimeBetween('now', '+1 year'),
            'end_at' => $startAt->add(config('app.booking_length')),
        ];
    }
}
