@extends('adminlte::page')
@section('title', 'Courses List')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Courses List</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Courses List</h5>

            <div class="ml-auto">
                <a href="{{ route('course.create') }}" class="btn btn-primary">
                    Create
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap courses-table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:20px">#</th>
                        <th style="width:120px">Thumbnail</th>
                        <th style="width:120px">Course</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th style="width:140px">Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.courses-table').DataTable({
            responsive: true,
            autoWidth: false,
            dom: "<'row mb-3 mt-3 mr-2 ml-2'<' col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3 mb-3 mr-2 ml-2''<'col-sm-5'i><'col-sm-7'p>>",
            serverSide: true,
            processing: true,
            ajax: '{{ route('course.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    className:' text-center'
                },
                {
                    data: 'title',
                    name: 'title',
                    orderable: false
                },
                {
                    data: 'slug',
                    name: 'slug',
                    orderable: false
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'dt-head-center dt-body-center'
                },
            ],
        });
        // Handle status change
        $(document).on('change', '.status-dropdown', function() {
            const dropdown = $(this);
            const imageId = dropdown.data('id');
            const newStatus = dropdown.val();
            const currentStatus = dropdown.data('current');

            console.log('Updating status...', {
                imageId: imageId,
                newStatus: newStatus,
                currentStatus: currentStatus
            });

            // Visual feedback
            dropdown.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');

            $.ajax({
                // url: "{{ url('/super-admin/slider-images/update-status') }}/" + imageId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    slider_image_id: imageId,
                    status: newStatus
                },
                success: function(response) {

                    if (response.success) {

                        // Update current status
                        dropdown.data('current', newStatus);
                    } else {
                        dropdown.val(currentStatus);
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message);
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error response:', xhr);
                    console.error('Response text:', xhr.responseText);

                    dropdown.val(currentStatus);

                    let errorMsg = 'An error occurred while updating status';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                        if (xhr.responseJSON.error) {
                            console.error('Detailed error:', xhr.responseJSON.error);
                        }
                    }

                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                },
                complete: function() {
                    dropdown.prop('disabled', false).removeClass(
                        'opacity-60 cursor-not-allowed');
                }
            });
        });

        // Handle delete action
        $(document).on('click', '.delete-btn', function() {
            let button = $(this);
            let id = button.data('id');

            if (!confirm('Are you sure you want to delete this record?')) {
                return;
            }

            button.prop('disabled', true);

            $.ajax({
                // url: `/super-admin/slider-images/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        } else {
                            alert(response.message);
                        }
                        // Refresh DataTable after deletion
                        $('.slider-table').DataTable().ajax.reload(null, false);
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Failed to delete.');
                        } else {
                            alert(response.message || 'Failed to delete.');
                        }
                        button.prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Error deleting record.');
                    } else {
                        alert('Error deleting record.');
                    }
                    button.prop('disabled', false);
                }
            });
        });
    </script>
@endsection
