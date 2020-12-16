<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Tests\TestCase;
use App\Models\User;

class TaskProgressTest extends TestCase
{
    protected $user;
    protected $task;

    public function setup() : void{
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create([
            'assignee_id' => $this->user->id,
            'progress' => 60
        ]);
    }

    /**
    * taskProgress.edit
    */

    //Unauthenticated to taskProgress redirect to /login
    public function test_taskProgress_edit_unauthenticated_redirects_to_login(){
        $response = $this->get(route('taskProgress.edit', ['task' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Edit task assigned to another user returns 403
    public function test_taskProgress_edit_unassigned_task_403(){
        $this->signInUser();
        $response = $this->get(route('taskProgress.edit', ['task'=> $this->task->id]));
        $response->assertStatus(403);
    }

    //Edit task assigned to user returns correct view
    public function test_taskProgress_edit_authenticated_user_returns_view(){
        $this->signIn($this->user);
        $response = $this->get(route('taskProgress.edit', ['task'=> $this->task->id]));
        $response->assertStatus(200);
        $response->assertViewIs('views.tasks.progress.edit');
      }

    //Edit task assigned to user returns correct view
    public function test_taskProgress_edit_view_contains_accurate_data(){
        $this->signIn($this->user);
        $response = $this->get(route('taskProgress.edit', ['task'=> $this->task->id]));
        $this->assertEquals(Task::find($this->task->id), $response['task']);
    }

    /**
    * taskProgress.update
    */
    //Unauthenticated to taskProgress.update redirect to /ogin
    public function test_taskProgress_update_unauthenticated_redirects_to_login(){
        $response = $this->patch(route('taskProgress.update', ['task' => $this->task->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    //Progress missing leads to error
    public function test_taskProgress_update_no_progress_error(){
        $this->signIn($this->user);
        $response = $this->patch(
            route('taskProgress.update', ['task' => $this->task->id])
        );
        $response->assertSessionHasErrors('progress');
    }

    //Progress above 100 leads to error
    public function test_taskProgress_update_progress_over_100_error(){
        $this->signIn($this->user);
        $response = $this->patch(
            route('taskProgress.update', ['task' => $this->task->id]),
            [
                'progress' => 110
            ]
         );
        $response->assertSessionHasErrors('progress');
    }

    //Progress not numeric leads to error
    public function test_taskProgress_update_progress_alpha_error(){
        $this->signIn($this->user);
        $response = $this->patch(
            route('taskProgress.update', ['task' => $this->task->id]),
            [
                'progress' => 'ABC'
            ]
         );
        $response->assertSessionHasErrors('progress');
    }

    //Update of task not assigned to user leads to 403
    public function test_taskProgress_update_not_assigned_task_403(){
        $this->signInUser();
        $response = $this->patch(
            route('taskProgress.update', ['task' => $this->task->id]),
            [
                'progress' => 90
            ]
         );
        $response->assertStatus(403);
    }

    //Update of task leads to db update 
    public function test_taskProgress_update_updates_db(){
        $this->signIn($this->user);
        $this->patch(
            route('taskProgress.update', ['task' => $this->task->id]),
            [
                'progress' => 90
            ]
         );
        $this->assertDatabaseHas('tasks', ['id' => $this->task->id, 'progress' => 90]);
    }

    //Update of task redirects to my task 
    public function test_taskProgress_redirects_to_my_tasks(){
        $this->signIn($this->user);
        $response = $this->patch(
            route('taskProgress.update', ['task' => $this->task->id]),
            [
                'progress' => 90
            ]
         );
        $response->assertStatus(302);
        $response->assertRedirect(route('myTasks.index'));
    }
}
