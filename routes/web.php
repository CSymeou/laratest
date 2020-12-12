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

//Dashboard
Route::get('/', function () {
    return view('welcome');
});

// Tasks
Route::get('/tasks/create', function () {
    return view('welcome');
});

Route::post('/tasks', function () {
    return view('welcome');
});

Route::get('/tasks/{task}/edit', function () {
    return view('welcome');
});

Route::patch('/tasks/{task}/edit', function () {
    return view('welcome');
});

Route::delete('/tasks/{task}', function () {
    return view('welcome');
});

Route::get('/users/create', function () {
    return view('welcome');
});

// Users
Route::get('/users/create', function () {
    return view('welcome');
});

Route::post('/users', function () {
    return view('welcome');
});

Route::get('/users/{user}/edit', function () {
    return view('welcome');
});

Route::patch('/users/{task}/edit', function () {
    return view('welcome');
});

Route::delete('/users/{task}', function () {
    return view('welcome');
});

// My Tasks
Route::get('/mytasks', function () {
    return view('welcome');
});

Route::get('/mytasks/{task}/edit', function () {
    return view('welcome');
});

Route::patch('/tasks/{task}/edit', function () {
    return view('welcome');
});

// Team tasks
Route::get('/teamtasks', function () {
    return view('welcome');
});

// Team leaders
Route::get('/teamleaders', function () {
    return view('welcome');
});