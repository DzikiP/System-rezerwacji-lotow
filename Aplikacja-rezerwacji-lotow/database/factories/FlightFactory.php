<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        $departure = $this->faker->dateTimeBetween('+1 days', '+30 days');
        $arrival = (clone $departure)->modify('+' . rand(60, 720) . ' minutes');

        return [
            'airline' => $this->faker->randomElement([
                'LOT',
                'Lufthansa',
                'Ryanair',
                'Wizz Air',
                'Air France',
                'KLM'
            ]),

            'flight_number' => strtoupper(
                $this->faker->lexify('??') . rand(100, 999)
            ),

            'origin_airport' => strtoupper($this->faker->lexify('???')),
            'destination_airport' => strtoupper($this->faker->lexify('???')),

            'departure_time' => $departure,
            'arrival_time' => $arrival,

            'duration_minutes' => null,

            'price' => $this->faker->randomFloat(2, 120, 2500),

            'currency' => $this->faker->randomElement(['PLN', 'EUR', 'USD']),

            'seats_available' => $this->faker->numberBetween(0, 180),
        ];
    }
}
