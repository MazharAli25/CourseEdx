@extends('layouts.CourseBuilder')

@section('title', 'Course Curriculum')
@section('page-title', 'Course Curriculum')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="step p-4" id="step-1">
                <form action="{{ route('store.curriculum', $course->id) }}" method="POST" enctype="multipart/form-data"
                    id="curriculumForm">
                    @csrf

                    <div id="sectionsContainer">
                        <!-- EXISTING SECTIONS (if any) -->
                        @foreach ($course->sections as $sectionIndex => $section)
                            <div class="card card-outline card-primary mb-3 section-box">
                                <div class="card-header">
                                    <strong>Section {{ $sectionIndex + 1 }}</strong>
                                    <input type="hidden" name="sections[{{ $section->id }}][id]"
                                        value="{{ $section->id }}">
                                    <button type="button" onclick="removeSection({{ $section->id }})"
                                        class="btn btn-sm btn-danger float-right">Remove</button>
                                </div>
                                <div class="card-body">
                                    <input type="text" name="sections[{{ $section->id }}][title]"
                                        class="form-control mb-2" placeholder="Section Title" value="{{ $section->title }}"
                                        required>
                                    <input type="hidden" name="sections[{{ $section->id }}][courseId]"
                                        value="{{ $course->id }}">

                                    <!-- EXISTING LECTURES -->
                                    <div id="lecturesContainer{{ $section->id }}">
                                        @foreach ($section->lectures as $lectureIndex => $lecture)
                                            <div class="border p-2 mb-2 rounded lecture-box mt-3">
                                                <input type="hidden"
                                                    name="sections[{{ $section->id }}][lectures][{{ $lecture->id }}][id]"
                                                    value="{{ $lecture->id }}">

                                                <label>Lecture Title:</label>
                                                <input type="text"
                                                    name="sections[{{ $section->id }}][lectures][{{ $lecture->id }}][title]"
                                                    value="{{ $lecture->title }}" class="form-control mb-1" required>

                                                <label>Lecture Description:</label>
                                                <div class="mb-3">
                                                    <!-- Summernote Editor for Lecture Description -->
                                                    <textarea name="sections[{{ $section->id }}][lectures][{{ $lecture->id }}][description]"
                                                        class="form-control summernote" id="summernote_{{ $section->id }}_{{ $lecture->id }}" rows="4">{{ $lecture->description }}</textarea>
                                                </div>

                                                <!-- VIDEO SECTION -->
                                                <div class="card mb-3">
                                                    <div class="card-header bg-light">
                                                        <strong>Video Content</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Show existing video -->
                                                        @if ($lecture->videoUrl || $lecture->videoFile)
                                                            <div class="mb-3">
                                                                <strong>Current Video:</strong>
                                                                <div class="mt-2">
                                                                    @if ($lecture->videoUrl)
                                                                        <div class="alert border p-2">
                                                                            <i class="fas fa-link"></i>
                                                                            <strong>External URL:</strong>
                                                                            <a href="{{ $lecture->videoUrl }}"
                                                                                target="_blank" class="ml-2">
                                                                                {{ Str::limit($lecture->videoUrl, 50) }}
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-info ml-2"
                                                                                onclick="playVideoPreview('{{ $lecture->videoUrl }}', 'url')">
                                                                                <i class="fas fa-play"></i> Preview
                                                                            </button>
                                                                        </div>
                                                                    @endif

                                                                    @if ($lecture->videoFile)
                                                                        <div class="alert border p-2">
                                                                            <i class="fas fa-file-video"></i>
                                                                            <strong>Uploaded File:</strong>
                                                                            <span
                                                                                class="ml-2">{{ basename($lecture->videoFile) }}</span>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-success bg-white ml-2"
                                                                                onclick="playVideoPreview('{{ asset($lecture->videoFile) }}', 'file')">
                                                                                <i class="fas fa-play"></i> Preview
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-outline-danger ml-2"
                                                                                onclick="removeExistingVideo({{ $lecture->id }})">
                                                                                <i class="fas fa-trash"></i> Remove
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Video URL (YouTube, Vimeo, etc.):</label>
                                                                <input type="url"   
                                                                    name="sections[{{ $section->id }}][lectures][{{ $lecture->id }}][video_url]"
                                                                    value="{{ $lecture->video_url }}" class="form-control"
                                                                    placeholder="https://youtube.com/watch?v=...">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Or Upload New Video:</label>
                                                                <input type="file"
                                                                    name="sections[{{ $section->id }}][lectures][{{ $lecture->id }}][video_file]"
                                                                    class="form-control-file" accept="video/*">
                                                                <small class="text-muted">MP4, MOV, AVI, Max 500MB</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-sm btn-danger mt-3 mb-3"
                                                    onclick="removeLecture({{ $lecture->id }})">
                                                    Remove Lecture
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Button to add NEW lecture to EXISTING section -->
                                    <button type="button" class="btn btn-success mt-2"
                                        onclick="addNewLectureToExistingSection({{ $section->id }})">
                                        <i class="fas fa-plus"></i> Add Lecture
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Button to add NEW section (works alongside existing ones) -->
                    <button type="button" class="btn btn-primary mt-2" onclick="addNewSection()">
                        <i class="fas fa-plus"></i> Add New Section
                    </button>

                    <button type="submit" class="btn btn-success mt-3">
                        <i class="fas fa-save"></i> Save Curriculum
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Video Preview Modal -->
    <div class="modal fade" id="videoPreviewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Video Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="videoPlayerContainer">
                        <!-- Video player will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .note-editor .note-toolbar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .note-editor .note-editable {
            min-height: 120px;
        }

        .summernote-wrapper {
            position: relative;
        }
    </style>
