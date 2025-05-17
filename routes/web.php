<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('movies/fetch', [MovieController::class, 'fetch'])->name('movies.fatch');
Route::resource('/movies', MovieController::class);