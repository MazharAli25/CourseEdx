@extends('layouts.user')
@section('page-title', 'Learning')

@section('css')
    <style>
        :root {
            --udemy-purple: #5624d0;
            --udemy-dark: #1c1d1f;
            --udemy-gray: #6a6f73;
            --udemy-light-gray: #d1d7dc;
            --udemy-light-bg: #f7f9fa;
            --udemy-yellow: #f3ca8c;
            --udemy-orange: #b4690e;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--udemy-dark);
            background-color: #fff;
            line-height: 1.4;
        }

        .udemy-navbar {
            background-color: #fff;
            border-bottom: 1px solid var(--udemy-light-gray);
            padding: 0.5rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .udemy-logo {
            font-weight: bold;
            color: var(--udemy-purple);
            font-size: 1.5rem;
            text-decoration: none;
        }

        .udemy-search {
            background-color: var(--udemy-light-bg);
            border: 1px solid var(--udemy-light-gray);
            border-radius: 9999px;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 500px;
        }

        .udemy-btn {
            border-radius: 0;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }

        .udemy-btn-primary {
            background-color: var(--udemy-purple);
            border-color: var(--udemy-purple);
            color: white;
        }

        .udemy-btn-primary:hover {
            background-color: #4a1dbb;
            border-color: #4a1dbb;
        }

        .udemy-btn-outline {
            border: 1px solid var(--udemy-dark);
            color: var(--udemy-dark);
            background-color: transparent;
        }

        .udemy-btn-outline:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .progress-container {
            background-color: var(--udemy-light-bg);
            padding: 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
        }

        .progress-bar-udemy {
            background-color: var(--udemy-purple);
            border-radius: 9999px;
        }

        .course-title {
            color: var(--udemy-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .instructor-name {
            color: var(--udemy-gray);
            font-size: 0.9rem;
        }

        .section-card {
            border: 1px solid var(--udemy-light-gray);
            border-radius: 4px;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .section-header {
            background-color: var(--udemy-light-bg);
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .section-content {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .section-content.expanded {
            max-height: 1000px;
        }

        .lecture-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--udemy-light-gray);
            display: flex;
            align-items: center;
        }

        .lecture-item:last-child {
            border-bottom: none;
        }

        .lecture-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .lecture-item.completed .lecture-title {
            color: var(--udemy-gray);
        }

        .lecture-item.current {
            background-color: rgba(86, 36, 208, 0.05);
            border-left: 3px solid var(--udemy-purple);
        }

        .lecture-icon {
            color: var(--udemy-gray);
            margin-right: 1rem;
            width: 24px;
            text-align: center;
        }

        .lecture-item.completed .lecture-icon {
            color: var(--udemy-purple);
        }

        .lecture-duration {
            color: var(--udemy-gray);
            font-size: 0.8rem;
            margin-left: auto;
        }

        .sidebar-card {
            border: 1px solid var(--udemy-light-gray);
            border-radius: 4px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .video-player {
            background-color: #000;
            border-radius: 4px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .play-button {
            background-color: var(--udemy-purple);
            border: none;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .play-button i {
            font-size: 1.5rem;
            color: white;
            margin-left: 5px;
        }

        .continue-btn {
            width: 100%;
            padding: 0.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .resources-list {
            list-style-type: none;
            padding-left: 0;
        }

        .resources-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--udemy-light-gray);
        }

        .resources-list li:last-child {
            border-bottom: none;
        }

        .resources-list a {
            color: var(--udemy-purple);
            text-decoration: none;
        }

        .resources-list a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: var(--udemy-dark);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 3rem;
        }

        .footer-links {
            list-style-type: none;
            padding-left: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1.5rem;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .badge {
            background-color: var(--udemy-yellow);
            color: var(--udemy-orange);
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .quiz-item {
            background-color: rgba(243, 202, 140, 0.1);
            border-left: 3px solid var(--udemy-yellow);
        }

        .badge-custom {
            background-color: var(--udemy-yellow);
            color: var(--udemy-orange);
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(0, 0, 0, .1);
            border-radius: 50%;
            border-top-color: var(--udemy-purple);
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        @media (max-width: 992px) {
            .sidebar-card {
                margin-top: 2rem;
            }
        }
    </style>
@endsection
@section('main-content')
    <div class="container mt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Progress Header - DYNAMIC -->
                <div class="progress-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="course-title mb-1">{{ $course->title }}</h2>
                            <p class="instructor-name mb-0">
                                Instructor: {{ $course->teacher->name ?? 'Unknown' }}
                                @if ($course->teacher)
                                    <span class="ms-2 badge bg-secondary">{{ $course->teacher->email }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            {{-- DYNAMIC completion badge --}}
                            <div class="badge-custom mb-2" id="completionBadge">
                                {{ $completionPercentage }}% COMPLETE
                            </div>
                            {{-- DYNAMIC progress count --}}
                            <p class="mb-0 small text-muted" id="progressCount">
                                {{ $completedLectures }} of {{ $totalLectures }} lectures completed
                            </p>
                        </div>
                    </div>

                    {{-- DYNAMIC progress bar --}}
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar progress-bar-udemy" id="progressBar" role="progressbar"
                            style="width: {{ $completionPercentage }}%;" aria-valuenow="{{ $completionPercentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- DYNAMIC progress stats --}}
                    <div class="d-flex justify-content-between small text-muted">
                        <span id="completedCount">{{ $completedLectures }} completed</span>
                        <span id="remainingCount">{{ $totalLectures - $completedLectures }} remaining</span>
                    </div>
                </div>

                <!-- Video Player -->
                <div class="video-player p-0" style="height:auto;background:#000;">
                    <video id="courseVideo" controls style="width:100%; height:400px; background:#000;"
                        poster="{{ $course->thumbnail ?? '' }}">
                        <source id="videoSource" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <iframe id="courseIframe" style="width:100%;height:400px;display:none;" allowfullscreen></iframe>
                </div>

                <h5 id="videoTitle" class="mt-2">Select a lecture to start</h5>

                <!-- Course Content Sections -->
                {{-- 
                    ============================================
                    COURSE CONTENT SECTIONS
                    Dynamically loops through all sections and lectures
                    ============================================
                --}}
                <h3 class="mb-3 mt-4">Course content</h3>

                {{-- Loop through all sections --}}
                @foreach ($course->sections as $sIndex => $section)
                    <div class="section-card">
                        {{-- Section Header --}}
                        <div class="section-header" data-section="{{ $sIndex }}">
                            <div>
                                <h5 class="mb-1">
                                    Section {{ $sIndex + 1 }}: {{ $section->title }}
                                </h5>
                                <p class="mb-0 small text-muted">
                                    @php
                                        $sectionLectures = $section->lectures->count();
                                        $sectionCompleted = 0;
                                        foreach ($section->lectures as $lecture) {
                                            if (in_array($lecture->id, $completedLectureIds ?? [])) {
                                                $sectionCompleted++;
                                            }
                                        }
                                        $sectionPercentage =
                                            $sectionLectures > 0
                                                ? round(($sectionCompleted / $sectionLectures) * 100)
                                                : 0;
                                    @endphp
                                    {{ $sectionLectures }} lectures •
                                    {{ $sectionCompleted }}/{{ $sectionLectures }} completed
                                    ({{ $sectionPercentage }}%)
                                </p>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        {{-- Section Content (Lectures) --}}
                        <div class="section-content" id="section-{{ $sIndex }}">
                            @foreach ($section->lectures as $lIndex => $lecture)
                                {{-- 
                                    DYNAMIC lecture item
                                    - Adds 'completed' class if lecture is completed
                                    - Adds 'current' class if this is the last watched lecture
                                --}}
                                <div class="lecture-item 
                                    {{ in_array($lecture->id, $completedLectureIds ?? []) ? 'completed' : '' }}
                                    {{ $lastWatched && $lastWatched->lecture_id == $lecture->id ? 'current' : '' }}"
                                    data-lecture-id="{{ $lecture->id }}" data-section-id="{{ $section->id }}"
                                    data-course-id="{{ $course->id }}" data-title="{{ $lecture->title }}"
                                    data-video="{{ $lecture->videoFile ? asset($lecture->videoFile) : $lecture->videoUrl }}"
                                    data-type="{{ $lecture->videoFile ? 'mp4' : 'url' }}">

                                    {{-- DYNAMIC icon based on completion status --}}
                                    <div class="lecture-icon">
                                        @if (in_array($lecture->id, $completedLectureIds ?? []))
                                            <i class="fas fa-check-circle"></i>
                                        @else
                                            <i class="far fa-play-circle"></i>
                                        @endif
                                    </div>

                                    {{-- Lecture title with number --}}
                                    <div class="lecture-title flex-grow-1">
                                        {{ $lIndex + 1 }}. {{ $lecture->title }}
                                    </div>

                                    {{-- Optional: Show duration if available --}}
                                    @if (isset($lecture->duration))
                                        <div class="lecture-duration">
                                            {{ $lecture->duration }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Quiz Section -->
                {{-- <div class="section-card">
                    <div class="section-header" data-section="3">
                        <div>
                            <h5 class="mb-1">Quiz 1: CHAPTER 2: Basics of Excel</h5>
                            <p class="mb-0 small text-muted">0 / 2 • 12hr 45min</p>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="section-content" id="section-3">
                        <div class="lecture-item quiz-item">
                            <div class="lecture-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div>
                                <div class="lecture-title">Quiz: Basics of Excel</div>
                                <small class="text-muted">27 questions • Not started</small>
                            </div>
                            <div class="lecture-duration"></div>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- 
                ============================================
                SIDEBAR - DYNAMIC CONTENT
                ============================================
            --}}
            <div class="col-lg-4">
                <div class="sidebar-card">
                    <h5 class="mb-3">Your Progress</h5>

                    <p class="small text-muted mb-3">
                        <i class="fas fa-check-circle me-1"></i>
                        {{ $completedLectures }} of {{ $totalLectures }} lectures completed
                    </p>

                    {{-- DYNAMIC "What's next" section --}}
                    <h5 class="mb-3">What's next</h5>
                    @if ($completedLectures >= $totalLectures)
                        {{-- Course completed message --}}
                        <div class="alert alert-success">
                            <i class="fas fa-trophy me-2"></i>
                            Congratulations! You've completed this course.
                        </div>
                        <button class="btn udemy-btn udemy-btn-primary continue-btn" disabled>
                            <i class="fas fa-check-circle me-2"></i> Course Completed
                        </button>
                    @else
                        {{-- Show next lecture recommendation --}}
                        @php
                            $nextLecture = null;
                            // Find the first incomplete lecture
                            foreach ($course->sections as $section) {
                                foreach ($section->lectures as $lecture) {
                                    if (!in_array($lecture->id, $completedLectureIds ?? [])) {
                                        $nextLecture = $lecture;
                                        break 2;
                                    }
                                }
                            }
                        @endphp

                        @if ($nextLecture)
                            <p class="small">
                                <i class="fas fa-arrow-right me-1"></i>
                                Next: {{ $nextLecture->title }}
                            </p>
                        @endif

                        <button class="btn udemy-btn udemy-btn-primary continue-btn" id="markCompleteBtn">
                            <i class="fas fa-check-circle me-2"></i> Mark as complete
                        </button>

                        <button class="btn udemy-btn udemy-btn-outline continue-btn" id="nextLectureBtn">
                            <i class="fas fa-forward me-2"></i> Next lecture
                        </button>
                    @endif

                    {{-- Resources section --}}
                    <div class="mt-4">
                        <h6>Resources</h6>
                        <ul class="resources-list" id="lectureResources">
                            {{-- Will be populated dynamically via JS --}}
                            <li class="text-muted">Select a lecture to view resources</li>
                        </ul>
                    </div>
                </div>

                {{-- Course details sidebar card --}}
                <div class="sidebar-card">
                    <h5 class="mb-3">Course details</h5>
                    <div class="mb-2">
                        <div class="small text-muted">Category</div>
                        <div class="fw-medium">{{ $course->category->name ?? 'Uncategorized' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="small text-muted">Level</div>
                        <div class="fw-medium">{{ ucfirst($course->level ?? 'All levels') }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="small text-muted">Language</div>
                        <div class="fw-medium">{{ $course->language ?? 'English' }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="small text-muted">Total lectures</div>
                        <div class="fw-medium">{{ $totalLectures }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="small text-muted">Last accessed</div>
                        <div class="fw-medium">
                            @if ($lastWatched && $lastWatched->last_watched_at)
                                {{ \Carbon\Carbon::parse($lastWatched->last_watched_at)->diffForHumans() }}
                            @else
                                Not started yet
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            // ============================================
            // DOM ELEMENT SELECTIONS
            // ============================================
            const video = document.getElementById('courseVideo');
            const source = document.getElementById('videoSource');
            const iframe = document.getElementById('courseIframe');
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            const videoTitle = document.getElementById('videoTitle');

            const lectureItems = document.querySelectorAll('.lecture-item');
            const markCompleteBtn = document.getElementById('markCompleteBtn');
            const nextLectureBtn = document.getElementById('nextLectureBtn');

            const progressBar = document.getElementById('progressBar');
            const completionBadge = document.getElementById('completionBadge');
            const progressCount = document.getElementById('progressCount');
            const completedCount = document.getElementById('completedCount');
            const remainingCount = document.getElementById('remainingCount');

            // Toast container for notifications
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container';
                document.body.appendChild(toastContainer);
            }

            // ============================================
            // STATE VARIABLES
            // ============================================
            let currentLecture = null;
            let currentLectureId = null;
            let currentSectionId = null;
            let currentCourseId = '{{ $course->id }}';

            // Get initial progress from server-rendered data
            let completedLectures = {{ $completedLectures }};
            let totalLectures = {{ $totalLectures }};
            let completedLectureIds = @json($completedLectureIds ?? []);

            // CSRF Token for AJAX requests
            const csrfToken = '{{ csrf_token() }}';

            // ============================================
            // AUTO-EXPAND LAST WATCHED SECTION
            // ============================================
            @if ($lastWatched && $lastWatched->lecture && $lastWatched->lecture_id)
                const lastWatchedId = {{ $lastWatched->lecture_id }};

                // Find the section that contains the last watched lecture
                document.querySelectorAll('.section-header').forEach((header) => {
                    const sectionId = header.dataset.section;
                    const sectionContent = document.getElementById('section-' + sectionId);

                    if (sectionContent && sectionContent.querySelector(
                            `[data-lecture-id="${lastWatchedId}"]`)) {
                        // Expand this section
                        sectionContent.classList.add('expanded');
                        sectionContent.style.maxHeight = sectionContent.scrollHeight + 'px';

                        // Update chevron icon
                        const chevron = header.querySelector('.fa-chevron-down, .fa-chevron-up');
                        if (chevron) {
                            chevron.classList.remove('fa-chevron-down');
                            chevron.classList.add('fa-chevron-up');
                        }
                    }
                });
            @endif

            // ============================================
            // AUTO-LOAD LAST WATCHED LECTURE
            // ============================================
            @if ($lastWatched && $lastWatched->lecture && $lastWatched->lecture_id)
                const lastWatchedElement = document.querySelector(`[data-lecture-id="${lastWatchedId}"]`);
                if (lastWatchedElement) {
                    setTimeout(() => {
                        lastWatchedElement.click();
                    }, 500);
                }
            @endif

            // ============================================
            // SECTION TOGGLE FUNCTIONALITY - FIXED
            // ============================================
            document.querySelectorAll('.section-header').forEach((header) => {
                const sectionId = header.dataset.section;
                const content = document.getElementById('section-' + sectionId);
                const chevron = header.querySelector('.fa-chevron-down, .fa-chevron-up');

                // Initialise chevron (down = collapsed)
                if (chevron) {
                    chevron.classList.remove('fa-chevron-up');
                    chevron.classList.add('fa-chevron-down');
                }

                // Ensure content starts collapsed
                if (content) {
                    content.classList.remove('expanded');
                    content.style.maxHeight = null;
                }

                header.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const clickedContent = document.getElementById('section-' + this.dataset
                        .section);
                    const clickedChevron = this.querySelector('.fa-chevron-down, .fa-chevron-up');

                    if (clickedContent) {
                        clickedContent.classList.toggle('expanded');

                        if (clickedContent.classList.contains('expanded')) {
                            clickedContent.style.maxHeight = clickedContent.scrollHeight + 'px';
                            if (clickedChevron) {
                                clickedChevron.classList.remove('fa-chevron-down');
                                clickedChevron.classList.add('fa-chevron-up');
                            }
                        } else {
                            clickedContent.style.maxHeight = null;
                            if (clickedChevron) {
                                clickedChevron.classList.remove('fa-chevron-up');
                                clickedChevron.classList.add('fa-chevron-down');
                            }
                        }
                    }
                });
            });

            // ============================================
            // LECTURE CLICK HANDLER
            // ============================================
            lectureItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    loadLecture(this);
                });
            });

            /**
             * Load a lecture into the video player
             */
            function loadLecture(lectureElement) {
                // Get lecture data from data attributes
                const lectureId = lectureElement.dataset.lectureId;
                const sectionId = lectureElement.dataset.sectionId;
                const videoUrl = lectureElement.dataset.video;
                const lectureTitle = lectureElement.dataset.title;
                const videoType = lectureElement.dataset.type;

                if (!videoUrl) {
                    showToast('No video available for this lecture', 'warning');
                    return;
                }

                // Update current lecture references
                lectureItems.forEach(l => l.classList.remove('current'));
                lectureElement.classList.add('current');
                currentLecture = lectureElement;
                currentLectureId = lectureId;
                currentSectionId = sectionId;

                // Update video title
                videoTitle.textContent = lectureTitle;
                videoTitle.classList.remove('text-muted');

                // Reset players
                video.pause();
                video.style.display = 'none';

                iframe.style.display = 'none';
                iframe.src = '';

                // Load video based on type
                if (videoType === 'mp4' || videoUrl.endsWith('.mp4') || videoUrl.endsWith('.webm') || videoUrl
                    .endsWith('.ogg')) {
                    // Local video file
                    source.src = videoUrl;
                    video.style.display = 'block';
                    video.load();
                    video.play().catch(error => {
                        console.log('Autoplay prevented:', error);
                    });

                    // Start tracking progress for this video
                    setupVideoTracking();
                } else if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    // YouTube video
                    let videoId = '';
                    if (videoUrl.includes('youtube.com/watch')) {
                        videoId = videoUrl.split('v=')[1];
                        const ampersandPosition = videoId.indexOf('&');
                        if (ampersandPosition !== -1) {
                            videoId = videoId.substring(0, ampersandPosition);
                        }
                    } else if (videoUrl.includes('youtu.be/')) {
                        videoId = videoUrl.split('youtu.be/')[1];
                    }

                    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&enablejsapi=1`;
                    iframe.style.display = 'block';

                    // YouTube tracking would need additional setup with YT API
                } else if (videoUrl.includes('vimeo.com')) {
                    // Vimeo video
                    const videoId = videoUrl.split('/').pop();
                    iframe.src = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                    iframe.style.display = 'block';
                } else {
                    // Assume it's a direct video URL
                    source.src = videoUrl;
                    video.style.display = 'block';
                    video.load();
                    video.play().catch(error => {
                        console.log('Autoplay prevented:', error);
                    });

                    setupVideoTracking();
                }

                // Update button states
                updateButtonStates();

                // Track that this lecture was watched
                trackLectureView(lectureId, sectionId);
            }

            /**
             * Set up video progress tracking for HTML5 video
             */
            function setupVideoTracking() {
                if (!video) return;

                let progressInterval;

                video.addEventListener('play', function() {
                    // Track progress every 30 seconds
                    progressInterval = setInterval(() => {
                        if (currentLectureId && video.currentTime > 0) {
                            trackVideoProgress(currentLectureId, Math.floor(video.currentTime));
                        }
                    }, 30000);
                });

                video.addEventListener('pause', function() {
                    clearInterval(progressInterval);
                });

                video.addEventListener('ended', function() {
                    clearInterval(progressInterval);
                    // Optional: Auto-mark as complete when video ends
                    // Uncomment the line below if you want this behavior
                    // if (currentLecture && !currentLecture.classList.contains('completed')) {
                    //     markCompleteBtn.click();
                    // }
                });
            }

            // ============================================
            // AJAX FUNCTIONS
            // ============================================

            /**
             * Track that user viewed a lecture
             */
            function trackLectureView(lectureId, sectionId) {
                fetch(`/student/lecture/${lectureId}/progress`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        section_id: sectionId,
                        course_id: currentCourseId,
                        duration: 0
                    })
                }).catch(error => console.error('Error tracking lecture view:', error));
            }

            /**
             * Track video watch progress
             */
            function trackVideoProgress(lectureId, duration) {
                fetch(`/student/lecture/${lectureId}/progress`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        section_id: currentSectionId,
                        course_id: currentCourseId,
                        duration: duration
                    })
                }).catch(error => console.error('Error tracking progress:', error));
            }

            /**
             * Save lecture completion to server
             */
            function saveLectureCompletion(lectureId) {
                // Disable button to prevent double submission
                if (markCompleteBtn) {
                    markCompleteBtn.disabled = true;
                    markCompleteBtn.innerHTML = '<span class="loading-spinner me-2"></span> Saving...';
                }

                fetch(`/student/lecture/${lectureId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            section_id: currentSectionId,
                            course_id: currentCourseId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update UI to show completed status
                            markLectureCompleteInUI(currentLecture);

                            // Update progress data from server
                            completedLectures = data.completed_lectures;
                            totalLectures = data.total_lectures;

                            // Add to completed IDs array if not already present
                            const lectureIdNum = parseInt(currentLectureId);
                            if (!completedLectureIds.includes(lectureIdNum)) {
                                completedLectureIds.push(lectureIdNum);
                            }

                            // Update progress UI
                            updateProgressUI(data.completion_percentage, completedLectures);

                            // Show success message
                            showToast('✓ Lecture marked as complete!', 'success');

                            // Check if course is fully completed
                            if (data.is_course_completed) {
                                showToast('🎉 Congratulations! You have completed the course!', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                        } else {
                            showToast(data.message || 'Failed to mark as complete', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(error.message || 'An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Re-enable button
                        if (markCompleteBtn) {
                            markCompleteBtn.disabled = false;
                            markCompleteBtn.innerHTML =
                                '<i class="fas fa-check-circle me-2"></i> Mark as complete';
                        }
                    });
            }

            // ============================================
            // UI UPDATE FUNCTIONS
            // ============================================

            /**
             * Mark a lecture as complete in the UI
             */
            function markLectureCompleteInUI(lectureElement) {
                if (!lectureElement) return;

                // Add completed class
                lectureElement.classList.add('completed');

                // Update icon
                const icon = lectureElement.querySelector('.lecture-icon i');
                if (icon) {
                    icon.classList.remove('far', 'fa-play-circle');
                    icon.classList.add('fas', 'fa-check-circle');
                }

                // Update section progress counts
                updateSectionProgress(lectureElement);

                // Update button states
                updateButtonStates();
            }

            /**
             * Update progress counts for the section containing this lecture
             */
            function updateSectionProgress(lectureElement) {
                const sectionContent = lectureElement.closest('.section-content');
                if (!sectionContent) return;

                const sectionHeader = sectionContent.previousElementSibling;
                if (!sectionHeader) return;

                const progressText = sectionHeader.querySelector('.small.text-muted');
                if (!progressText) return;

                // Count lectures and completed lectures in this section
                const lectures = sectionContent.querySelectorAll('.lecture-item');
                const totalInSection = lectures.length;
                let completedInSection = 0;

                lectures.forEach(lecture => {
                    if (lecture.classList.contains('completed')) {
                        completedInSection++;
                    }
                });

                const percentage = totalInSection > 0 ?
                    Math.round((completedInSection / totalInSection) * 100) :
                    0;

                // Update the text
                const text = progressText.textContent || '';
                const newText = text.replace(
                    /\d+\/\d+ completed \(\d+%\)/,
                    `${completedInSection}/${totalInSection} completed (${percentage}%)`
                );
                progressText.textContent = newText;
            }

            /**
             * Update all progress UI elements
             */
            function updateProgressUI(percentage, completed) {
                // Update progress bar
                if (progressBar) {
                    progressBar.style.width = percentage + '%';
                    progressBar.setAttribute('aria-valuenow', percentage);
                }

                // Update completion badge
                if (completionBadge) {
                    completionBadge.textContent = percentage + '% COMPLETE';
                }

                // Update progress counts
                const remaining = totalLectures - completed;

                if (progressCount) {
                    progressCount.textContent = `${completed} of ${totalLectures} lectures completed`;
                }

                if (completedCount) {
                    completedCount.textContent = `${completed} completed`;
                }

                if (remainingCount) {
                    remainingCount.textContent = `${remaining} remaining`;
                }
            }

            /**
             * Update button states based on current lecture
             */
            function updateButtonStates() {
                if (!currentLecture || !markCompleteBtn) return;

                if (currentLecture.classList.contains('completed')) {
                    markCompleteBtn.disabled = true;
                    markCompleteBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Already completed';
                    markCompleteBtn.classList.add('btn-success');
                    markCompleteBtn.classList.remove('udemy-btn-primary');
                } else {
                    markCompleteBtn.disabled = false;
                    markCompleteBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Mark as complete';
                    markCompleteBtn.classList.remove('btn-success');
                    markCompleteBtn.classList.add('udemy-btn-primary');
                }
            }

            // ============================================
            // NEXT LECTURE FUNCTIONALITY
            // ============================================
            if (nextLectureBtn) {
                nextLectureBtn.addEventListener('click', function() {
                    if (!currentLecture) {
                        // If no lecture is selected, find the first incomplete lecture
                        const firstIncomplete = findFirstIncompleteLecture();
                        if (firstIncomplete) {
                            loadLecture(firstIncomplete);
                        }
                        return;
                    }

                    // Find next lecture
                    const nextLecture = findNextLecture(currentLecture);
                    if (nextLecture) {
                        loadLecture(nextLecture);

                        // Auto-scroll to next lecture
                        nextLecture.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    } else {
                        showToast('You have reached the end of the course!', 'info');
                    }
                });
            }

            /**
             * Find the next lecture in sequence
             */
            function findNextLecture(currentLecture) {
                const allLectures = Array.from(lectureItems);
                const currentIndex = allLectures.indexOf(currentLecture);

                if (currentIndex !== -1 && currentIndex < allLectures.length - 1) {
                    return allLectures[currentIndex + 1];
                }

                return null;
            }

            /**
             * Find the first incomplete lecture
             */
            function findFirstIncompleteLecture() {
                for (let lecture of lectureItems) {
                    if (!lecture.classList.contains('completed')) {
                        return lecture;
                    }
                }
                return null;
            }

            // ============================================
            // MARK COMPLETE BUTTON HANDLER
            // ============================================
            if (markCompleteBtn) {
                markCompleteBtn.addEventListener('click', function() {
                    if (!currentLecture) {
                        showToast('Please select a lecture first', 'warning');
                        return;
                    }

                    if (currentLecture.classList.contains('completed')) {
                        showToast('This lecture is already marked as complete', 'info');
                        return;
                    }

                    saveLectureCompletion(currentLectureId);
                });
            }

            // ============================================
            // TOAST NOTIFICATION SYSTEM
            // ============================================

            /**
             * Show a toast notification
             */
            function showToast(message, type = 'info') {
                const toastId = 'toast-' + Date.now();
                const bgColor = {
                    'success': 'bg-success',
                    'error': 'bg-danger',
                    'warning': 'bg-warning',
                    'info': 'bg-info'
                } [type] || 'bg-secondary';

                const icon = {
                    'success': 'fa-check-circle',
                    'error': 'fa-times-circle',
                    'warning': 'fa-exclamation-triangle',
                    'info': 'fa-info-circle'
                } [type] || 'fa-info-circle';

                const toastHtml = `
                    <div id="${toastId}" class="toast ${bgColor} text-white mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                        <div class="toast-body d-flex align-items-center">
                            <i class="fas ${icon} me-2"></i>
                            <span>${message}</span>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;

                toastContainer.insertAdjacentHTML('beforeend', toastHtml);

                const toastElement = document.getElementById(toastId);
                if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
                    const toast = new bootstrap.Toast(toastElement, {
                        autohide: true,
                        delay: 4000
                    });
                    toast.show();

                    toastElement.addEventListener('hidden.bs.toast', function() {
                        this.remove();
                    });
                } else {
                    // Fallback if Bootstrap JS is not loaded
                    console.log('Toast:', message);
                    setTimeout(() => {
                        toastElement.remove();
                    }, 4000);
                }
            }

            // ============================================
            // RESOURCE LOADING (Optional)
            // ============================================

            /**
             * Load resources for the current lecture
             */
            function loadLectureResources(lectureId) {
                // This would typically be an AJAX call to get lecture materials
                const resourcesList = document.querySelector('#lectureResources');
                if (resourcesList) {
                    resourcesList.innerHTML = `
                        <li>
                            <i class="fas fa-file-video me-2 text-primary"></i>
                            <a href="#" class="text-decoration-none">Lecture video</a>
                        </li>
                        <li>
                            <i class="fas fa-file-pdf me-2 text-danger"></i>
                            <a href="#" class="text-decoration-none">Lecture notes (PDF)</a>
                        </li>
                    `;
                }
            }

            // Initial button states
            updateButtonStates();

            // Add CSRF token to all AJAX requests
            $.ajaxSetup?.({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        });
    </script>
@endsection
