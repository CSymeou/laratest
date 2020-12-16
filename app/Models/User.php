<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PDO;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns the tasks that are assigned to this user
     */
    public function tasks(){
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Return the tean that the user belongs to
     */
    public function team(){
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Return the team that the user owns
     */
    public function isLeaderOf(){
        return $this->hasOne(Team::class, 'leader_id');
    }

    /**
     * Scope a query to only include admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include leader users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLeader($query)
    {
        return $query->where('role', 'leader');
    }

    /**
     * Scope a query to only include user users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }

    
    /* Scope a query to only include unassigned users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnassigned($query){
        return $query->where('team_id', null);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \App\Models\User $user
     */
    public static function store($request, $edited_user = null){
        $user = $edited_user ?: new self;
        $user->name = $request->name;
        $user->email = $request->email;
        //Hacky solution to add details of new users as given Laravel auth bootstrap
        if($edited_user == null){       
            $user->email_verified_at = now();
            $user->role = 'user';
        }
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        return $user->save();
    }

    /**
     * function to assign user to team
     * 
     * @param  \App\Models\Team $team
     * @return \App\Models\User $user
     */
    public function assignTo($team){
        $this->team_id = $team->id;
        return $this->save();
    }

    /**
     * function to unassign team from user
     * 
     * @param  \App\Models\Team $team
     * @return \App\Models\User $user
     */
    public function unassign(){
        $this->team_id = null;
        return $this->save();
    }
}
