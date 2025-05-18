<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Seat;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show($movieId, $screenId)
    {
        $movie = Movie::with(['screen.theater'])->findOrFail($movieId);
        $seats = Seat::where('screen_id', $screenId)->get();

        $bookedSeats = Booking::where('movie_id', $movieId)
            ->where('screen_id', $screenId)
            ->get()
            ->flatMap(function ($booking) {
                return json_decode($booking->seats, true);
            })
            ->toArray();

        return view('booking.show', compact('movie', 'seats', 'bookedSeats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'screen_id' => 'required|exists:screens,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'string',
        ]);

        $movieId = $request->movie_id;
        $screenId = $request->screen_id;
        $selectedSeats = $request->seats;

        $alreadyBooked = Booking::where('movie_id', $movieId)
            ->where('screen_id', $screenId)
            ->get()
            ->flatMap(function ($booking) {
                return json_decode($booking->seats, true);
            })
            ->toArray();

        $conflicts = array_intersect($alreadyBooked, $selectedSeats);
        if (!empty($conflicts)) {
            return back()->with('error', 'Some seats are already booked: ' . implode(', ', $conflicts));
        }

        Booking::create([
            'movie_id' => $movieId,
            'screen_id' => $screenId,
            'booking_date' => now()->toDateString(),
            'seats' => json_encode($selectedSeats),
        ]);

        return redirect()->route('movies.index')->with('success', 'Seats booked successfully!');
    }
}
