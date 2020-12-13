<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * Get the team leader
     */
    public function leader(){
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Get the members of the team
     */
    public function members(){
        return $this->hasMany(User::class, 'team_id');
    }
}
