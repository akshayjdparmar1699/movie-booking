<div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
    <h4 class="mb-4">Movie Booking</h4>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="{{ route('theaters.index') }}" class="nav-link text-white">Theaters</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('screens.index') }}" class="nav-link text-white">Screens</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('movies.index') }}" class="nav-link text-white">Movies</a>
        </li>
    </ul>
</div>
