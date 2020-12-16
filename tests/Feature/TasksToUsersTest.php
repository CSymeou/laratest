<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;
use App\Models\User;

class TasksToUsersTest extends TestCase
{
    protected $user;
    protected $task;

    public function setup() : void{
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create([
            'assignee_id' => null,
            'progress' => 60
        ]);
        $this->assigned_task = Task::factory()->create([
            'assignee_id' => $this->user->id
        ]);
    }

    /**
    * tasksToUsers.create
    */

    //Unauthenticated to tasksToUsers redirect to /login
    public function test_task_to_tasksToUsers_create_unauthenticated_redirects_to_login(){
        $response = $this->get(route('tasksToUsers.create', ['user' => $this->user->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Create route Assign tasks to non existant user creates 404
    public function test_task_to_tasksToUsers_create_unassigned_task_403(){
        $this->signInUser();
        $response = $this->get(route('tasksToUsers.create', ['user'=> 'Nan']));
        $response->assertStatus(404);
    }

    //Create route Assign tasks to user returns 200
    public function test_task_to_tasksToUsers_create_authenticated_returns_view_200(){
        $this->signIn($this->user);
        $response = $this->get(route('tasksToUsers.create', ['user'=> $this->user->id]));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.taskstousers.create');
      }

    //Create route Assign tasks to user returns correct data
    public function test_task_to_tasksToUsers_create_view_contains_accurate_data(){
        $this->signIn($this->user);
        $response = $this->get(route('tasksToUsers.create', ['user'=> $this->user->id]));
        $this->assertEquals(Task::unassigned()->get(), $response['tasks']);
    }

    /**
    * tasksToUsers.store
    */

    //Unauthenticated to tasksToUsers redirect to login
    public function test_tasksToUsers_store_unauthenticated_redirects_to_login(){
        $response = $this->post(route('tasksToUsers.store', ['user' => $this->user->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Task id missing leads to error
    public function test_tasksToUsers_store_no_task_id_error(){
        $this->signIn($this->user);
        $response = $this->post(
            route('tasksToUsers.store', ['user' => $this->user->id])
        );
        $response->assertSessionHasErrors('task_id');
    }

    //Task id that does not exist in db leads to error
    public function test_tasksToUsers_store_task_id_not_db_error(){
        $this->signIn($this->user);
        $response = $this->post(
            route('tasksToUsers.store', ['user' => $this->user->id]),
            [
                'task_id' => 999
            ]
         );
        $response->assertSessionHasErrors('task_id');
    }

    //Tasks to users store updates db when valid
    public function test_tasksToUsers_store_updates_db(){
        $this->signIn($this->user);
        $this->post(
            route('tasksToUsers.store', ['user' => $this->user->id]),
            [
                'task_id' => $this->task->id
            ]
         );
        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id, 
            'assignee_id' => $this->user->id
        ]);
    }

    /**
     * tasksToUsers.destroy route
     */

    //Unauthenticated request leads to 405
    public function test_tasksToUsers_destroy_unauthenticated_redirects_login(){
      $response = $this->delete(route('tasksToUsers.destroy', ['task' => $this->assigned_task->id]));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Authenticated request to delete non existent user leads to 403
    public function test_tasksToUsers_destroy_nonexistent_task_404(){
      $this->signInUser();
      $response = $this->delete(route('tasksToUsers.destroy', ['task' => 'NaN']));
      $response->assertStatus(404);
    }

    //Request with correct data sets task to unassigned
    public function test_tasksToUsers_destroy_valid_sets_assignee_id_to_null(){
      $this->signInUser();
      $this->delete(route('tasksToUsers.destroy', ['task' => $this->assigned_task->id]));      
      $this->assertDatabaseHas('tasks', ['id' => $this->assigned_task->id, 'assignee_id' => null]);
    }
}
