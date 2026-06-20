<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Jan Kowalski',
            'email' => 'jan@test.pl',
            'password' => bcrypt('password123'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jan@test.pl'
        ]);

        $this->assertEquals('Jan Kowalski', $user->name);
    }
}
