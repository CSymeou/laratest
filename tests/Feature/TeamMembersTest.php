<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Team;
use Tests\TestCase;
use App\Models\User;

class teamMembersTest extends TestCase
{
    public function setup() : void{
        parent::setUp();
        $this->leader = User::factory()->create([
            'role' => 'leader'
        ]);
        $this->anotherLeader = User::factory()->create([
            'role' => 'leader'
        ]);
        $this->team = Team::factory()->create([
            'leader_id' => $this->leader->id
        ]);
        $this->user = User::factory()->create([
            'team_id' => $this->team->id
        ]);
        $this->unassigned_user = User::factory()->create([
            'team_id' => null
        ]);
    }

    /**
    * teamMembers.create
    */

    //Unauthenticated to teamMembers redirect to /login
    public function test_teamMembers_create_unauthenticated_redirects_to_login(){
        $response = $this->get(route('teamMembers.create', ['team' => $this->team->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Create route assign user to non existant team creates 404
    public function test_teamMembers_create_team_not_exists_404(){
        $this->signIn($this->leader);
        $response = $this->get(route('teamMembers.create', ['team'=> 'Nan']));
        $response->assertStatus(404);
    }

    //Create route assign user to team not leader of leads to 403 
    public function test_teamMembers_create_team_not_leader_of_403(){
        $this->signInUser($this->anotherLeader);
        $response = $this->get(route('teamMembers.create', ['team'=> $this->team->id]));
        $response->assertStatus(403);
    }

    //Create route Assign user to team leader of returns 200
    public function test_teamMembers_create_team_leader_of_returns_view_200(){
        $this->signIn($this->leader);
        $response = $this->get(route('teamMembers.create', ['team'=> $this->team->id]));
        $response->assertStatus(200);
        $response->assertViewIs('views.teams.teammembers.create');
      }

    //Create route Assign user to team leader of returns correct data
    public function test_teamMembers_create_view_contains_accurate_data(){
        $this->signIn($this->leader);
        $response = $this->get(route('teamMembers.create', ['team'=> $this->team->id]));
        $this->assertEquals(User::user()->unassigned()->get(), $response['users']);
        $this->assertEquals(Team::find($this->team->id), $response['team']);
    }

    /**
    * teamMembers.store
    */

    //Unauthenticated to teamMembers redirect to login
    public function test_teamMembers_store_unauthenticated_redirects_to_login(){
        $response = $this->post(route('teamMembers.store', ['team' => $this->team->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //User id missing leads to error
    public function test_teamMembers_store_no_user_id_error(){
        $this->signIn($this->leader);
        $response = $this->post(
            route('teamMembers.store', ['team' => $this->team->id])
        );
        $response->assertSessionHasErrors('user_id');
    }

    //User id that does not exist in db leads to error
    public function test_teamMembers_store_user_id_not_db_error(){
        $this->signIn($this->leader);
        $response = $this->post(
            route('teamMembers.store', ['team' => $this->team->id]),
            [
                'user_id' => 999
            ]
         );
        $response->assertSessionHasErrors('user_id');
    }

    //Attempt to store user in team not leader of leads to 403
    public function test_teamMembers_store_in_team_not_leader_of_is_403(){
        $this->signIn($this->anotherLeader);
        $response = $this->post(route('teamMembers.store', ['team' => $this->team->id]));
        $response->assertStatus(403);
    }

    //TeamMembers store updates db when valid
    public function test_teamMembers_store_updates_db(){
        $this->signIn($this->leader);
        $this->post(
            route('teamMembers.store', ['team' => $this->team->id]),
            [
                'user_id' => $this->unassigned_user->id
            ]
         );
        $this->assertDatabaseHas('users', [
            'id' => $this->unassigned_user->id, 
            'team_id' => $this->team->id
        ]);
    }

    /**
     * teamMembers.destroy route
     */

    //Unauthenticated request leads to 302
    public function test_teamMembers_destroy_unauthenticated_redirects_login(){
      $response = $this->delete(route('teamMembers.destroy', [
          'team' => $this->team->id,
          'user' => $this->user->id]));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Authenticated request to unassign from non existant team 404
    public function test_teamMembers_destroy_nonexistent_team_404(){
      $this->signIn($this->leader);
      $response = $this->delete(route('teamMembers.destroy', [
          'team' => 'Nan',
          'user' => $this->user->id]));
      $response->assertStatus(404);
    }

    //Authenticated request to unassign non existant user 404
    public function test_teamMembers_destroy_nonexistent_user_404(){
      $this->signIn($this->leader);
      $response = $this->delete(route('teamMembers.destroy', [
          'team' => $this->team->id,
          'user' => 'Nan']));
      $response->assertStatus(404);
    }

    //Authenticated request to unassign user from team not leader of 403
    public function test_teamMembers_destroy_team_not_leader_of_403(){
      $this->signIn($this->anotherLeader);
      $response = $this->delete(route('teamMembers.destroy', [
          'team' => $this->team->id,
          'user' => $this->user->id]));
      $response->assertStatus(403);
    }

    //Authenticated request to unassign user when correct leads to db update
    public function test_teamMembers_destroy_valid_sets_assignee_id_to_null(){
      $this->signIn($this->leader);
      $response = $this->delete(route('teamMembers.destroy', [
          'team' => $this->team->id,
          'user' => $this->user->id]));
      $this->assertDatabaseHas('users', ['id' => $this->user->id, 'team_id' => null]);
    }
}
