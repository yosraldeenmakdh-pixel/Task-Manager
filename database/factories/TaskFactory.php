<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id'=>User::inRandomOrder()->first()->id ,
            'title'=>fake()->sentence() ,
            'discription'=>fake()->paragraph() ,
            'priority'=>fake()->randomElement(['high','medium','low']) ,
        ];
    }
}
