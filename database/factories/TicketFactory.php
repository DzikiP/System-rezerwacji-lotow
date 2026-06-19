<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::inRandomOrder()->first()?->id
                ?? Booking::factory(),

            'ticket_number' => strtoupper(
                'TKT-' . $this->faker->bothify('##########')
            ),

            'pdf_path' => 'tickets/' . $this->faker->uuid() . '.pdf',

            'issued_at' => now(),
        ];
    }
}
