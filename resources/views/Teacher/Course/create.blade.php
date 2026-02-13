@extends('adminlte::page')
@section('plugins.Select2', true)

@section('css')
    <style>
        /* Fix Select2 height to match AdminLTE inputs */
        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 25px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
    </style>
@endsection


@section('title', 'Create New Course')

@section('content_header')
    <h1>Create New Course</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" id="courseForm">
                @csrf

                <!-- Wizard Steps -->
                <div class="step p-4" id="step-0">
                    <h4 class="mb-3"><i class="fas fa-info-circle"></i> Course Info</h4>
                    <div class="form-group">
                        <label>Course Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter course title" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Enter slug" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="level">Level</label>
                            <select type="text" name="level" class="form-control" required>
                                <option value="">Select Level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advance</option>
                                <option value="allLevels">All Levels</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="language">Language</label>
                            <select type="text" name="language" class="form-control" required>
                                <option value="">Select Language</option>
                                <option value="english">English</option>
                                <option value="pashto">Pasho</option>
                                <option value="hindi">Hindi</option>
                                <option value="french">French</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <div class="select2-purple">
                                <select name="categoryId" id="categorySelect" class="form-control select2" required>
                                    <option value="">Select Category</option>
                                    @foreach ($cats as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <label>Subcategory</label>
                            <div class="select2-purple">
                                <select name="subcategoryId" id="subcategorySelect" class="form-control select2" required>
                                    <option value="">Select Subcategory</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Brief description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="form-control-file"
                            accept="image/*">

                        <div class="mt-2">
                            <img id="thumbnailPreview" src="" alt="Preview"
                                style="display:none; max-height:150px; border-radius:6px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {

            // Summernote
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']]
                ]
            });

            // Select2
            $('#categorySelect, #subcategorySelect').select2({
                placeholder: 'Select an option',
                allowClear: true,
                width: '100%'
            });

            // Fetch subcategories
            $('#categorySelect').on('change', function() {
                let categoryId = $(this).val();
                $('#subcategorySelect').empty().trigger('change');

                if (!categoryId) return;

                $.get(`/teacher/get-subcategories/${categoryId}`, function(data) {
                    let options = '<option></option>';
                    data.forEach(item => {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });

                    $('#subcategorySelect').html(options).trigger('change');
                });
            });

        });

        // Thumbnail preview
        $('#thumbnailInput').on('change', function(e) {
            const file = e.target.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image');
                $(this).val('');
                $('#thumbnailPreview').hide();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnailPreview')
                    .attr('src', e.target.result)
                    .fadeIn();
            };
            reader.readAsDataURL(file);
        });

        $('#courseForm').on('submit', function() {
            $('.summernote').each(function() {
                $(this).val($(this).summernote('code'));
            });
        });
    </script>
@endsection
