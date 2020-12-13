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

//Auth
Auth::routes();

//Redirects
Route::redirect('/', '/home', 301);
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home.index');

// Tasks
Route::get('/tasks/create', 'App\Http\Controllers\Tasks\TasksController@create')->name('tasks.create');
Route::post('/tasks', 'App\Http\Controllers\Tasks\TasksController@store')->name('tasks.store');
Route::get('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\TasksController@edit')->name('tasks.edit');
Route::patch('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\TasksController@update')->name('tasks.update');
Route::delete('/tasks/{task}', 'App\Http\Controllers\Tasks\TasksController@destroy')->name('tasks.destroy');

// My Tasks
Route::get('/mytasks', 'App\Http\Controllers\Tasks\MyTasksController@index')->name('myTasks.index');
Route::get('/mytasks/{task}/edit', 'App\Http\Controllers\Tasks\MyTasksController@edit')->name('myTasks.edit');
Route::patch('/tasks/{task}/edit', 'App\Http\Controllers\Tasks\MyTasksController@update')->name('myTasks.update');

// Team users
Route::get('/teamusers', 'App\Http\Controllers\Teams\TeamUsersController@index')->name('teamUsers.index');
Route::get('/teamusers/create', 'App\Http\Controllers\Teams\TeamUsersController@create')->name('teamUsers.create');
Route::post('/teamusers', 'App\Http\Controllers\Teams\TeamUsersController@store')->name('teamUsers.store');
Route::delete('/teamusers/{teamuser}', 'App\Http\Controllers\Teams\TeamUsersController@destroy')->name('teamUsers.destroy');

// Teams
Route::get('/teams', 'App\Http\Controllers\Teams\TeamsController@index')->name('teams.index');

// Users
Route::get('/users/create', 'App\Http\Controllers\Users\UsersController@create')->name('users.create');
Route::post('/users', 'App\Http\Controllers\Users\UsersController@store')->name('users.store');
Route::get('/users/{user}/edit', 'App\Http\Controllers\Users\UsersController@edit')->name('users.edit');
Route::patch('/users/{task}/edit', 'App\Http\Controllers\Users\UsersController@update')->name('users.update');
Route::delete('/users/{task}', 'App\Http\Controllers\Users\UsersController@destroy')->name('users.destroy');
