<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;

class MyTasksTest extends TestCase
{
    /**
    * myTasks.index
    */

    //Unauthenticated to /myTasks redirect to /login
    public function test_myTasks_index_unauthenticated_redirects_to_login(){
        $response = $this->get(route('myTasks.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to myTasks returns 403 Forbidden
    public function test_myTasks_index_authenticated_admin_403(){
        $this->signInAdmin();
        $response = $this->get(route('myTasks.index'));
        $response->assertStatus(403);
    }

    //Authenticated leader to myTasks returns 403
    public function test_myTasks_index_authenticated_leader_returns_403(){
        $this->signInLeader();
        $response = $this->get(route('myTasks.index'));
        $response->assertStatus(403);
    }

    //Authenticated user to myTasks returns view and 200
    public function test_myTasks_index_authenticated_user_returns_view(){
        $this->signInUser();
        $response = $this->get(route('myTasks.index'));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.mytasks.index');
      }

    //Authenticated user to myTasks returns accurate data
    public function test_myTasks_index_view_contains_accurate_data(){
        $this->signInUser();
        $response = $this->get(route('myTasks.index'));
        $this->assertEquals(Task::where('assignee_id', auth()->id())->get(), $response['tasks']);
    }
}
