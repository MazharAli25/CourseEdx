@extends('adminlte::page')
@section('title', 'Sub Categories List')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Categories List</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Sub Categories List</h5>

            <div class="ml-auto">
                <a href="{{ route('sub-category.create') }}" class="btn btn-primary">
                    Create
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap subCategory-table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:20px">#</th>
                        <th>Sub Category</th>
                        <th>Category</th>
                        <th>Slug</th>
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
        $('.subCategory-table').DataTable({
            responsive: true,
            autoWidth: false,
            dom: "<'row mb-3 mt-3 mr-2 ml-2'<' col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3 mb-3 mr-2 ml-2''<'col-sm-5'i><'col-sm-7'p>>",
            serverSide:true,
            processing:true,
            ajax: '{{ route("sub-category.index") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name', orderable: false, searchable: false },
                { data: 'category', name: 'category', orderable: false, searchable: false },
                { data: 'slug', name: 'slug', orderable: false},
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'dt-head-center dt-body-center' },
            ],
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
                url: `/super-admin/sub-category/${id}`,
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
                        $('.subCategory-table').DataTable().ajax.reload(null, false);
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
