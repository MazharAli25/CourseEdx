@extends('layouts.CourseBuilder')

@section('page-title', 'Course Preview')
@section('title', 'Course Preview - ' . $course->title)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                {{-- VIDEO PLAYER CARD --}}
                <div class="card mb-4" id="videoPlayerCard" style="display: none;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold mb-0">
                            <i class="fas fa-play-circle text-primary mr-2"></i>
                            <span id="videoTitle">Lecture Preview</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="embed-responsive embed-responsive-16by9"
                            style="background: #000; min-height: 300px; position: relative;">
                            {{-- Native video player for MP4 files --}}
                            <video id="courseVideo" class="embed-responsive-item" controls
                                style="display: none; width: 100%; height: 100%; object-fit: contain; background: #000; position: absolute; top: 0; left: 0;">
                                <source id="videoSource" src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            {{-- Iframe for YouTube / Vimeo --}}
                            <iframe id="courseIframe" class="embed-responsive-item"
                                style="display: none; width: 100%; height: 100%; border: 0; position: absolute; top: 0; left: 0;"
                                allowfullscreen allow="autoplay; encrypted-media"></iframe>
                            {{-- Placeholder when no lecture is selected --}}
                            <div id="videoPlaceholder"
                                class="embed-responsive-item d-flex flex-column align-items-center justify-content-center bg-dark text-white"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <i class="fas fa-play-circle fa-3x mb-3" style="color: #5624d0;"></i>
                                <h5>Select a lecture to preview</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Header (unchanged) -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="h2 font-weight-bold mb-2">{{ $course->title }}</h1>
                                <p class="text-muted mb-3">{{ Str::limit($course->description, 200) }}</p>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-3">
                                        <span
                                            class="badge badge-success p-2">{{ $course->category->name ?? 'Uncategorized' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted"><i class="fas fa-user-graduate mr-1"></i>Created by
                                            {{ $course->teacher->name ?? 'Instructor' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="mr-4"><i
                                            class="fas fa-play-circle text-primary mr-1"></i><span>{{ $totalLectures }}
                                            lectures</span></div>
                                    <div class="mr-4"><i
                                            class="fas fa-clock text-primary mr-1"></i><span>{{ $totalHours }} total
                                            hours</span></div>
                                    <div><i
                                            class="fas fa-signal text-primary mr-1"></i><span>{{ $course->level ?? 'All Levels' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if ($course->thumbnail)
                                    <img src="{{ asset($course->thumbnail) }}" class="img-fluid rounded shadow"
                                        alt="{{ $course->title }}">
                                @else
                                    <div class="bg-light rounded shadow d-flex align-items-center justify-content-center"
                                        style="height: 180px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Content -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h3 class="h4 font-weight-bold mb-0">Course content</h3>
                        <span class="text-muted">{{ $totalSections }} sections • {{ $totalLectures }} lectures •
                            {{ $totalHours }} total length</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion" id="courseAccordion">
                            @foreach ($course->sections as $sectionIndex => $section)
                                <div class="card border-0">
                                    <div class="card-header bg-light" id="heading{{ $sectionIndex }}">
                                        <button
                                            class="btn btn-link text-dark font-weight-bold w-100 text-left d-flex justify-content-between align-items-center"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $sectionIndex }}" aria-expanded="false"
                                            aria-controls="collapse{{ $sectionIndex }}">
                                            <span><i class="fas fa-chevron-down mr-2"></i>Section {{ $sectionIndex + 1 }}:
                                                {{ $section->title }}</span>
                                            <span class="badge badge-light">{{ $section->lectures->count() }}
                                                lectures</span>
                                        </button>
                                    </div>
                                    <div id="collapse{{ $sectionIndex }}"
                                        class="collapse {{ $sectionIndex == 0 ? 'show' : '' }}"
                                        aria-labelledby="heading{{ $sectionIndex }}" data-parent="#courseAccordion">
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                @foreach ($section->lectures as $lectureIndex => $lecture)
                                                    @php
                                                        $videoUrl = $lecture->videoFile
                                                            ? asset($lecture->videoFile)
                                                            : $lecture->videoUrl;
                                                        $videoType = $lecture->videoFile ? 'mp4' : 'url';
                                                    @endphp
                                                    <div class="list-group-item border-0 px-0 lecture-item"
                                                        data-lecture-id="{{ $lecture->id }}"
                                                        data-title="{{ $lecture->title }}"
                                                        data-video="{{ $videoUrl }}" data-type="{{ $videoType }}"
                                                        style="cursor: pointer;">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                @if ($videoType == 'mp4')
                                                                    <i class="fas fa-video text-muted mr-3"></i>
                                                                @elseif (str_contains($lecture->videoUrl ?? '', 'youtube'))
                                                                    <i class="fab fa-youtube text-danger mr-3"></i>
                                                                @elseif (str_contains($lecture->videoUrl ?? '', 'vimeo'))
                                                                    <i class="fab fa-vimeo text-primary mr-3"></i>
                                                                @else
                                                                    <i class="fas fa-play-circle text-muted mr-3"></i>
                                                                @endif
                                                                <div>
                                                                    <h6 class="mb-1">{{ $lecture->title }}</h6>
                                                                    @if ($lecture->description)
                                                                        <p class="text-muted mb-0 small">
                                                                            {{ Str::limit(strip_tags($lecture->description), 100) }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light"><i
                                                                    class="fas fa-eye mr-1"></i>Preview</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h3 class="h4 font-weight-bold mb-0">Requirements</h3>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 pl-3">
                            @if ($course->requirements && $course->requirements->count() > 0)
                                @foreach ($course->requirements as $requirement)
                                    <li class="mb-2">{{ $requirement->requirement }}</li>
                                @endforeach
                            @else
                                <li class="text-muted">No specific requirements</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- FAQ -->
                @if ($course->faqs && $course->faqs->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h3 class="h4 font-weight-bold mb-0">Frequently Asked Questions</h3>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="faqAccordion">
                                @foreach ($course->faqs as $faqIndex => $faq)
                                    <div class="card border-0 mb-2">
                                        <div class="card-header bg-white p-0" id="faqHeading{{ $faqIndex }}">
                                            <button class="btn btn-link text-dark font-weight-bold w-100 text-left"
                                                type="button" data-toggle="collapse"
                                                data-target="#faqCollapse{{ $faqIndex }}" aria-expanded="false"
                                                aria-controls="faqCollapse{{ $faqIndex }}">
                                                {{ $faq->question }}
                                                <i class="fa-solid fa-angle-down"></i>
                                            </button>
                                        </div>
                                        <div id="faqCollapse{{ $faqIndex }}" class="collapse mt-2"
                                            aria-labelledby="faqHeading{{ $faqIndex }}" data-parent="#faqAccordion">
                                            <div class="card-body pt-0">
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div> <!-- end col-lg-8 -->

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Instructor -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-3">Instructor</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <span
                                        class="text-white font-weight-bold h5 mb-0">{{ substr($course->teacher->name ?? 'I', 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0">{{ $course->teacher->name ?? 'Instructor' }}</h6>
                                <p class="text-muted small mb-0">{{ $course->teacher->title ?? 'Course Instructor' }}</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h4 font-weight-bold mb-0">{{ $totalCourses }}</div>
                                <small class="text-muted">Courses</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 font-weight-bold mb-0">{{ $totalStudents }}</div>
                                <small class="text-muted">Students</small>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-block mt-3">
                            <i class="fas fa-envelope mr-2"></i> Contact Instructor
                        </button>
                    </div>
                </div>

                <!-- Course Stats -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-3">Course Statistics</h5>
                        <div class="row text-center">
                            <div class="col-4 mb-3">
                                <div class="h4 font-weight-bold text-primary mb-0">{{ $totalSections }}</div>
                                <small class="text-muted">Sections</small>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="h4 font-weight-bold text-info mb-0">{{ $totalLectures }}</div>
                                <small class="text-muted">Lectures</small>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="h4 font-weight-bold text-success mb-0">{{ $totalMaterials }}</div>
                                <small class="text-muted">Resources</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 font-weight-bold text-warning mb-0">
                                    {{ $course->faqs ? $course->faqs->count() : 0 }}</div>
                                <small class="text-muted">FAQs</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 font-weight-bold text-danger mb-0">
                                    {{ $course->requirements ? $course->requirements->count() : 0 }}</div>
                                <small class="text-muted">Requirements</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-lg-4 -->
        </div> <!-- end row -->
    </div> <!-- end container-fluid -->
@endsection

@push('styles')
    <style>
        .sticky-top { position: -webkit-sticky; position: sticky; z-index: 1020; }
        .btn-link { text-decoration: none !important; }
        .btn-link:hover { color: #6f42c1 !important; }
        .list-group-item { transition: background-color 0.2s; }
        .list-group-item:hover { background-color: #f8f9fa; }
        .accordion .card-header { cursor: pointer; }
        .accordion .card-header:hover { background-color: #f1f1f1; }

        /* Video player custom styles */
        .embed-responsive {
            background-color: #000;
            min-height: 300px;
            position: relative;
        }

        #courseVideo, #courseIframe, #videoPlaceholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #000;
        }

        #courseVideo, #courseIframe {
            display: none;
            z-index: 1060;
        }

        /* Force video to be visible when shown */
        #courseVideo[style*="display: block"] {
            display: block !important;
            z-index: 9999 !important;
            background: #000;
        }

        #courseIframe {
            z-index: 9999 !important;
        }

        #videoPlayerCard {
            position: relative;
            z-index: 1000;
        }

        .lecture-item {
            transition: all 0.2s;
        }
        .lecture-item:hover {
            background-color: #e9ecef !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            'use strict';

            // DOM Elements
            const $videoPlayerCard = $('#videoPlayerCard');
            const $courseVideo = $('#courseVideo');
            const $videoSource = $('#videoSource');
            const $videoPlaceholder = $('#videoPlaceholder');
            const $videoTitle = $('#videoTitle');

            // Native elements
            const courseVideo = $courseVideo[0];
            const courseIframe = $('#courseIframe')[0];

            function loadLecture(lectureElement) {
                const videoUrl = lectureElement.data('video');
                const lectureTitle = lectureElement.data('title');
                const videoType = lectureElement.data('type');

                if (!videoUrl) {
                    alert('No video available for this lecture.');
                    return;
                }

                // Show card, update title
                $videoPlayerCard.show();
                $videoTitle.text(lectureTitle);

                // Hide everything first
                $courseVideo.hide();
                $(courseIframe).hide();
                $videoPlaceholder.show();

                // ----- Play based on type -----
                if (videoType === 'mp4' || videoUrl.match(/\.(mp4|webm|ogg)$/i)) {
                    // Local file
                    $videoSource.attr('src', videoUrl);
                    // Show video with high z-index and ensure it's block
                    $courseVideo.css({
                        'display': 'block',
                        'z-index': '9999'
                    }).show();
                    $videoPlaceholder.hide();

                    // Error handling
                    courseVideo.onerror = function() {
                        console.error('Video error:', courseVideo.error);
                        $videoPlaceholder.html(`
                            <div class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Failed to load video. Check console.</h5>
                            </div>
                        `).show();
                        $courseVideo.hide();
                    };

                    // Success – video loaded
                    courseVideo.onloadeddata = function() {
                        console.log('Video loaded successfully');
                    };

                    courseVideo.load();
                    courseVideo.play().catch(e => console.warn('Autoplay prevented:', e));
                }
                else if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    // YouTube
                    let videoId = '';
                    if (videoUrl.includes('youtube.com/watch')) {
                        videoId = videoUrl.split('v=')[1];
                        const ampPos = videoId.indexOf('&');
                        if (ampPos !== -1) videoId = videoId.substring(0, ampPos);
                    } else if (videoUrl.includes('youtu.be/')) {
                        videoId = videoUrl.split('youtu.be/')[1];
                    }
                    courseIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
                    courseIframe.style.zIndex = '9999';
                    $(courseIframe).show();
                    $videoPlaceholder.hide();
                }
                else if (videoUrl.includes('vimeo.com')) {
                    // Vimeo
                    const videoId = videoUrl.split('/').pop();
                    courseIframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                    courseIframe.style.zIndex = '9999';
                    $(courseIframe).show();
                    $videoPlaceholder.hide();
                }
                else {
                    // Fallback – treat as direct video file
                    $videoSource.attr('src', videoUrl);
                    $courseVideo.css({
                        'display': 'block',
                        'z-index': '9999'
                    }).show();
                    $videoPlaceholder.hide();

                    courseVideo.onerror = function() {
                        console.error('Video error:', courseVideo.error);
                        $videoPlaceholder.html(`
                            <div class="text-center text-danger">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Failed to load video.</h5>
                            </div>
                        `).show();
                        $courseVideo.hide();
                    };
                    courseVideo.load();
                    courseVideo.play().catch(e => console.log('Autoplay prevented:', e));
                }

                // Scroll to player
                $('html, body').animate({
                    scrollTop: $videoPlayerCard.offset().top - 20
                }, 500);
            }

            // Click handlers
            $('.lecture-item').on('click', function(e) {
                e.preventDefault();
                loadLecture($(this));
            });

            $('.accordion .card-header').click(function() {
                $(this).find('i.fa-chevron-down, i.fa-chevron-up').toggleClass('fa-chevron-down fa-chevron-up');
            });
        });
    </script>
@endpush
