<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TasksSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create master admin
        Task::factory()->create([
            'name'              => 'First task',
            'assignee_id'       => 4,
        ]);
        Task::factory()->create([
            'name'              => 'Second task',
            'assignee_id'       => 5,
        ]);
        Task::factory()->create([
            'name'              => 'Third task',
            'assignee_id'       => 6,
        ]);
        Task::factory()->create([
            'name'              => 'Fourth task',
            'assignee_id'       => 7,
        ]);
        Task::factory()->create([
            'name'              => 'Fifth task',
            'assignee_id'       => 8,
        ]);
        Task::factory()->create([
            'name'              => 'Sixth task',
            'assignee_id'       => 9,
        ]);
        Task::factory()->create([
            'name'              => 'Seventh task',
            'assignee_id'       => 10,
        ]);
        Task::factory()->create([
            'name'              => 'Eighth task',
            'assignee_id'       => 11,
        ]);
        Task::factory()->create([
            'name'              => 'Ninth task',
            'assignee_id'       => 12,
        ]);

    }
}
