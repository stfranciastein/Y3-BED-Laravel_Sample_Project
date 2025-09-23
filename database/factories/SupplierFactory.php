<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake('en_GB')->company();
        $email = fake('en_GB')->username() . '@' . \Illuminate\Support\Str::slug($name) . '.com';
        return [
            'name' => $name,
            'address' => fake('en_GB')->address(),
            'phone' => fake('en_GB')->phoneNumber(),
            'email' => $email,
        ];
    }
}
