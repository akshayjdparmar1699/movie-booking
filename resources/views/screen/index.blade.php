@extends('layouts.main')

@section('content')
    <div class="container mt-4" id="screen-table">
        <div class="col-md-12 text-end">
            <button class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#addScreenModal">Add Screen</button>
        </div>

        {{-- Add Movie Modal --}}
        <div class="modal fade" id="addScreenModal" tabindex="-1" aria-labelledby="addScreenModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addScreenModalLabel">Add Movie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addScreenForm">
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
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <div class="text-danger error-name"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addScreen">Submit</button>
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
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody id="screen-table-tr">

            </tbody>
        </table>
    </div>
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            getScreens();
        });

        function getScreens() {
            $.ajax({
                url: "{{ route('screens.fetch') }}",
                type: "get",
                success: function(response) {
                    response.forEach(screen => {
                        $('#screen-table-tr').append(`
<tr>
                    <th scope="row">${screen.id}</th>
                    <td>${screen.theater.name}</td>
                    <td>${screen.name}</td>
                    <td>${screen.is_active ? 'Active' : 'Inactive'}</td>
                    <td>${screen.created_at}</td>
                </tr>
                        `)
                    });
                },
            });
        };

        $('#addScreen').click(function(e) {
            e.preventDefault();

            let form = document.getElementById('addScreenForm');
            let formData = new FormData(form);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('screens.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#screen-table').prepend(`
<div class="alert alert-primary" role="alert">
  Screen added successfully.
</div>
`);

                    $('#addScreenModal').modal('hide');
                    $('#addScreenForm')[0].reset();
                    getScreens();
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
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },

            });

        });
    </script>
@endsection
@endsection
