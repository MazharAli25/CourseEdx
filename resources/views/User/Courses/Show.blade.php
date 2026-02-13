@extends('layouts.user')

@section('page-title', $course->title)

@section('css')
    <style>
        /* Tabs */
        .course-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border: none;
            border-bottom: 3px solid transparent;
        }

        .course-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        /* Curriculum */
        .section-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .section-header {
            background: #f8f9fa;
            padding: 1rem 1.25rem;
            cursor: pointer;
            border: none;
            width: 100%;
            text-align: left;
        }

        .lecture-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .lecture-item:last-child {
            border-bottom: none;
        }

        .material-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        /* Instructor Card */
        .instructor-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
        }

        /* Reviews */
        .review-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
        }

        .rating-stars {
            color: #ffc107;
        }

        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .course-hero {
                padding: 2rem 0 1rem;
            }
        }
    </style>
@endsection

@section('main-content')
    @php
        // Calculate totals
        $totalLectures = $course->sections->sum(fn($section) => $section->lectures->count());
        // $totalMaterials = $course->lectures->sum(fn($lecture) => $lecture->materials->count());
    @endphp

    <!-- ================= HERO SECTION ================= -->
    <section class="bg-gray-900 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Main Course Info -->
                <div class="lg:w-2/3">
                    <nav class="text-sm mb-4">
                        <ol class="flex items-center space-x-2 text-gray-300">
                            <li><a href="" class="hover:text-white transition">Courses</a></li>
                            <li class="text-gray-500">/</li>
                            <li><a href="#"
                                    class="hover:text-white transition">{{ $course->category->name ?? 'General' }}</a></li>
                            <li class="text-gray-500">/</li>
                            <li class="text-white truncate">{{ $course->title }}</li>
                        </ol>
                    </nav>

                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight mt-20">
                        {{ $course->title }}
                    </h1>

                    <p class="text-xl text-gray-300 mb-6 max-w-3xl">
                        {{ Str::limit(strip_tags($course->description), 180) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        <!-- Rating -->
                        <div class="flex items-center">
                            <span class="text-yellow-400 font-bold text-lg mr-1">4.5</span>
                            <div class="flex mr-2">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <a href="#" class="text-teal-300 hover:text-teal-200 text-sm">
                                ({{ $course->reviews_count ?? 0 }} ratings)
                            </a>
                        </div>

                        <!-- Students -->
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-300">
                            {{ number_format($course->enrollments_count ?? 0) }} students
                        </span>

                        <span class="text-gray-300">•</span>
                        <span class="px-3 py-1 bg-gray-800 rounded-full text-sm capitalize">
                            {{ $course->level }}
                        </span>
                    </div>

                    <div class="flex items-center text-gray-300">
                        <span>Created by </span>
                        <a href="#" class="ml-2 text-teal-300 hover:text-teal-200 font-medium">
                            {{ $course->teacher->name ?? 'Instructor' }}
                        </a>
                    </div>

                    <!-- Last Updated -->
                    <div class="mt-4 text-sm text-gray-400">
                        <span>Last updated {{ \Carbon\Carbon::parse($course->updated_at)->format('F Y') }}</span>
                    </div>
                </div>

                <!-- Side Card -->
                <div class="lg:w-1/3">
                    <div class="bg-white text-gray-900 rounded-lg shadow-2xl overflow-hidden sticky top-6">
                        <!-- Course Video Preview -->
                        <div class="relative">
                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"
                                class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                <button
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Pricing -->
                            <div class="flex items-center mb-4">
                                <span class="text-3xl font-bold text-gray-900">
                                    @if ($course->pricing->price == 0)
                                        Free
                                    @else
                                        {{ $course->pricing->currencySymbol }}
                                        {{ number_format($course->pricing->price, 2) }}
                                    @endif
                                </span>

                                {{-- Discount --}}
                                {{-- @if ($course->original_price && $course->original_price > $course->price)
                                    <span class="ml-3 text-lg text-gray-500 line-through">
                                        ${{ number_format($course->original_price, 2) }}
                                    </span>
                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded">
                                        {{ round((($course->original_price - $course->price) / $course->original_price) * 100) }}%
                                        off
                                    </span>
                                @endif --}}
                            </div>

                            <!-- Buttons -->
                            <div class="space-y-3">
                                @if (auth()->check() && auth()->user()->hasEnrolled($course->id))
                                    <a href="{{ route('student.learning', $course->slug) }}"
                                        class="block w-full bg-teal-600 text-white text-center py-3 px-4 rounded-lg font-semibold hover:bg-teal-700 transition duration-200">
                                        Continue Learning
                                    </a>
                                @else
                                    <form action="{{ route('enroll.store', $course->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-teal-700 transition duration-200 block text-center">
                                            Enroll Now
                                        </button>
                                    </form>
                                    <button
                                        class="w-full border-2 border-gray-300 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-50 transition duration-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Add to Wishlist
                                    </button>
                                @endif

                            </div>

                            <!-- Money Back Guarantee -->
                            <p class="text-center text-sm text-gray-500 mt-4">
                                30-Day Money-Back Guarantee
                            </p>

                            <!-- Course Includes -->
                            {{-- <div class="mt-6 pt-6 border-t">
                                <h3 class="font-bold text-gray-900 mb-3">This course includes:</h3>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $totalDuration ?? '10' }} hours on-demand video
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $course->sections->count() ?? 0 }} lectures
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Full lifetime access
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Certificate of completion
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Access on mobile and TV
                                    </li>
                                </ul>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                {{-- TABS NAVIGATION --}}
                <ul class="nav nav-tabs course-tabs mb-4" id="courseTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                            type="button">
                            <i class="bi bi-info-circle me-2"></i>Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum"
                            type="button">
                            <i class="bi bi-list-check me-2"></i>Curriculum
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor"
                            type="button">
                            <i class="bi bi-person me-2"></i>Instructor
                        </button>
                    </li>
                    @if ($course->faqs->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq"
                                type="button">
                                <i class="bi bi-question-circle me-2"></i>FAQ ({{ $course->faqs->count() }})
                            </button>
                        </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button">
                            <i class="bi bi-person me-2"></i>Reviews
                        </button>
                    </li>
                </ul>

                {{-- TAB CONTENT --}}
                <div class="tab-content" id="courseTabContent">
                    {{-- OVERVIEW TAB --}}
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Course Description</h4>
                                <div class="course-description">
                                    {!! $course->description !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CURRICULUM TAB --}}
                    <div class="tab-pane fade" id="curriculum" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Course Curriculum</h4>
                                    <div class="text-muted">
                                        {{ $course->sections->count() }} sections • {{ $totalLectures }} lectures
                                    </div>
                                </div>

                                @if ($course->sections->count() > 0)
                                    @foreach ($course->sections as $section)
                                        <div class="section-card mb-3">
                                            <button class="section-header" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#section{{ $section->id }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>Section {{ $loop->iteration }}:</strong>
                                                        {{ $section->title }}
                                                        <span
                                                            class="badge bg-secondary ms-2">{{ $section->lectures->count() }}
                                                            lectures</span>
                                                    </div>
                                                    <i class="bi bi-chevron-down"></i>
                                                </div>
                                            </button>

                                            <div class="collapse text-black" id="section{{ $section->id }}">
                                                <div>
                                                    @foreach ($section->lectures as $lecture)
                                                        <div class="lecture-item">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <h6 class="mb-1">
                                                                        <i class="bi bi-play-circle text-primary me-2"></i>
                                                                        {{ $lecture->title }}
                                                                    </h6>
                                                                    @if ($lecture->description)
                                                                        <p class="text-muted small mb-2">
                                                                            {!! Str::limit($lecture->description, 150) !!}</p>
                                                                    @endif

                                                                    {{-- Display Materials --}}
                                                                    @if ($lecture->materials->count() > 0)
                                                                        <div class="mt-2">
                                                                            <small
                                                                                class="text-muted d-block mb-1">Materials:</small>
                                                                            <div class="d-flex flex-wrap gap-1">
                                                                                @foreach ($lecture->materials as $material)
                                                                                    <a href="{{ asset('storage/' . $material->file_path) }}"
                                                                                        target="_blank"
                                                                                        class="badge bg-light text-dark text-decoration-none border">
                                                                                        <i class="bi bi-download me-1"></i>
                                                                                        {{ Str::limit(basename($material->file_path), 20) }}
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                {{-- @if (auth()->check() && auth()->user()->hasEnrolled($course)) --}}
                                                                @if (auth()->check())
                                                                    @if ($lecture->video_file)
                                                                        <a href="{{ asset('storage/' . $lecture->video_file) }}"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            target="_blank">
                                                                            <i class="bi bi-play-fill"></i> Watch
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="py-4 text-center">
                                        <i class="bi bi-folder-x display-1 text-muted mb-3"></i>
                                        <p class="text-muted">No curriculum available for this course yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- INSTRUCTOR TAB --}}
                    <div class="tab-pane fade" id="instructor" role="tabpanel">
                        <div class="instructor-card">
                            <div class="row">
                                <div class="col-md-3 mb-md-0 mb-3 text-center">
                                    <img src="{{ $course->teacher->image ? asset($course->teacher->image) : asset('images/default-avatar.png') }}"
                                        alt="{{ $course->teacher->name }}" class="rounded-circle mb-3"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                    <h3>{{ $course->teacher->name }}</h3>
                                    <p class="text-muted mb-4">
                                        <i class="bi bi-award me-1"></i> Instructor
                                    </p>

                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-play-circle text-primary fs-4 me-2"></i>
                                                <div>
                                                    <h5 class="mb-0">{{ $course->teacher->courses()->count() }}</h5>
                                                    <small class="text-muted">Courses</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-people text-primary fs-4 me-2"></i>
                                                <div>
                                                    <h5 class="mb-0">
                                                        {{-- @php
                              $totalStudents = $course->user->courses->sum(function ($course) {
                                  return $course->enrollments()->count();
                              });
                            @endphp --}}
                                                        {{-- {{ number_format($totalStudents) }} --}}
                                                    </h5>
                                                    <small class="text-muted">Students</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($course->teacher->bio)
                                        <div class="mb-4">
                                            <h5>About Instructor</h5>
                                            <p>{{ $course->user->bio }}</p>
                                        </div>
                                    @endif

                                    {{-- Display instructor's other courses --}}
                                    @php
                                        $otherCourses = $course->teacher
                                            ->courses()
                                            ->where('id', '!=', $course->id)
                                            ->where('status', 'published')
                                            ->limit(10)
                                            ->get();
                                    @endphp

                                    @if ($otherCourses->count() > 0)
                                        <div>
                                            <h5 class="mb-3">Other Courses by {{ $course->user->name }}</h5>
                                            <div class="row g-3">
                                                @foreach ($otherCourses as $otherCourse)
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center rounded border p-3">
                                                            <img src="{{ asset('storage/' . $otherCourse->thumbnail) }}"
                                                                alt="{{ $otherCourse->title }}" class="me-3 rounded"
                                                                style="width: 60px; height: 60px; object-fit: cover;">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-1">
                                                                    {{ Str::limit($otherCourse->title, 40) }}</h6>
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <small
                                                                        class="text-muted">{{ $otherCourse->category->name }}</small>
                                                                    @if ($otherCourse->price == 0)
                                                                        <span class="badge bg-success">Free</span>
                                                                    @else
                                                                        <span
                                                                            class="fw-bold">${{ number_format($otherCourse->price, 2) }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('user.courseShow', $otherCourse->slug) }}"
                                                                class="btn btn-sm btn-outline-primary ms-3">
                                                                View
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FAQ TAB --}}
                    @if ($course->faqs->count() > 0)
                        <div class="tab-pane fade" id="faq" role="tabpanel">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Frequently Asked Questions</h4>
                                    <div class="accordion" id="faqAccordion">
                                        @foreach ($course->faqs as $faq)
                                            <div class="accordion-item mb-2">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#faq{{ $faq->id }}">
                                                        {{ $faq->question }}
                                                    </button>
                                                </h2>
                                                <div id="faq{{ $faq->id }}" class="accordion-collapse collapse"
                                                    data-bs-parent="#faqAccordion">
                                                    <div class="accordion-body">
                                                        {!! $faq->answer !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <!-- REVIEWS TAB -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Student Reviews</h4>

                                <!-- Average Rating & Distribution -->
                                <div class="row mb-5">
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <div class="display-1 fw-bold text-primary">4.5</div>
                                        <div class="rating-stars mb-2">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        </div>
                                        <p class="text-muted">Based on 5 reviews</p>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Rating bars (static) -->
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">5 stars</div>
                                            <div class="col-8">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 80%"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">4</div>
                                        </div>
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">4 stars</div>
                                            <div class="col-8">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 60%"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">3</div>
                                        </div>
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">3 stars</div>
                                            <div class="col-8">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 20%"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">1</div>
                                        </div>
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">2 stars</div>
                                            <div class="col-8">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 0%"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">0</div>
                                        </div>
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">1 star</div>
                                            <div class="col-8">
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 0%"></div>
                                                </div>
                                            </div>
                                            <div class="col-2">0</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Write a Review button (static) -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">What students are saying</h5>
                                    <button class="btn btn-primary" disabled>Write a Review</button>
                                </div>

                                <!-- Sample reviews -->
                                <div class="review-card">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong>John Doe</strong>
                                            <span class="text-muted ms-2">2 days ago</span>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Excellent course! Very well explained and the examples are practical.
                                        Highly recommended for beginners.</p>
                                </div>

                                <div class="review-card">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong>Jane Smith</strong>
                                            <span class="text-muted ms-2">1 week ago</span>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="far fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">Great content, but some sections could be more detailed. Overall a
                                        good course.</p>
                                </div>

                                <div class="review-card">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong>Mike Johnson</strong>
                                            <span class="text-muted ms-2">2 weeks ago</span>
                                        </div>
                                        <div class="rating-stars">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">The instructor explains complex topics very clearly. I learned a lot
                                        in just a few hours.</p>
                                </div>

                                <!-- Pagination (static) -->
                                <nav class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">
                {{-- Similar Courses by Category --}}
                @php
                    $similarCourses = \App\Models\Course::where('categoryId', $course->categoryId)
                        ->where('id', '!=', $course->id)
                        ->where('status', 'published')
                        ->limit(10)
                        ->get();
                @endphp

                @if ($similarCourses->count() > 0)
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-collection-play text-primary me-2"></i>
                                Similar Courses
                            </h5>
                            @foreach ($similarCourses as $similar)
                                <div class="d-flex border-bottom mb-3 pb-3">
                                    <img src="{{ asset('storage/' . $similar->thumbnail) }}" alt="{{ $similar->title }}"
                                        class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($similar->title, 40) }}</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $similar->user->name }}</small>
                                            @if ($similar->price == 0)
                                                <span class="badge bg-success">Free</span>
                                            @else
                                                <span
                                                    class="fw-bold text-primary">${{ number_format($similar->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('courses.course_show', $similar->slug) }}"
                                            class="stretched-link"></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Course Features --}}
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-check-circle text-primary me-2"></i>
                            What's Included
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                {{ $totalLectures }} on-demand lectures
                            </li>
                            {{-- <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                {{ $totalMaterials }} downloadable resources
                            </li> --}}
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                {{ $course->sections->count() }} course sections
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                Access on mobile and desktop
                            </li>
                            @if ($course->faqs->count() > 0)
                                <li class="mb-2">
                                    <i class="bi bi-check text-success me-2"></i>
                                    {{ $course->faqs->count() }} FAQ support
                                </li>
                            @endif
                            @if ($course->price == 0)
                                <li class="mb-0">
                                    <i class="bi bi-check text-success me-2"></i>
                                    Free forever access
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Share Course --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-share text-primary me-2"></i>
                            Share this course
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-grow-1" onclick="shareOnFacebook()">
                                <i class="bi bi-facebook me-2"></i>Facebook
                            </button>
                            <button class="btn btn-outline-info btn-sm flex-grow-1" onclick="shareOnTwitter()">
                                <i class="bi bi-twitter me-2"></i>Twitter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script>
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent("Check out this course: {{ $course->title }}");
            //   window.open(https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}, '_blank');
        }

        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent("Check out this course: {{ $course->title }}");
            //   window.open(https://twitter.com/intent/tweet?url=${url}&text=${text}, '_blank');
        }
    </script>
@endsection
