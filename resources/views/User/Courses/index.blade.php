@extends('layouts.user')
@section('page-title', 'Courses')

@section('css')
    <style>
        :root {
            --primary-color: #0c9488;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --light-bg: #f8f9fa;
            --dark-text: #2b2d42;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-text);
        }

        .courses-hero {
            background: linear-gradient(135deg, #0c9488 0%, #097d73 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .search-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 1rem 1rem 1rem 3rem;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .category-tag {
            padding: 0.5rem 1rem;
            background: #f0f2ff;
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .category-tag:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .category-tag.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .course-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .course-card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover img {
            transform: scale(1.05);
        }

        .course-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--accent-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .course-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .course-price.free {
            color: #28a745;
        }

        .course-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .course-meta i {
            margin-right: 0.25rem;
        }

        .no-courses {
            text-align: center;
            padding: 5rem 2rem;
        }

        .no-courses i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .select2-container--default .select2-selection--single {
            height: 52px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.5rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px;
        }

        .filter-toggle {
            display: none;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .filter-toggle {
                display: block;
            }

            .filter-column {
                position: fixed;
                top: 0;
                left: -100%;
                width: 80%;
                height: 100vh;
                background: white;
                z-index: 1050;
                padding: 2rem;
                transition: left 0.3s ease;
                overflow-y: auto;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            }

            .filter-column.show {
                left: 0;
            }

            .filter-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .filter-overlay.show {
                display: block;
            }

            .close-filter {
                position: absolute;
                top: 1rem;
                right: 1rem;
                font-size: 1.5rem;
                background: none;
                border: none;
                color: #6c757d;
            }
        }

        .course-stats {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading-spinner.active {
            display: block;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@endsection

@section('main-content')

    {{-- HERO SECTION --}}
    <section class="courses-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">Explore Our Courses</h1>
                    <p class="lead mb-4">Discover the perfect course to advance your skills and career</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SEARCH AND FILTER SECTION --}}
    <div class="container">
        <div class="search-section">
            <form id="searchForm" method="GET" action="">
                <div class="row g-3">
                    {{-- Search Input --}}
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" id="searchInput" class="form-control"
                                placeholder="Search courses by title, instructor, or keywords..."
                                value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Category Filter --}}
                    <div class="col-md-3">
                        <select class="select2 form-select" name="category" id="categorySelect">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Subcategory Filter --}}
                    <div class="col-md-3">
                        <select class="select2 form-select" name="subcategory" id="subcategorySelect">
                            <option value="">All Subcategories</option>
                            @if (isset($categories))
                                @foreach ($categories as $cat)
                                    @foreach ($cat->subcats as $subcat)
                                        <option value="{{ $subcat->id }}"
                                            {{ request('subcategory') == $subcat->id ? 'selected' : '' }}>
                                            {{ $subcat->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Level Filter --}}
                    <div class="col-md-3">
                        <select class="form-select" name="level" id="levelSelect">
                            <option value="">All Levels</option>
                            <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner
                            </option>
                            <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>
                                Intermediate
                            </option>
                            <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced
                            </option>
                        </select>
                    </div>

                    {{-- Price Filter --}}
                    <div class="col-md-3">
                        <select class="form-select" name="price" id="priceSelect">
                            <option value="">All Prices</option>
                            <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    {{-- Sort By --}}
                    <div class="col-md-3">
                        <select class="form-select" name="sort" id="sortSelect">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular
                            </option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated
                            </option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low
                                to High
                            </option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price:
                                High to Low
                            </option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn bg-teal-600 text-white w-100">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                            <a href="" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Quick Category Tags --}}
            <div class="mt-4">
                <h6 class="mb-3">Popular Categories:</h6>
                <div class="category-tags">
                    <span class="category-tag" data-category="all">All Courses</span>
                    @foreach ($categories->take(8) as $category)
                        <span class="category-tag" data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </span>
                    @endforeach
                    @if ($categories->count() > 8)
                        <span class="category-tag" data-bs-toggle="collapse" href="#moreCategories">
                            More <i class="fas fa-chevron-down ms-1"></i>
                        </span>
                        <div class="collapse mt-2" id="moreCategories">
                            <div class="category-tags">
                                @foreach ($categories->skip(8) as $category)
                                    <span class="category-tag" data-category="{{ $category->id }}">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER TOGGLE FOR MOBILE --}}
    <div class="filter-toggle container">
        <button class="btn btn-outline-primary w-100" id="toggleFilterBtn">
            <i class="fas fa-filter me-2"></i>Show Filters
        </button>
    </div>

    {{-- FILTER OVERLAY FOR MOBILE --}}
    <div class="filter-overlay" id="filterOverlay"></div>

    {{-- MAIN CONTENT --}}
    <div class="container my-5">
        <div class="row">
            {{-- COURSES COUNT --}}
            <div class="col-12 mb-4">
                <div class="course-stats">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">{{ $courses->total() }} courses found</h5>
                            @if (request()->anyFilled(['search', 'category', 'subcategory', 'level', 'price']))
                                <small class="text-muted">Filtered results</small>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary active" id="gridViewBtn">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="listViewBtn">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COURSES GRID/LIST --}}
            <div class="col-12">
                {{-- Loading Spinner --}}
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Loading courses...</p>
                </div>

                {{-- Courses Display --}}
                <div id="coursesContainer">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="coursesGrid">
                        @forelse ($courses as $course)
                            <div class="col">
                                <div class="card course-card">
                                    <div class="position-relative">
                                        <img src="{{ asset($course->thumbnail) }}" class="card-img-top"
                                            alt="{{ $course->title }}">
                                        @if ($course->price == 0)
                                            <div class="course-badge">FREE</div>
                                        @endif
                                        <div class="card-img-overlay d-flex align-items-start justify-content-end">
                                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="tooltip"
                                                title="Add to Wishlist">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-light text-dark">{{ $course->category->name }}</span>
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <small>4.5</small>
                                            </div>
                                        </div>
                                        <h5 class="card-title mb-2">{{ Str::limit($course->title, 50) }}</h5>
                                        <p class="card-text text-muted mb-3">{!! Str::limit(strip_tags($course->description), 100) !!}</p>

                                        <div class="course-meta mb-3">
                                            <span class="me-3">
                                                <i class="fas fa-user-graduate"></i>
                                                {{ $course->enrollments_count }} students
                                            </span>
                                            <span>
                                                <i class="fas fa-clock"></i>
                                                {{ $course->duration ?? 'N/A' }} hours
                                            </span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="course-price {{ $course->pricing->price === 0 ? 'free' : '' }}">
                                                    {{ $course->pricing->price == 0 ? 'Free' : '$' . number_format($course->pricing->price, 2) }}
                                                </span>
                                            </div>
                                            @if ($course->is_enrolled)
                                                <a href="{{ route('user.courseShow', $course->slug) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Go to course
                                                </a>
                                            @else
                                                <a href="{{ route('user.courseShow', $course->slug) }}"
                                                    class="btn bg-teal-600 text-white btn-sm">
                                                    View Course
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="no-courses">
                                    <i class="fas fa-book-open"></i>
                                    <h4>No courses found</h4>
                                    <p class="text-muted">Try adjusting your search or filter to find what you're
                                        looking for.</p>
                                    <a href="{{ route('user.courses') }}" class="btn btn-primary">Clear
                                        Filters</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- PAGINATION --}}
                @if ($courses->hasPages())
                    <div class="mt-5">
                        {{ $courses->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select category",
                allowClear: true
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Category tag click handler
            $('.category-tag').on('click', function(e) {
                e.preventDefault();
                const categoryId = $(this).data('category');

                if (categoryId === 'all') {
                    window.location.href = "{{ route('user.courses') }}";
                } else {
                    $('#categorySelect').val(categoryId).trigger('change');
                    $('#searchForm').submit();
                }
            });



            // Mobile filter toggle
            $('#toggleFilterBtn').on('click', function() {
                $('.filter-column').addClass('show');
                $('#filterOverlay').addClass('show');
            });

            $('#filterOverlay').on('click', function() {
                $('.filter-column').removeClass('show');
                $(this).removeClass('show');
            });

            $('.close-filter').on('click', function() {
                $('.filter-column').removeClass('show');
                $('#filterOverlay').removeClass('show');
            });

            // Grid/List view toggle
            $('#gridViewBtn').on('click', function() {
                $(this).addClass('active');
                $('#listViewBtn').removeClass('active');
                $('#coursesGrid').removeClass('row-cols-1').addClass(
                    'row-cols-1 row-cols-md-2 row-cols-lg-3');
                $('.course-card').css('max-height', 'none');
            });

            $('#listViewBtn').on('click', function() {
                $(this).addClass('active');
                $('#gridViewBtn').removeClass('active');
                $('#coursesGrid').removeClass('row-cols-1 row-cols-md-2 row-cols-lg-3').addClass(
                    'row-cols-1');
                $('.course-card').css('max-height', '200px');
            });

            // Auto-submit form on filter change
            $('#levelSelect, #priceSelect, #sortSelect').on('change', function() {
                $('#searchForm').submit();
            });

            // Debounced search input
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    $('#searchForm').submit();
                }, 500);
            });

            // AJAX loading for pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                loadCourses(url);
            });

            function loadCourses(url) {
                $('#loadingSpinner').addClass('active');

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#coursesContainer').html($(response).find('#coursesContainer').html());
                        $('#loadingSpinner').removeClass('active');
                        window.history.pushState({}, '', url);
                    },
                    error: function() {
                        $('#loadingSpinner').removeClass('active');
                        alert('Error loading courses. Please try again.');
                    }
                });
            }

            // Update URL with filters without page reload
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                const url = "{{ route('user.courses') }}?" + formData;
                loadCourses(url);
            });

            // Set active category tag based on current filter
            const currentCategory = "{{ request('category') }}";
            if (currentCategory) {
                $(`.category-tag[data-category="${currentCategory}"]`).addClass('active');
            } else {
                $('.category-tag[data-category="all"]').addClass('active');
            }
        });
    </script>
@endsection
