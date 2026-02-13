@extends('adminlte::page')

@section('title', 'Create Privacy Policy')

@section('content_header')
    <h1>Privacy Policy Sections</h1>
@endsection

@section('content')

    <div class="card">

        {{-- Removed "Add New Section" button from header --}}
        <div class="card-header">
            <h3 class="card-title">Manage Privacy Policy Sections</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('privacy-policy.update', $privacyPolicy->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div id="sectionsContainer">
                    <div class="card mb-3 section-box">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Section Heading</label>
                                <input type="text" name="heading" class="form-control"
                                    value="{{ $privacyPolicy->heading }}" required>
                            </div>
                            <div class="form-group">
                                <label>Section Body</label>
                                <textarea name="body" class="form-control summernote" rows="4">{{ $privacyPolicy->body }}</textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sort Order</label>
                                    <input type="number" name="sortOrder" class="form-control"
                                        value="{{ $privacyPolicy->sort_order }}">
                                </div>
                                <div class="form-group col-md-6 d-flex align-items-center mt-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="activeSwitch${sectionIndex}"
                                            name="isActive" value="1"
                                            value="{{ $privacyPolicy->status === 'active' ? 'checked' : '' }}">
                                        <label class="custom-control-label" for="activeSwitch${sectionIndex}">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Both buttons moved to the bottom --}}
                <div class="mt-4 d-flex justify-content-between">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Privacy Policy
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']], // ul = unordered list (dots)
                    ['view', ['codeview']] // Click this to see raw HTML
                ],
            });
        });
    </script>
@endsection
