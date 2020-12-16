<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Team;
use Tests\TestCase;

class MyTeamTest extends TestCase
{
    /**
     * myTeam.index
     */
   //Unauthenticated to myTeam.index redirect to /login
    public function test_teams_index_unauthenticated_redirects_to_login(){
        $response = $this->get(route('myTeam.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to myTeam.index returns 403
    public function test_teams_index_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('myTeam.index'));
        $response->assertStatus(403);
    }

    //Authenticated leader to myTeam.index returns 200 and view
    public function test_teams_index_authenticated_leader_returns_200(){
        $this->signInLeader();
        $response = $this->get(route('myTeam.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.teams.myteam.index');
    }

    //Authenticated user to myTeam.index returns 403
    public function test_teams_index_authenticated_user_returns_403(){
        $this->signInUser();
        $response = $this->get(route('myTeam.index'));
        $response->assertStatus(403);    
      }

    //Authenticated leader to myTeam.index returns accurate data
    public function test_teams_index_authenticated_admin_returns_correct_data(){
        $this->signInLeader();
        $response = $this->get(route('myTeam.index'));
        $team = Team::my()->first();
        $this->assertEquals($team, $response['team']);
        $this->assertEquals($team->members()->with('tasks')->get(), $response['members']);
    }
}
