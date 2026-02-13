@extends('adminlte::page')
@section('title', 'Courses Approval')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Courses For Approval</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Courses List</h5>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap courses-table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:15px">#</th>
                        <th>Thumbnail</th>
                        <th>Course Name</th>
                        <th>TeacherName</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th style="width: 120px">Status</th>
                        <th style="width:50">Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    {{-- Reject modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle mr-1"></i>
                        Reject Course
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="rejectForm">
                    @csrf
                    <input type="hidden" id="reject_course_id">

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Reason Title</label>
                            <input type="text" class="form-control" id="rejection_title"
                                placeholder="e.g. Incomplete content" required>
                        </div>

                        <div class="form-group">
                            <label>Reason Description</label>
                            <textarea class="form-control" id="rejection_description" rows="4"
                                placeholder="Explain why this course is rejected" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-danger">
                            Reject Course
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {

            // Initialize DataTable
            let coursesTable = $('.courses-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: "<'row mb-3 mt-3 mr-2 ml-2'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3 mb-3 mr-2 ml-2'<'col-sm-5'i><'col-sm-7'p>>",
                serverSide: true,
                processing: true,
                ajax: '{{ route('super.course-requests') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'teacherName',
                        name: 'teacherName',
                        orderable: false
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sub_category',
                        name: 'sub_category',
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

            // Approve course
            $(document).on('click', '.approve-btn', function() {
                let id = $(this).data('id');
                if (!confirm('Approve this course?')) return;

                $.post("{{ url('super-admin/courses') }}/" + id + "/approve", {
                    _token: '{{ csrf_token() }}'
                }, function(res) {
                    alert(res.message); // Use alert instead of toastr
                    coursesTable.ajax.reload(null, false);
                }).fail(function() {
                    alert('Something went wrong while approving.');
                });
            });

            // Open Reject modal
            $(document).on('click', '.reject-btn', function() {
                let courseId = $(this).data('id');
                $('#reject_course_id').val(courseId);
                $('#rejection_title').val('');
                $('#rejection_description').val('');
                $('#rejectModal').modal('show');
            });

            // Submit Reject form
            $('#rejectForm').on('submit', function(e) {
                e.preventDefault();
                let courseId = $('#reject_course_id').val();

                $.ajax({
                    url: "{{ url('super-admin/courses') }}/" + courseId + "/reject",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        rejection_title: $('#rejection_title').val(),
                        rejection_description: $('#rejection_description').val(),
                    },
                    success: function(res) {
                        alert(res.message); // Use alert instead of toastr

                        // Properly hide modal
                        $('#rejectModal').modal('hide');

                        // Reload DataTable
                        coursesTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong while rejecting.');
                    }
                });
            });

            // Preview button
            $(document).on('click', '.preview-btn', function() {
                let courseId = $(this).data('id');
                window.open("{{ url('super-admin/courses') }}/" + courseId + "/preview", '_blank');
            });

        });
    </script>
@endsection
