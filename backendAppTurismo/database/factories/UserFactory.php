<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'user' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
            'country' => $this->faker->countryCode, // Por ejemplo: PE, AR
            'zip_code' => $this->faker->postcode,
        ];
    }
}

