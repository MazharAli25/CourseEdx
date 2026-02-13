    @extends('adminlte::page')
    @section('title', 'Registered users')
    @section('plugins.Datatables', true)

    @section('content_header')
        <h1>Registered users</h1>
    @endsection

    @section('content')

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Registered users List</h5>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover text-nowrap users-table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:15px">#</th>
                            <th >Images</th>
                            <th >Name</th>
                            <th>Email</th>
                            <th style="width: 120px">Role</th>
                            <th style="width: 120px">Status</th>
                            <th style="width:50">Action</th>
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
            $('.users-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: "<'row mb-3 mt-3 mr-2 ml-2'<' col-sm-6'l><'col-sm-6 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3 mb-3 mr-2 ml-2''<'col-sm-5'i><'col-sm-7'p>>",
                serverSide: true,
                processing: true,
                ajax: '{{ route('super.registeredUsers') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
            });

            // Handle status change
            $(document).on('change', '.status-dropdown', function() {
                const dropdown = $(this);
                const userId = dropdown.data('id');
                const newStatus = dropdown.val();
                const currentStatus = dropdown.data('current');

                console.log('Updating status...', {
                    userId: userId,
                    newStatus: newStatus,
                    currentStatus: currentStatus
                });

                // Visual feedback
                dropdown.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');

                $.ajax({
                    url: "{{ url('super-admin/registered-users/update-status') }}/" + userId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        social_link_id: userId,
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

            // handle role change
            $(document).on('change', '.role-dropdown', function() {
                const dropdown = $(this);
                const userId = dropdown.data('id');
                const newRole = dropdown.val();
                const currentRole = dropdown.data('current');

                console.log('Updating role...', {
                    userId: userId,
                    newRole: newRole,
                    currentRole: currentRole
                });

                // Visual feedback
                dropdown.prop('disabled', true).addClass('opacity-60 cursor-not-allowed');

                $.ajax({
                    url: "{{ url('super-admin/registered-users/update-role') }}/" + userId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        social_link_id: userId,
                        role: newRole
                    },
                    success: function(response) {

                        if (response.success) {

                            // Update current role
                            dropdown.data('current', newRole);
                            $('.users-table').DataTable().ajax.reload(null, false);

                        } else {
                            dropdown.val(currentRole);
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

                        dropdown.val(currentRole);

                        let errorMsg = 'An error occurred while updating role';
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
            })

            // Handle delete action
            $(document).on('click', '.delete-btn', function() {
                let button = $(this);
                let id = button.data('id');

                if (!confirm('Are you sure you want to delete this record?')) {
                    return;
                }

                button.prop('disabled', true);

                $.ajax({
                    url: `/super-admin/registered-users/delete/${id}`,
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
                            $('.users-table').DataTable().ajax.reload(null, false);
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