@endpush

@push('scripts')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        // Initialize Summernote for existing lecture descriptions
        $(document).ready(function() {
            // Initialize Summernote for all existing textareas with class 'summernote'
            $('.summernote').each(function() {
                const textarea = $(this);
                textarea.summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        // ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            // Sync with textarea
                            textarea.val(contents);
                        }
                    }
                });
            });
        });

        let newSectionCounter = 0;
        let newLectureCounters = {};

        // Add NEW section
        function addNewSection() {
            const container = document.getElementById('sectionsContainer');
            const sectionId = 'new_' + newSectionCounter++;

            newLectureCounters[sectionId] = 0;

            const sectionHTML = `
                <div class="card card-outline card-primary mb-3 section-box">
                    <div class="card-header">
                        <strong>New Section</strong>
                        <button type="button" class="btn btn-sm btn-danger float-right" 
                                onclick="removeNewSection('${sectionId}')">Remove</button>
                    </div>
                    <div class="card-body">
                        <input type="text" 
                               name="sections[${sectionId}][title]" 
                               class="form-control mb-2" 
                               placeholder="Section Title" 
                               required>
                        <input type="hidden" 
                               name="sections[${sectionId}][courseId]" 
                               value="{{ $course->id }}">
                        
                        <div id="lecturesContainer${sectionId}"></div>
                        
                        <button type="button" 
                                class="btn btn-success mt-2" 
                                onclick="addNewLectureToNewSection('${sectionId}')">
                            <i class="fas fa-plus"></i> Add Lecture
                        </button>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', sectionHTML);
        }

        // Remove new section (not saved yet)
        function removeNewSection(sectionId) {
            if (confirm('Are you sure you want to remove this section?')) {
                document.querySelector(`[name="sections[${sectionId}][title]"]`).closest('.section-box').remove();
            }
        }

        // Add NEW lecture to EXISTING section
        function addNewLectureToExistingSection(sectionId) {
            if (!newLectureCounters[sectionId]) {
                newLectureCounters[sectionId] = 0;
            }
            const lectureId = 'new_' + newLectureCounters[sectionId]++;
            addLecture(sectionId, lectureId);
        }

        // Add NEW lecture to NEW section
        function addNewLectureToNewSection(sectionId) {
            if (!newLectureCounters[sectionId]) {
                newLectureCounters[sectionId] = 0;
            }
            const lectureId = 'new_' + newLectureCounters[sectionId]++;
            addLecture(sectionId, lectureId);
        }

        // Generic function to add lecture WITH SUMMERNOTE
        function addLecture(sectionId, lectureId) {
            const lecturesContainer = document.getElementById(`lecturesContainer${sectionId}`);

            const lectureHTML = `
                <div class="border p-2 mb-2 rounded lecture-box mt-3">
                    <label>Lecture Title:</label>
                    <input type="text" 
                           name="sections[${sectionId}][lectures][${lectureId}][title]" 
                           placeholder="Lecture Title" 
                           class="form-control mb-1" 
                           required>
                    
                    <label>Lecture Description:</label>
                    <div class="mb-3">
                        <textarea name="sections[${sectionId}][lectures][${lectureId}][description]" 
                                  class="form-control summernote-new" 
                                  id="summernote_${sectionId}_${lectureId}"
                                  rows="4" 
                                  placeholder="Add lecture description..."></textarea>
                    </div>
                    
                    <!-- Video Section for New Lectures -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>Video Content</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Video URL (YouTube, Vimeo, etc.):</label>
                                    <input type="url" 
                                           name="sections[${sectionId}][lectures][${lectureId}][video_url]" 
                                           class="form-control"
                                           placeholder="https://youtube.com/watch?v=...">
                                </div>
                                <div class="col-md-6">
                                    <label>Or Upload Video:</label>
                                    <input type="file" 
                                           name="sections[${sectionId}][lectures][${lectureId}][video_file]" 
                                           class="form-control-file" 
                                           accept="video/*">
                                    <small class="text-muted">MP4, MOV, AVI, Max 500MB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" 
                            class="btn btn-sm btn-danger mt-3 mb-3"
                            onclick="removeNewLecture(this)">
                        Remove Lecture
                    </button>
                </div>`;

            lecturesContainer.insertAdjacentHTML('beforeend', lectureHTML);

            // Initialize Summernote for the new lecture
            setTimeout(() => {
                $(`#summernote_${sectionId}_${lectureId}`).summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        // ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onChange: function(contents) {
                            $(this).val(contents);
                        }
                    }
                });
            }, 100);
        }

        // Remove new lecture (not saved yet)
        function removeNewLecture(button) {
            if (confirm('Are you sure you want to remove this lecture?')) {
                const lectureBox = button.closest('.lecture-box');
                // Destroy Summernote instance before removing
                const summernote = lectureBox.querySelector('.summernote-new');
                if (summernote && $(summernote).summernote('instance')) {
                    $(summernote).summernote('destroy');
                }
                lectureBox.remove();
            }
        }

        // Play video preview
        function playVideoPreview(videoSrc, type) {
            const container = document.getElementById('videoPlayerContainer');
            container.innerHTML = '';

            let videoHTML = '';

            if (type === 'url') {
                if (videoSrc.includes('youtube.com') || videoSrc.includes('youtu.be')) {
                    const videoId = getYouTubeId(videoSrc);
                    videoHTML = `
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" 
                                    src="https://www.youtube.com/embed/${videoId}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                        </div>`;
                } else if (videoSrc.includes('vimeo.com')) {
                    const videoId = videoSrc.split('/').pop();
                    videoHTML = `
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" 
                                    src="https://player.vimeo.com/video/${videoId}" 
                                    frameborder="0" 
                                    allow="autoplay; fullscreen" 
                                    allowfullscreen></iframe>
                        </div>`;
                } else {
                    videoHTML = `<p class="text-center text-muted">Cannot preview this URL type</p>`;
                }
            } else if (type === 'file') {
                videoHTML = `
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="embed-responsive-item" controls>
                            <source src="${videoSrc}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>`;
            }

            container.innerHTML = videoHTML;
            $('#videoPreviewModal').modal('show');
        }

        // Extract YouTube ID from URL
        function getYouTubeId(url) {
            const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[7].length === 11) ? match[7] : null;
        }

        // Remove existing video (AJAX)
        function removeExistingVideo(lectureId) {
            if (confirm('Are you sure you want to remove this video?')) {
                fetch(`/teacher/lectures/${lectureId}/remove-video`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to remove video');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing video');
                    });
            }
        }

        // Remove section using AJAX
        function removeSection(sectionId) {
            if (confirm('Are you sure you want to remove this section?')) {
                fetch(`/teacher/course/${sectionId}/remove-section`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to remove section');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing section');
                    });
            }
        }

        // Remove lecture using AJAX
        function removeLecture(lectureId) {
            if (confirm('Are you sure you want to remove this lecture?')) {
                fetch(`/teacher/lectures/${lectureId}/remove-lecture`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to remove lecture');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing lecture');
                    });
            }
        }

        // Before form submission, sync Summernote content
        $('#curriculumForm').on('submit', function() {
            // Destroy Summernote and sync content to textarea
            $('.summernote').each(function() {
                const $el = $(this);
                const code = $el.summernote('code');
                $el.summernote('destroy');
                $el.val(code);
            });
            return true; // Continue with form submission
        });
    </script>
@endpush
