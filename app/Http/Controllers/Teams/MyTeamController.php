<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class MyTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::my()->first();
        return view('views.teams.myteam.index',[
            'team' => $team,
            'members' => $team->members()->with('tasks')->get()
        ]);
    }
}
