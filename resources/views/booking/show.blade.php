@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Book Your Seat for "{{ $movie->name }}"</h2>
        <p><strong>Theater:</strong> {{ $movie->screen->theater->name }}</p>
        <p><strong>Screen:</strong> {{ $movie->screen->name }}</p>

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
            <input type="hidden" name="screen_id" value="{{ $movie->screen->id }}">

            <div class="d-flex flex-wrap" style="max-width: 400px;">
                @foreach ($seats as $seat)
                    @php
                        $isBooked = in_array($seat->seat_number, $bookedSeats);
                    @endphp
                    <label style="width: 50px; margin: 5px;">
                        <input type="checkbox" name="seats[]" value="{{ $seat->seat_number }}"
                            {{ $isBooked ? 'disabled' : '' }}>
                        {{ $seat->seat_number }}
                    </label>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success mt-3">Confirm Booking</button>
        </form>
    </div>
@endsection
