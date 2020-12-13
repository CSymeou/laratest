<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\User;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'progress' => $this->faker->numberBetween(0, 100),
            'assignee_id' => function(){
                return User::factory()->count(1)->create([
                    'role' => 'user'
                ])->id;
            },
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
