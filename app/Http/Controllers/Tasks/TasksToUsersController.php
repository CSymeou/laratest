<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskToUserRequest;
use App\Models\Task;
use App\Models\User;

class TasksToUsersController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(user $user)
    {
        return view('views.tasks.taskstousers.create', [
            'user' => $user,
            'tasks' => Task::unassigned()->get()
        ]);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskToUserRequest $request, User $user)
    {
        $task = Task::where('id', $request->task_id)->first();
        $task->assignTo($user);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->unassign();
        return back();
    }
}
