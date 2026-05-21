<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([
            'pending',
            'paid',
            'failed',
            'refunded'
        ]);

        $paidAt = $status === 'paid'
            ? $this->faker->dateTimeBetween('-10 days', 'now')
            : null;

        return [
            'booking_id' => Booking::inRandomOrder()->first()?->id
                ?? Booking::factory(),

            'provider' => 'p24',

            'session_id' => strtoupper($this->faker->bothify('SES###??')),

            'transaction_id' => strtoupper($this->faker->bothify('TRX########')),

            'p24_order_id' => $this->faker->optional()->numerify('########'),

            'amount' => $this->faker->randomFloat(2, 100, 5000),

            'currency' => 'PLN',

            'status' => $status,

            'paid_at' => $paidAt,
        ];
    }
}
