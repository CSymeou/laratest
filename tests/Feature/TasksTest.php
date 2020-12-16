<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;

class TasksTest extends TestCase
{
    //Valid task data for testing
    public $task = [
      'name' => 'Updated task',
      'assignee_id' => 1
    ];

    /**
     * tasks.create route
     */

    //Unauthenticated to tasks.create redirect to /login
    public function test_tasks_create_unauthenticated_redirects_to_login(){
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to tasks.create returns view and 200
    public function test_tasks_create_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.create');
    }

    //Authenticated leader to tasks.create returns view and 200
    public function test_tasks_create_authenticated_leader_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.create');
    }

    //Authenticated user to tasks.create returns view and 200
    public function test_tasks_create_authenticated_user_shows_correct_view(){
        $this->signInUser();
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.create');
    }

    /**
     * tasks.edit route
     */

   //Unauthenticated to tasks.edit redirect to /login
    public function test_tasks_edit_unauthenticated_redirects_to_login(){
        $response = $this->get(route('tasks.edit', ['task'=> 1]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Authenticated admin to tasks.edit returns view and 200
    public function test_tasks_edit_authenticated_admin_shows_correct_view(){
        $this->signInAdmin();
        $response = $this->get(route('tasks.edit', ['task'=> 1]));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.edit');
    }

    //Authenticated leader to tasks.edit returns view and 200
    public function test_tasks_edit_authenticated_leader_shows_correct_view(){
        $this->signInLeader();
        $response = $this->get(route('tasks.edit', ['task'=> 1]));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.edit');
    }

    //Authenticated user to tasks.edit returns view and 200
    public function test_tasks_edit_authenticated_user_shows_correct_view(){
        $this->signInUser();
        $response = $this->get(route('tasks.edit', ['task'=> 1]));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.edit');
    }

    //Request to tasks.edit with invalid id returns 404
    public function test_tasks_edit_invalid_task_returns_404(){
        $this->signInUser();
        $response = $this->get(route('tasks.edit', ['task'=> 'NaN']));
        $response->assertStatus(404);
    }

    /**
     * tasks.store route
     */

    //Unauthenticated request leads to 'login'
    public function test_tasks_store_unauthenticated_redirects_login(){
      $response = $this->post(route('tasks.store'));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Request missing name returns error
    public function test_tasks_store_authenticated_no_name_error(){
      $this->signInUser();
      $response = $this->post(route('tasks.store'));      $response->assertSessionHasErrors(['name']);
      $response->assertSessionDoesntHaveErrors(['assignee_id']);
    }
    
    //Request with name above 255 chars returns error
    public function test_tasks_store_authenticated_long_name_error(){
      $this->signInUser();
      $response = $this->post(route('tasks.store'), [
        'name' => str_repeat('A', 256)]
      );      
      $response->assertSessionHasErrors(['name']);
      $response->assertSessionDoesntHaveErrors(['assignee_id']);
    }

    //Request with invalid assignee_id returns error
    public function test_tasks_store_invalid_assignee_error(){
      $this->signInUser();
      $response = $this->post(route('tasks.store'), [
        'name' => 'Task 10',
        'assignee_id' => 'NaN'
      ]);      
      $response->assertSessionHasErrors(['assignee_id']);
      $response->assertSessionDoesntHaveErrors(['name']);
    }

    //Request with correct data add to database
    public function test_tasks_store_valid_perists_to_db(){
      $this->signInUser();
      $this->post(route('tasks.store'), $this->task);      
      $this->assertDatabaseHas('tasks', $this->task);
    }

    //Request with correct data redirects to hom
    public function test_tasks_store_valid_redirects_home(){
      $this->signInUser();
      $response = $this->post(route('tasks.store'), $this->task);      
      $response->assertStatus(302);
      $response->assertRedirect(route('home.index'));
    }

    /**
     * tasks.update route
     */
    //Unauthenticated request leads to 'login'
    public function test_tasks_update_unauthenticated_redirects_login(){
      $task = Task::first();
      $response = $this->patch(route('tasks.update', ['task' => $task->id] ));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Request missing name returns error
    public function test_tasks_update_authenticated_no_name_error(){
      $task = Task::first();
      $this->signInUser();
      $response = $this->patch(route('tasks.update', ['task' => $task->id]));    
      $response->assertSessionHasErrors(['name']);
      $response->assertSessionDoesntHaveErrors(['assignee_id']);
    }
    
    //Request with name above 255 chars returns error
    public function test_tasks_update_authenticated_long_name_error(){
      $task = Task::first();
      $this->signInUser();
      $response = $this->patch(route('tasks.update', ['task' => $task->id]), [
        'name' => str_repeat('A', 256)]
      );      
      $response->assertSessionHasErrors(['name']);
      $response->assertSessionDoesntHaveErrors(['assignee_id']);
    }

    //Request with invalid assignee_id returns error
    public function test_tasks_update_invalid_assignee_error(){
      $task = Task::first();
      $this->signInUser();
      $response = $this->patch(route('tasks.update', ['task' => $task->id]), [
        'name' => 'Task 10',
        'assignee_id' => 'NaN'
      ]);      
      $response->assertSessionHasErrors(['assignee_id']);
      $response->assertSessionDoesntHaveErrors(['name']);
    }

    //Request with correct data to update invalid task results in 404
    public function test_tasks_update_invalid_id_leads_to_db(){
      $this->signInUser();
      $response = $this->patch(route('tasks.update', ['task' => 'NaN']), $this->task);
      $response->assertStatus(404);
    }

    //Request with correct data to update valid task results in db update
    public function test_tasks_update_valid_id_updates_db(){
      $task = Task::first();
      $this->signInUser();
      $this->patch(route('tasks.update', ['task' => $task->id]), $this->task);
      $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'name' => $this->task['name'],
        'assignee_id' => $this->task['assignee_id']
      ]);
    }

    //Request with correct data to update task redirects to home
    public function test_tasks_update_valid_redirects_home(){
      $task = Task::first();
      $this->signInUser();
      $response = $this->patch(route('tasks.update', ['task' => $task->id]), $this->task);
      $response->assertStatus(302);
      $response->assertRedirect(route('home.index'));
    }

    /**
     * tasks.destroy route
     */

    //Unauthenticated request leads to 405
    public function test_tasks_destroy_unauthenticated_redirects_login(){
      $task = Task::first();
      $response = $this->delete(route('tasks.destroy', ['task' => $task->id]));
      $response->assertStatus(302);
      $response->assertRedirect(route('login'));
    }

    //Authenticated request to delete non existent task leads to 404
    public function test_tasks_destroy_nonexistent_task_404(){
      $this->signInUser();
      $response = $this->delete(route('tasks.destroy', ['task' => 'NaN']));
      $response->assertStatus(404);
    }

    //Request with correct data removes from db from user
    public function test_tasks_destroy_valid_from_user_removes_from_db(){
      $task = Task::first();
      $this->signInUser();
      $this->delete(route('tasks.destroy', ['task' => $task->id]));      
      $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    //Request with correct data removes from db from user
    public function test_tasks_destroy_valid_from_leader_removes_from_db(){
      $task = Task::first();
      $this->signInLeader();
      $this->delete(route('tasks.destroy', ['task' => $task->id]));      
      $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    //Request with correct data removes from db from user
    public function test_tasks_destroy_valid_from_admin_removes_from_db(){
      $task = Task::first();
      $this->signInAdmin();
      $this->delete(route('tasks.destroy', ['task' => $task->id]));      
      $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

}
