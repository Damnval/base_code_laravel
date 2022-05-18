<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Test that will save a User model in DB
     *
     * @return void
     */
    public function test_can_create_user()
    {
        $formData = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'address' => [
                'address' => $this->faker->address
            ]
        ];

        $this->post('/api/users', $formData)
            ->assertStatus(201);
    }

    /**
     * Test that will update a User model in DB
     *
     * @return void
     */
    public function test_can_update_user()
    {
        $formData = [
            'name' => 'Updated name',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'address' => [
                'address' => $this->faker->address
            ]
        ];

        $user = User::latest()->first();

        $this->put('/api/users/' . $user->id, $formData)
            ->assertStatus(200);
    }

    /**
     * Will get all users
     *
     * @return void
     */
    public function test_get_all_users()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }

    /**
     * will get a specific user
     *
     * @return void
     */
    public function test_can_get_specic_user()
    {
        $user = User::first();

        $this->get('/api/users/' . $user->id)
            ->assertStatus(200);
    }

    /**
     * will get a specific user
     *
     * @return void
     */
    public function test_can_delete_user()
    {
        $user = User::latest()->first();

        $this->delete('/api/users/' . $user->id)
            ->assertStatus(200);
    }
}
