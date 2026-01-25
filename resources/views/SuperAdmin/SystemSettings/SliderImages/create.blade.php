@extends('adminlte::page')
@section('title', 'Create Slider Image')

@section('content_header')
    <h1>Create Slider Images</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Slider Image</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('slider-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter slider title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter slider description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control-file" accept="image/*"
                        onchange="previewImage(event)" required>

                    <!-- Image Preview -->
                    <div class="mt-3">
                        <img id="imagePreview" src="" class="img-thumbnail d-none" style="max-width: 300px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Slider Image
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


@endsection
