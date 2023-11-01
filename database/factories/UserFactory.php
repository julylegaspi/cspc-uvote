<?php

namespace Database\Factories;

use App\Models\PartyList;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'course_id' => 1,
            'section_id' => 1,
            'gender' => $this->faker->randomElement(['m', 'f']),
            'is_active' => true,
            'partylist_id' => PartyList::all()->random()->id,
            'address' => $this->faker->address(),
            'birthday' => $this->faker->dateTimeBetween('1990-01-01', '2012-12-31'),
            'organizational_affiliation' => $this->faker->paragraph(10),
            'notable_achievements' => $this->faker->paragraph(10),
            'platform' => $this->faker->paragraph(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
