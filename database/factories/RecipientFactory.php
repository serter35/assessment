<?php

namespace Database\Factories;

use App\VOs\Messaging\Content;
use App\VOs\Messaging\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => Content::fromValue($this->faker->text()),
            'phone_number' => PhoneNumber::fromValue($this->faker->phoneNumber()),
            'sent' => false,
        ];
    }
}
