<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTheaterRequest;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index()
    {
        return view('theater.index');
    }

    public function fetch()
    {
        $theaters = Theater::all();

        return response()->json($theaters);
    }

    public function store(AddTheaterRequest $request)
    {
        $data = $request->validated();

        $theater = Theater::create($data);

        return response()->json($theater);
    }

    public function show(Theater $theater)
    {
        //
    }

    public function edit(Theater $theater)
    {
        //
    }

    public function update(Request $request, Theater $theater)
    {
        //
    }

    public function destroy(Theater $theater)
    {
        //
    }
}
