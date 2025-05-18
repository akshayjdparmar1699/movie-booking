<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddScreenRequest;
use App\Models\Screen;
use App\Models\Theater;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        $theaters = Theater::all();

        return view('screen.index', compact('theaters'));
    }

    public function fetch()
    {
        $screens = Screen::with('theater')->get();

        return response()->json($screens);
    }

    public function store(AddScreenRequest $request)
    {
        $data = $request->validated();

        $screen = Screen::create($data);

        return response()->json($screen);
    }

    /**
     * Display the specified resource.
     */
    public function show(Screen $screen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screen $screen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Screen $screen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screen $screen)
    {
        //
    }
}
