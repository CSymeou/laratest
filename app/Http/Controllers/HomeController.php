<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('views.home.index', [
            'users' => User::orderByDesc('id')->get(),
            'tasks' => Task::orderByDesc('id')->paginate(10)
        ]);
    }
}