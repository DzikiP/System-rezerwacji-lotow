<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // 1. ROLES
        // =========================
        $roles = collect(['admin', 'airline', 'user'])
            ->map(fn ($role) => Role::firstOrCreate(['name' => $role]));

        $adminRole = $roles->firstWhere('name', 'admin');
        $userRole  = $roles->firstWhere('name', 'user');

        // =========================
        // 2. USERS
        // =========================
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin System',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id
            ]
        );

        $users = User::factory()
            ->count(10)
            ->create([
                'role_id' => $userRole->id
            ]);

        // =========================
        // 3. FLIGHTS
        // =========================
        $flights = Flight::factory()
            ->count(30)
            ->create();

        // =========================
        // 4. BOOKINGS (core)
        // =========================
        Booking::factory()
            ->count(50)
            ->make()
            ->each(function ($booking) use ($users, $flights) {

                $booking->user_id = $users->random()->id;
                $booking->flight_id = $flights->random()->id;

                $booking->booking_reference = strtoupper(Str::random(8));

                $booking->save();

                // =========================
                // PASSENGERS (spójne count)
                // =========================
                $passengersCount = rand(1, 4);

                Passenger::factory()
                    ->count($passengersCount)
                    ->create([
                        'booking_id' => $booking->id
                    ]);

                $booking->update([
                    'passengers_count' => $passengersCount
                ]);

                // =========================
                // PAYMENT (1 per booking)
                // =========================
                $payment = Payment::factory()->create([
                    'booking_id' => $booking->id,
                ]);

                // =========================
                // TICKET only if paid
                // =========================
                if ($payment->status === 'paid') {

                    Ticket::factory()->create([
                        'booking_id' => $booking->id,
                    ]);

                    $booking->update([
                        'status' => 'paid'
                    ]);
                }
            });
    }
}
