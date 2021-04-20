<?php

namespace Database\Factories;

use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusAuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StatusAuthor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['1', '0'])
        ];
    }
}
