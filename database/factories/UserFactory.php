<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Partylist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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
        $password = Str::random(6);
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->username(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'encrypted_password' => Crypt::encryptString($password),
            'course_id' => 1,
            'section_id' => 1,
            'gender' => $this->faker->randomElement(['m', 'f']),
            'is_active' => true,
            'partylist_id' => Partylist::all()->random()->id,
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
