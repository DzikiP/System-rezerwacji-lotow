<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassengerFactory extends Factory
{
    protected $model = Passenger::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement([
            'adult',
            'child',
            'infant'
        ]);

        return [
            'booking_id' => Booking::inRandomOrder()->first()?->id
                ?? Booking::factory(),

            'first_name' => $this->faker->firstName(),

            'last_name' => $this->faker->lastName(),

            'birth_date' => match ($type) {
                'adult' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
                'child' => $this->faker->dateTimeBetween('-17 years', '-2 years'),
                'infant' => $this->faker->dateTimeBetween('-1 years', 'now'),
            },

            'nationality' => $this->faker->randomElement([
                'PL',
                'DE',
                'FR',
                'US',
                'ES',
                'IT'
            ]),

            'document_number' => strtoupper(
                $this->faker->bothify('??######')
            ),

            'passenger_type' => $type,

            'seat_number' => $this->faker->optional()->bothify('#?'),
        ];
    }
}
