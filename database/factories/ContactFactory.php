<?php

namespace Database\Factories;

use App\Enums\ContactTypeEnum;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

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
    public function definition(): array
    {
        return [
            'person_id' => Person::factory()->create(),
            'type' => $this->faker->randomElement(ContactTypeEnum::cases()),
            'contact' => $this->faker->word,
        ];
    }
}
