<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use WithFaker;

    /**
     * will test if name field is required
     *
     * @return void
     */
    public function testNameIsRequiredOnUserCreate()
    {
        $formData = [
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'address' => [
                'address' => $this->faker->address
            ]
        ];

        $this->post('/api/users', $formData, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    /**
    * will test if name field is required
    *
    * @return void
    */
    public function testPasswordIsRequiredOnUserCreate()
    {
        $formData = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => '',
            'address' => [
                'address' => $this->faker->address
            ]
        ];

        $this->post('/api/users', $formData, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }
}
