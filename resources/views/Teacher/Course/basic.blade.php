@extends('layouts.CourseBuilder')

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


@section('title', 'Update Course')

@section('content_header')
    <h1>Create New Course</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data" id="courseForm">
                @csrf
                @method('PUT')
                <!-- Wizard Steps -->
                <div class="step p-4" id="step-0">
                    <h4 class="mb-3"><i class="fas fa-info-circle"></i> Course Info</h4>
                    <div class="form-group">
                        <label>Course Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $course->title }}"
                            placeholder="Enter course title" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ $course->slug }}"
                            placeholder="Enter slug" required>
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Brief description">{{ $course->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*"
                            onchange="previewImage(event)">

                        <!-- Image Preview -->
                        <div class="mt-3">
                            <img id="imagePreview" src="{{ isset($course->thumbnail) ? asset($course->thumbnail) : '' }}"
                                class="img-thumbnail {{ isset($course->thumbnail) ? '' : 'd-none' }}"
                                style="max-width: 300px; max-height:250px">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <div class="select2-purple">
                                <select name="categoryId" id="categorySelect" class="form-control select2" required>
                                    <option value="">Select Category</option>
                                    @foreach ($cats as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $course->categoryId === $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <label>Subcategory</label>
                            <div class="select2-purple">
                                <select name="subcategoryId" id="subcategorySelect" class="form-control select2" required>
                                    <option value="">Select Subcategory</option>
                                    @foreach ($cats as $cat)
                                        @foreach ($cat->subcats as $subcat)
                                            <option value="{{ $subcat->id }}"
                                                {{ $course->subcategoryId === $subcat->id ? 'selected' : '' }}>
                                                {{ $subcat->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
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

@push('js')
    <script>
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

        $('#courseForm').on('submit', function() {
            $('.summernote').each(function() {
                $(this).val($(this).summernote('code'));
            });
        });
    </script>
@endpush
