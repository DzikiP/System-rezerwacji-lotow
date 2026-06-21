<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Booking;
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
        // 3. AIRPORTS SEEDER
        // =========================
        $this->call(AirportSeeder::class);

        $airports = Airport::all();

        // =========================
        // 4. BOOKINGS (NO FLIGHTS TABLE)
        // =========================
        Booking::factory()
            ->count(50)
            ->make()
            ->each(function ($booking) use ($users, $airports) {

                $from = $airports->random();
                $to   = $airports->where('id', '!=', $from->id)->random();

                $booking->user_id = $users->random()->id;

                $booking->booking_reference = strtoupper(Str::random(8));

                $booking->status = 'pending';
                $booking->currency = 'PLN';
                $booking->total_price = rand(200, 2000);
                $booking->passengers_count = rand(1, 4);

                $booking->save();

                // =========================
                // PASSENGERS
                // =========================
                Passenger::factory()
                    ->count($booking->passengers_count)
                    ->create([
                        'booking_id' => $booking->id
                    ]);
            });
    }
}
