<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Requests\StoreTeamMembersRequest;
use App\Models\User;

class TeamMembersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Team $team)
    {
        return view('views.teams.teammembers.create',[
            'team' => $team,
            'users' => User::user()->unassigned()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamMembersRequest $request, Team $team)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->assignTo($team);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team, User $user)
    {
        $user->unassign();
        return back();
    }
}
