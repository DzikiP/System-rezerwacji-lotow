<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([
            BookingStatus::PENDING,
            BookingStatus::AWAITING_PAYMENT,
            BookingStatus::PENDING,
            BookingStatus::CANCELLED,
        ]);

        $passengers = $this->faker->numberBetween(1, 6);

        $flight = Flight::inRandomOrder()->first();

        if (!$flight) {
            throw new \Exception('No flights found. Seed flights first.');
        }

        $basePrice = $flight->price * $passengers;

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),

            'flight_id' => $flight->id,

            'booking_reference' => strtoupper($this->faker->bothify('PNR###??')),

            'status' => $status,

            'passengers_count' => $passengers,

            'total_price' => $basePrice,

            'currency' => $flight->currency,

            'expires_at' =>
                $status === 'pending'
                    ? now()->addMinutes(10)
                    : null,
        ];
    }
}
