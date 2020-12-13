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
}
