<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_is_created_with_pending_status(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Test User',
            'email' => 'test@test.pl',
            'password' => bcrypt('password'),
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'booking_reference' => 'REF123',
            'status' => BookingStatus::PENDING,
            'passengers_count' => 1,
            'total_price' => 100,
            'currency' => 'USD',
        ]);

        $this->assertDatabaseHas('bookings', [
            'booking_reference' => 'REF123',
        ]);

        $this->assertEquals(BookingStatus::PENDING, $booking->status);
    }
}
