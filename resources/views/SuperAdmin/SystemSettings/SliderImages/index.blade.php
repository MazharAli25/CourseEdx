@extends('adminlte::page')
@section('title', 'Slider Images')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Slider Images</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Slider List</h5>

            <div class="ml-auto">
                <a href="{{ route('slider-images.create') }}" class="btn btn-primary btn-sm">
                    Create
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap slider-table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:50px">#</th>
                        <th style="width:120px">Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width:100px">Status</th>
                        <th style="width:140px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="https://via.placeholder.com/160x90" class="img-thumbnail"
                                style="width:80px;height:45px;object-fit:cover;">
                        </td>
                        <td>Best Trending Offers Slider Two</td>
                        <td>Description Trending Offers Slider Two</td>
                        <td>
                            <span class="badge badge-primary">Visible</span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <img src="https://via.placeholder.com/160x90" class="img-thumbnail"
                                style="width:80px;height:45px;object-fit:cover;">
                        </td>
                        <td>Best Trending Offers Slider Three</td>
                        <td>Description Trending Offers Slider Three</td>
                        <td>
                            <span class="badge badge-primary">Visible</span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>
                            <img src="https://via.placeholder.com/160x90" class="img-thumbnail"
                                style="width:80px;height:45px;object-fit:cover;">
                        </td>
                        <td>Banner Three</td>
                        <td>This is banner 3 details</td>
                        <td>
                            <span class="badge badge-primary">Visible</span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $('.slider-table').DataTable({
            responsive: true,
            autoWidth: false,
            dom: "<'row mb-3 mt-3 mr-2 ml-2'<' col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3 mb-3 mr-2 ml-2''<'col-sm-5'i><'col-sm-7'p>>"
        });
    </script>
@endsection
