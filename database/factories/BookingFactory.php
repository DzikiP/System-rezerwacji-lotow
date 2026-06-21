<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([
            BookingStatus::PENDING,
            BookingStatus::AWAITING_PAYMENT,
            BookingStatus::PAID,
            BookingStatus::CANCELLED,
        ]);

        $passengers = $this->faker->numberBetween(1, 5);

        // SNAPSHOT PRICE (no flight dependency)
        $pricePerPassenger = $this->faker->numberBetween(150, 900);
        $totalPrice = $pricePerPassenger * $passengers;

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),

            'booking_reference' => strtoupper(Str::random(8)),

            'status' => $status,

            'passengers_count' => $passengers,

            'total_price' => $totalPrice,

            'currency' => 'PLN',

            'expires_at' =>
                $status === BookingStatus::PENDING
                    ? now()->addMinutes(15)
                    : null,
        ];
    }
}
