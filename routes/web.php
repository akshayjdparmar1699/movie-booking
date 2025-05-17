<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TheaterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('theaters.index');
});
Route::get('movies/fetch', [MovieController::class, 'fetch'])->name('movies.fatch');
Route::resource('/movies', MovieController::class);

//Theaters
Route::get('theaters/fetch', [TheaterController::class, 'fetch'])->name('theaters.fetch');
Route::resource('/theaters', TheaterController::class);