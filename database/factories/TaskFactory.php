<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name,
            'description'   => $this->faker->text,
            'status'        => $this->faker->randomElement([
                'backlog', 'in_progress', 'waiting_customer_approval', 'approved'
            ]),
            'file_url'      => $this->faker->imageUrl()
        ];
    }
}
