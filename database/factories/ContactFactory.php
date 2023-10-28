<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $firstName = fake()->firstName();
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthdate' => fake()->date(),
            'address' => fake()->address(),
            'image' => 'contacts/contact.jpg',
        ];
    }
}
