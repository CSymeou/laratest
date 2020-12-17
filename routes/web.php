<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth routes
Auth::routes();

//Auth protected routes
Route::middleware(['auth'])-> group(function(){

  //Redirect to home
  Route::redirect('/', '/home', 301)->name('root');

  //Home
  Route::get('/home', 'App\Http\Controllers\HomeController@index')->middleware(['can:manage-tasks', 'can:view-users'])->name('home.index');

  // Tasks
  Route::get('/tasks/create', 'App\Http\Controllers\Tasks\TasksController@create')->middleware('can:manage-tasks')->name('tasks.create');
  Route::post('/tasks', 'App\Http\Controllers\Tasks\TasksController@store')->middleware('can:manage-tasks')->name('tasks.store');
  Route::get('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\TasksController@edit')->middleware('can:manage-tasks')->name('tasks.edit');
  Route::patch('/tasks/{task}/', 'App\Http\Controllers\Tasks\TasksController@update')->middleware('can:manage-tasks')->name('tasks.update');
  Route::delete('/tasks/{task}', 'App\Http\Controllers\Tasks\TasksController@destroy')->middleware('can:manage-tasks')->name('tasks.destroy');

  // My Tasks
  Route::get('/mytasks', 'App\Http\Controllers\Tasks\MyTasksController@index')->middleware('can:view-own-tasks')->name('myTasks.index');

  //Task Progress management
  Route::get('/tasks/{task}/progress/edit', 'App\Http\Controllers\Tasks\TaskProgressController@edit')->middleware('can:manage-own-task,task')->name('taskProgress.edit');
  Route::patch('/task/{task}/progress/', 'App\Http\Controllers\Tasks\TaskProgressController@update')->middleware('can:manage-own-task,task')->name('taskProgress.update');

  //Assign Task to User
  Route::get('/users/{user}/tasksassignment/create', 'App\Http\Controllers\Tasks\TasksToUsersController@create')->middleware('can:manage-tasks')->name('tasksToUsers.create');
  Route::post('/users/{user}/taskassignment/', 'App\Http\Controllers\Tasks\TasksToUsersController@store')->middleware('can:manage-tasks')->name('tasksToUsers.store');
  Route::delete('/tasks/{task}/userassignment', 'App\Http\Controllers\Tasks\TasksToUsersController@destroy')->middleware('can:manage-tasks')->name('tasksToUsers.destroy');

  // Teams
  Route::get('/teams', 'App\Http\Controllers\Teams\TeamsController@index')->middleware('can:view-teams')->name('teams.index');
  Route::get('/teams/{team}', 'App\Http\Controllers\Teams\TeamsController@show')->middleware('can:view-team')->name('teams.show');

  // My Team
  Route::get('/teams/my', 'App\Http\Controllers\Teams\MyTeamController@index')->middleware('can:view-own-team')->name('myTeam.index');

  // Team Members
  Route::get('/teams/{team}/members/create', 'App\Http\Controllers\Teams\TeamMembersController@create')->middleware('can:manage-team,team')->name('teamMembers.create');
  Route::post('/teams/{team}/members', 'App\Http\Controllers\Teams\TeamMembersController@store')->middleware('can:manage-team,team')->name('teamMembers.store');
  Route::delete('/teams/{team}/members/{user}', 'App\Http\Controllers\Teams\TeamMembersController@destroy')->middleware('can:manage-team,team')->name('teamMembers.destroy');

  // Users
  Route::get('/users/create', 'App\Http\Controllers\Users\UsersController@create')->middleware('can:create-users')->name('users.create');
  Route::post('/users', 'App\Http\Controllers\Users\UsersController@store')->middleware('can:create-users')->name('users.store');
  Route::get('/users/{user}/edit', 'App\Http\Controllers\Users\UsersController@edit')->middleware('can:edit-users,user')->name('users.edit');
  Route::patch('/users/{user}', 'App\Http\Controllers\Users\UsersController@update')->middleware('can:edit-users,user')->name('users.update');
  Route::delete('/users/{user}', 'App\Http\Controllers\Users\UsersController@destroy')->middleware('can:edit-users,user')->name('users.destroy');

});
