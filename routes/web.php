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

//Redirect to home
Route::redirect('/', '/home', 301);

//Auth protected routes
Route::middleware(['auth'])-> group(function(){

  //Home
  Route::get('/home', 'App\Http\Controllers\HomeController@index')->middleware(['can:manage-tasks', 'can:manage-users'])->name('home.index');

  // Tasks
  Route::get('/tasks/create', 'App\Http\Controllers\Tasks\TasksController@create')->middleware('can:manage-tasks')->name('tasks.create');
  Route::post('/tasks', 'App\Http\Controllers\Tasks\TasksController@store')->middleware('can:manage-tasks')->name('tasks.store');
  Route::get('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\TasksController@edit')->middleware('can:manage-tasks')->name('tasks.edit');
  Route::patch('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\TasksController@update')->middleware('can:manage-tasks')->name('tasks.update');
  Route::delete('/tasks/{task}', 'App\Http\Controllers\Tasks\TasksController@destroy')->middleware('can:manage-tasks')->name('tasks.destroy');

  // My Tasks
  Route::get('/mytasks', 'App\Http\Controllers\Tasks\MyTasksController@index')->middleware('can:view-own-tasks')->name('myTasks.index');
  Route::get('/mytasks/{task}/edit', 'App\Http\Controllers\Tasks\MyTasksController@edit')->middleware('can:manage-own-task,task')->name('myTasks.edit');
  Route::patch('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\MyTasksController@update')->middleware('can:manage-own-task,task')->name('myTasks.update');

  // Teams
  Route::get('/teams', 'App\Http\Controllers\Teams\TeamsController@index')->middleware('can:view-teams')->name('teams.index');

  // Team users
  Route::get('/teamusers', 'App\Http\Controllers\Teams\TeamUsersController@index')->middleware('can:view-team')->name('teamUsers.index');
  Route::get('/teamusers/create', 'App\Http\Controllers\Teams\TeamUsersController@create')->middleware('can:manage-team')->name('teamUsers.create');
  Route::post('/teamusers', 'App\Http\Controllers\Teams\TeamUsersController@store')->middleware('can:manage-team')->name('teamUsers.store');
  Route::delete('/teamusers/{teamuser}', 'App\Http\Controllers\Teams\TeamUsersController@destroy')->middleware('can:manage-team')->name('teamUsers.destroy');

  // Users
  Route::get('/users/create', 'App\Http\Controllers\Users\UsersController@create')->middleware('can:manage-users')->name('users.create');
  Route::post('/users', 'App\Http\Controllers\Users\UsersController@store')->middleware('can:manage-users')->name('users.store');
  Route::get('/users/{user}/edit', 'App\Http\Controllers\Users\UsersController@edit')->middleware('can:manage-users')->name('users.edit');
  Route::patch('/users/{task}/edit', 'App\Http\Controllers\Users\UsersController@update')->middleware('can:manage-users')->name('users.update');
  Route::delete('/users/{task}', 'App\Http\Controllers\Users\UsersController@destroy')->middleware('can:manage-users')->name('users.destroy');

});
