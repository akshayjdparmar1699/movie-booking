<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMovieRequest;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Theater;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $theaters = Theater::all();
        $screens = Screen::all();

        return view('movie.index', compact('theaters', 'screens'));
    }

    public function fetch()
    {
        $movies = Movie::with('theater', 'screen')->get();
        return response()->json($movies);
    }

    public function store(AddMovieRequest $request)
    {
        $data = $request->validated();

        $image = $request->file('image');

        $fileName = time() . 'image.' . $image->getClientOriginalExtension();

        $image->storeAs('images/movie-image', $fileName);

        $data['image'] = $fileName;

        $movie = Movie::create($data);

        return response()->json($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
