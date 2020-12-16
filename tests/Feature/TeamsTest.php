<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Team;
use Tests\TestCase;

class TeamsTest extends TestCase
{

    /**
    * teams.index
    */

    //Unauthenticated to /teams redirect to /login
    public function test_teams_index_unauthenticated_redirects_to_login(){
        $response = $this->get(route('teams.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to teams returns view and 200
    public function test_teams_index_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('teams.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.teams.index');
    }

    //Authenticated leader to teams returns 403
    public function test_teams_index_authenticated_leader_returns_403(){
        $this->signInLeader();
        $response = $this->get(route('teams.index'));
        $response->assertStatus(403);
    }

    //Authenticated user to teams returns 403
    public function test_teams_index_authenticated_user_returns_403(){
        $this->signInUser();
        $response = $this->get(route('teams.index'));
        $response->assertStatus(403);    }

    //Authenticated admin to teams returns accurate data
    public function test_teams_index_authenticated_admin_returns_correct_data(){
        $this->signInAdmin();
        $response = $this->get(route('teams.index'));
        $this->assertEquals(Team::with('leader')->get(), $response['teams']);
    }

    /**
     * team.view
     */
   //Unauthenticated to teams.show redirect to /login
    public function test_teams_show_unauthenticated_redirects_to_login(){
        $response = $this->get(route('teams.show', ['team' => 1]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to teams.show returns view and 200
    public function test_teams_show_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('teams.show', ['team' => 1]));
        $response->assertStatus(200);
        $response->assertViewIs('views.teams.show');
    }

    //Authenticated leader to teams.show returns 403
    public function test_teams_show_authenticated_leader_returns_403(){
        $this->signInLeader();
        $response = $this->get(route('teams.show', ['team' => 1]));
        $response->assertStatus(403);
    }

    //Authenticated user to teams.show returns 403
    public function test_teams_show_authenticated_user_returns_403(){
        $this->signInUser();
        $response = $this->get(route('teams.show', ['team' => 1]));
        $response->assertStatus(403);    }

    //Authenticated admin to teams.show returns accurate data
    public function test_teams_show_authenticated_admin_returns_correct_data(){
        $this->signInAdmin();
        $response = $this->get(route('teams.show', ['team' => 1]));
        $this->assertEquals(Team::find(1), $response['team']);
        $this->assertEquals(Team::find(1)->members()->with('tasks')->get(), $response['members']);
    }

}
