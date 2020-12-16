<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Get the user Task is assigned to
     */
    public function assignedTo(){
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get tasks with no user assigned
     */
    public function scopeUnassigned($query){
        return $query->where('assignee_id', null);
    }

    /**
     * Get tasks assigned to currently auth user
     */
    public function scopeMy($query){
        return $query->where('assignee_id', auth()->id());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task $task
     * @return \App\Models\Task $task
     */
    public static function store($request, $task = null){
        $task = $task ?: new self;
        $task->name = $request->name;
        $task->assignee_id = $request->assignee_id;
        return $task->save();
    }

    /**
     * @return \App\Models\Task $task
     */
    public function unassign(){
        $this->assignee_id = null;
        return $this->save();
    }

    /**
     * @return \App\Models\Task $task
     */
    public function assignTo($user){
        $this->assignee_id = $user->id;
        return $this->save();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Task $task
     */
    public function updateProgress($request){
        $this->progress = $request->progress;
        return $this->save();
    }

}
