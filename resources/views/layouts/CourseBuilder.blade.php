<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Course Builder</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        /* Fixed sidebar adjustments */
        .wrapper {
            display: flex;
            flex-direction: row;
        }

        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            z-index: 1030;
            background-color: #343a40;
            /* Dark gray AdminLTE style */
        }

        .content-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f4f6f9;
            flex: 1;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: white;
            border-bottom: 1px solid #dee2e6;
        }

        /* Disabled link styling */
        .nav-link.disabled {
            opacity: 0.6;
            pointer-events: none;
            cursor: not-allowed;
        }

        /* Custom scrollbar for sidebar */
        .main-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .main-sidebar::-webkit-scrollbar-track {
            background: #2c3b41;
        }

        .main-sidebar::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 3px;
        }
    </style>

    @stack('css')
</head>

<body class="hold-transition">
    <div class="wrapper">
        <!-- Sidebar Component -->
        <x-course-builder-sidebar :course="$course" />

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand navbar-white navbar-light">
                <div class="container-fluid">
                    <a href="{{ route('course.index') }}" class="navbar-brand">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Courses
                    </a>
                    <div class="navbar-nav ml-auto">
                        <span class="nav-link">
                            <i class="fas fa-user-circle mr-1"></i>
                            {{ auth()->user()->name ?? 'Guest' }}
                        </span>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="content p-4">
                <div class="container-fluid">
                    {{-- Toast Messages --}}
                    <div aria-live="polite" aria-atomic="true"
                        style="position: fixed; top: 1rem; right: 1rem; z-index: 1080;">

                        {{-- Success --}}
                        @if (session('success'))
                            <div class="toast bg-success text-white mb-2" role="alert" data-delay="4000">
                                <div class="toast-body">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        {{-- Error --}}
                        @if (session('error'))
                            <div class="toast bg-danger text-white mb-2" role="alert" data-delay="4000">
                                <div class="toast-body">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="toast bg-warning text-dark mb-2" role="alert" data-delay="5000">
                                <div class="toast-body">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Page Header -->
                    <div class="mb-4">
                        <h3 class="mb-0">
                            @yield('page-title', 'Edit Course')
                        </h3>
                        <p class="text-muted mb-0">
                            @yield('page-subtitle', 'Manage your course content')
                        </p>
                        <hr>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        $(document).on('click', '.nav-link.disabled', function(e) {
            e.preventDefault();
            toastr.warning('Please complete previous steps first');
        });

        $(document).ready(function() {
            // Toasts
            $('.toast').toast('show');
        });
    </script>

    @stack('scripts')
</body>

</html>
