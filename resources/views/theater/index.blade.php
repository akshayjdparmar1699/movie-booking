@extends('layouts.main')

@section('content')
    <div class="container mt-4" id="theater-table">
        <div class="col-md-12 text-end">
            <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addTheaterModal">Add Theater</button>
        </div>

        {{-- Add Movie Modal --}}
        <div class="modal fade" id="addTheaterModal" tabindex="-1" aria-labelledby="addTheaterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTheaterModalLabel">Add Movie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTheaterForm">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <div class="text-danger error-name"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addTheater">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- /Add Movie Modal --}}
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody id="theater-table-tr">

            </tbody>
        </table>
    </div>
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            getTheaters();
        });

        function getTheaters() {
            $.ajax({
                url: "{{ route('theaters.fetch') }}",
                type: "GET",
                success: function(response) {
                    response.forEach(theater => {
                        $('#theater-table-tr').append(`
<tr>
                    <th scope="row">${theater.id}</th>
                    <td>${theater.name}</td>
                    <td>${theater.is_active == 1 ? 'Active' : 'Inactive'}</td>
                    <td>${theater.created_at}</td>
                </tr>
                        `)
                    });
                },
            });
        };

        $('#addTheater').click(function(e) {
            e.preventDefault();

            let form = document.getElementById('addTheaterForm');
            let formData = new FormData(form);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('theaters.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#theater-table').prepend(`
<div class="alert alert-primary" role="alert">
  Theater added successfully.
</div>
`);

                    $('#addTheaterModal').modal('hide');
                    $('#addTheaterForm')[0].reset();
                    getTheaters();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('.error-name').text(errors.name[0]);
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
