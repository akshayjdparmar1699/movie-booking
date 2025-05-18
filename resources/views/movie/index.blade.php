@extends('layouts.main')

@section('content')
    <div class="container mt-4" id="movie-table">
        <div class="col-md-12 text-end">
            <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addMovieModal">Add Movies</button>
        </div>

        {{-- Add Movie Modal --}}
        <div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMovieModalLabel">Add Movie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addMovieForm">
                            <div class="mb-3">
                                <label for="theater_name" class="col-form-label">Theater Name</label>
                                <select class="form-select" name="theater_id" aria-label="Default select example">
                                    <option selected>Select Theater</option>
                                    @foreach ($theaters as $theater)
                                        <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error-theater_id"></div>
                            </div>

                            <div class="mb-3">
                                <label for="screen_name" class="col-form-label">Screen Name</label>
                                <select class="form-select" name="screen_id" aria-label="Default select example">
                                    <option selected>Select Screen</option>
                                    @foreach ($screens as $screen)
                                        <option value="{{ $screen->id }}">{{ $screen->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger error-screen_id"></div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <div class="text-danger error-name"></div>
                            </div>

                            <div class="mb-3">
                                <label for="director_name" class="col-form-label">Director Name</label>
                                <input type="text" class="form-control" name="director_name" id="director_name">
                                <div class="text-danger error-director_name"></div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="col-form-label">Upload Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <div class="text-danger error-image"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addMovie">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- /Add Movie Modal --}}
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Theater Name</th>
                    <th scope="col">Name</th>
                    <th scope="col">Director Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Booking Movie</th>
                </tr>
            </thead>
            <tbody id="movie-table-tr">

            </tbody>
        </table>
    </div>
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            getMovies();
        });

        function getMovies() {
            $.ajax({
                url: "{{ route('movies.fatch') }}",
                type: "get",
                success: function(response) {
                    response.forEach(movie => {
                        $('#movie-table-tr').append(`
<tr>
                    <th scope="row">${movie.id}</th>
                    <td>${movie.theater.name}</td>
                    <td>${movie.name}</td>
                    <td>${movie.director_name}</td>
                    <td><img src="{{ asset('storage/images/movie-image/${movie.image}') }}" alt="${movie.name}" style="max-width: 100px; height: auto;"></td>
                    <td>${movie.is_active ? 'Active' : 'Inactive'}</td>
                    <td>${movie.created_at}</td>
                    <td>
        <a href="/booking/${movie.id}/${movie.screen.id}" class="btn btn-primary">Book Seat</a>
    </td>
                </tr>
                        `)
                    });
                },
            });
        };

        $('#addMovie').click(function(e) {
            e.preventDefault();

            let form = document.getElementById('addMovieForm');
            let formData = new FormData(form);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('movies.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#movie-table').prepend(`
<div class="alert alert-primary" role="alert">
  Movie added successfully.
</div>
`);

                    $('#addMovieModal').modal('hide');
                    $('#addMovieForm')[0].reset();
                    getMovies();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.theater_id) {
                            $('.error-theater_id').text(errors.theater_id[0]);
                        }
                        if (errors.name) {
                            $('.error-name').text(errors.name[0]);
                        }
                        if (errors.director_name) {
                            $('.error-director_name').text(errors.director_name[0]);
                        }
                        if (errors.image) {
                            $('.error-image').text(errors.image[0]);
                        }
                        if (errors.screen_id) {
                            $('.error-screen_id').text(errors.screen_id[0]);
                        }
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },

            });

        });
    </script>
@endsection
@endsection
