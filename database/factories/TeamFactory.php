<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
use App\Models\User;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'leader_id' => function(){
                return User::factory()->count(1)->create([
                    'role' => 'leader'
                ])->id;
            },
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
