<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->firstName(),
            'last_name' => $this->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'info' => $this->faker->text(),
        ];
    }
}
