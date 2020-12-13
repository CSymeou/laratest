<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class TeamUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create master admin
        User::factory()->create([
            'email'             => 'admin@admin.com',
            'password'          => bcrypt('admin'),
            'role'              => 'admin'
        ]);

        // Create team leaders
        User::factory()->create([
            'email'             => 'leader1@leader.com',
            'password'          => bcrypt('leader'),
            'role'              => 'leader'
        ]);
        User::factory()->create([
            'email'             => 'leader2@leader.com',
            'password'          => bcrypt('leader'),
            'role'              => 'leader'
        ]);
        User::factory()->create([
            'email'             => 'leader3@leader.com',
            'password'          => bcrypt('leader'),
            'role'              => 'leader'
        ]);

        // Create teams
        Team::factory()->create([
            'leader_id'         => 2
        ]);
        Team::factory()->create([
            'leader_id'         => 3
        ]);
        Team::factory()->create([
            'leader_id'         => 4
        ]);

        // Create users
        User::factory()->create([
            'email'             => 'user1@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 1
        ]);
        User::factory()->create([
            'email'             => 'user2@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 1
        ]);
        User::factory()->create([
            'email'             => 'user3@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 1
        ]);
        User::factory()->create([
            'email'             => 'user4@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 2
        ]);
        User::factory()->create([
            'email'             => 'user5@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 2
        ]);
        User::factory()->create([
            'email'             => 'user6@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 2
        ]);
        User::factory()->create([
            'email'             => 'user7@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 3
        ]);
        User::factory()->create([
            'email'             => 'user8@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 3
        ]);
        User::factory()->create([
            'email'             => 'user9@user.com',
            'password'          => bcrypt('user'),
            'role'              => 'user',
            'team_id'           => 3
        ]);


    }
}
