@extends('adminlte::page')

@section('page-title','Course Preview')

@section('title', 'Course Preview - ' . $course->title)

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Course Header -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="h2 font-weight-bold mb-2">{{ $course->title }}</h1>
                                <p class="text-muted mb-3">{{ Str::limit($course->description, 200) }}</p>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-3">
                                        <span class="badge badge-success p-2">
                                            {{ $course->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-muted">
                                            <i class="fas fa-user-graduate mr-1"></i>
                                            Created by {{ $course->teacher->name ?? 'Instructor' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="mr-4">
                                        <i class="fas fa-play-circle text-primary mr-1"></i>
                                        <span>{{ $totalLectures }} lectures</span>
                                    </div>
                                    <div>
                                        <i class="fas fa-signal text-primary mr-1"></i>
                                        <span>{{ $course->level ?? 'All Levels' }}</span>
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

                <!-- What You'll Learn -->
                {{-- <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h3 class="h4 font-weight-bold mb-0">What you'll learn</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($course->requirements && $course->requirements->count() > 0)
                                @foreach ($course->requirements->take(6) as $requirement)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex">
                                            <i class="fas fa-check text-success mt-1 mr-2"></i>
                                            <span>{{ $requirement->requirement }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">No learning objectives defined yet.</p>
                            @endif
                        </div>
                    </div>
                </div> --}}

                <!-- Course Content -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h3 class="h4 font-weight-bold mb-0">Course content</h3>
                        <span class="text-muted">{{ $totalSections }} sections • {{ $totalLectures }} lectures</span>
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
                                            <span>
                                                <i class="fas fa-chevron-down mr-2"></i>
                                                Section {{ $sectionIndex + 1 }}: {{ $section->title }}
                                            </span>
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
                                                    <div class="list-group-item border-0 px-0">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-play-circle text-muted mr-3"></i>
                                                                <div>
                                                                    <h6 class="mb-1">{{ $lecture->title }}</h6>
                                                                    <p class="text-muted mb-0 small">
                                                                        {{ Str::limit(strip_tags($lecture->description), 100) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <span class="badge badge-light">Preview</span>
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
                {{-- <div class="card mb-4">
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
                </div> --}}

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
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Pricing Card -->
                <div class="card shadow-lg mb-4" style="top: 20px;">
                    <div class="card-body">
                        @if ($price && $price->price > 0)
                            <div class="text-center mb-3">
                                <h2 class="font-weight-bold text-primary mb-0">
                                    {{ $price->currencySymbol }} {{ number_format($price->price, 2) }}
                                </h2>
                                <small class="text-muted">One-time payment</small>
                            </div>
                        @else
                            <div class="text-center mb-3">
                                <h2 class="font-weight-bold text-success mb-0">FREE</h2>
                                <small class="text-muted">No payment required</small>
                            </div>
                        @endif

                        <div class="mb-4">
                            <a href=""
                                class="btn btn-primary btn-lg btn-block mb-3">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                {{ $price && $price->price > 0 ? 'Enroll Now' : 'Enroll for Free' }}
                            </a>

                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    30-day money-back guarantee
                                </small>
                            </div>
                        </div>

                        <hr>

                        <h6 class="font-weight-bold mb-3">This course includes:</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-file-alt text-success mr-2"></i>
                                {{ $totalMaterials }} downloadable resources
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-infinity text-success mr-2"></i>
                                Full lifetime access
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-mobile-alt text-success mr-2"></i>
                                Access on mobile and TV
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-certificate text-success mr-2"></i>
                                Certificate of completion
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Instructor -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-3">Instructor</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <span class="text-white font-weight-bold h5 mb-0">
                                        {{ substr($course->instructor->name ?? 'I', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0">{{ $course->instructor->name ?? 'Instructor' }}</h6>
                                <p class="text-muted small mb-0">{{ $course->instructor->title ?? 'Course Instructor' }}
                                </p>
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
                            {{-- <div class="col-6">
                                <div class="h4 font-weight-bold text-danger mb-0">
                                    {{ $course->requirements ? $course->requirements->count() : 0 }}
                                </div>
                                <small class="text-muted">Requirements</small>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
            z-index: 1020;
        }

        .btn-link {
            text-decoration: none !important;
        }

        .btn-link:hover {
            color: #6f42c1 !important;
        }

        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .accordion .card-header {
            cursor: pointer;
        }

        .accordion .card-header:hover {
            background-color: #f1f1f1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Smooth scroll for accordion
            $('.accordion .card-header').click(function() {
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });
        });
    </script>
@endpush
