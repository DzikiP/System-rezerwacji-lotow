<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Integration User',
            'email' => 'integration@test.pl',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $booking = Booking::create([
            'user_id' => $user->id,
            'booking_reference' => 'INT-001',
            'status' => 'pending',
            'passengers_count' => 2,
            'total_price' => 500,
            'currency' => 'USD',
        ]);

        // 5. assertions
        $this->assertDatabaseHas('bookings', [
            'booking_reference' => 'INT-001',
        ]);

        $this->assertEquals($user->id, $booking->user_id);
    }

    public function test_user_bookings_relationship_works(): void
    {
        $role = Role::create(['name' => 'user']);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Relation User',
            'email' => 'relation@test.pl',
            'password' => bcrypt('password'),
        ]);

        Booking::create([
            'user_id' => $user->id,
            'booking_reference' => 'REL-001',
            'status' => 'pending',
            'passengers_count' => 1,
            'total_price' => 100,
            'currency' => 'USD',
        ]);

        $this->assertCount(1, $user->fresh()->bookings);
    }
}
