@extends('layouts.CourseBuilder')

@section('css')
    <style>
        .checklist-item {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
        }

        .checklist-item.completed {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .checklist-item.incomplete {
            background-color: #fff3cd;
            border-color: #ffeaa7;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-published {
            background-color: #d4edda;
            color: #155724;
        }

        .status-draft {
            background-color: #fff3cd;
            color: #856404;
        }

        .preview-card {
            border: 2px solid #6f42c1;
            border-radius: 10px;
        }

        .publish-actions .btn {
            min-width: 150px;
        }
    </style>
@endsection

@section('title', 'Publish Course')
@section('page-title', 'Ready to Publish')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <!-- Course Preview -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-eye mr-2"></i> Course Preview
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($course->thumbnail)
                                    <img src="{{ asset($course->thumbnail) }}" class="img-fluid rounded"
                                        alt="{{ $course->title }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h3 class="font-weight-bold">{{ $course->title }}</h3>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    Created by {{ auth()->user()->name }}
                                </p>
                                <p class="mb-3">{{ Str::limit($course->description, 150) }}</p>

                                <div class="d-flex align-items-center mb-3">
                                    @if ($price && $price->price > 0)
                                        <h4 class="font-weight-bold text-primary mb-0">
                                            {{ $price->currencySymbol }} {{ number_format($price->price, 2) }}
                                        </h4>
                                    @else
                                        <span class="badge badge-success p-2">FREE</span>
                                    @endif

                                    <span class="badge badge-info ml-2 p-2">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        {{ $course->sections->sum(function ($section) {
                                            return $section->lectures->count();
                                        }) }}
                                        Lectures
                                    </span>
                                </div>

                                <a href="{{ route('course.preview', $course->id) }}" target="_blank"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt mr-1"></i> Preview Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checklist -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-tasks mr-2"></i> Publishing Checklist
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $completion = [
                                'basic' => $course->title && $course->description && $course->thumbnail,
                                'curriculum' => $course->sections->count() > 0,
                                'faqs' => $course->faqs->count() > 0,
                                'pricing' => isset($price),
                            ];
                            $totalComplete = array_sum($completion);
                            $totalItems = count($completion);
                            $percentage = ($totalComplete / $totalItems) * 100;
                        @endphp

                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="checklist">
                            <div class="checklist-item {{ $completion['basic'] ? 'completed' : 'incomplete' }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Basic Information
                                        </h6>
                                        <p class="mb-0 small">Course title, description, thumbnail, category</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="status-badge {{ $completion['basic'] ? 'status-published' : 'status-draft' }}">
                                            {{ $completion['basic'] ? 'Completed' : 'Incomplete' }}
                                        </span>
                                        <a href="{{ route('courses.basic', $course->id) }}"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="checklist-item {{ $completion['curriculum'] ? 'completed' : 'incomplete' }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fas fa-book mr-2"></i>
                                            Curriculum
                                        </h6>
                                        <p class="mb-0 small">Sections and lectures with content</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="status-badge {{ $completion['curriculum'] ? 'status-published' : 'status-draft' }}">
                                            {{ $completion['curriculum'] ? 'Completed' : 'Incomplete' }}
                                        </span>
                                        <a href="{{ route('courses.curriculum', $course->id) }}"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="checklist-item {{ $completion['faqs'] ? 'completed' : 'incomplete' }}">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fas fa-question-circle mr-2"></i>
                                            FAQs
                                        </h6>
                                        <p class="mb-0 small">Frequently asked questions</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="status-badge {{ $completion['faqs'] ? 'status-published' : 'status-draft' }}">
                                            {{ $completion['faqs'] ? 'Completed' : 'Incomplete' }}
                                        </span>
                                        <a href="{{ route('faq.index', $course->id) }}"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="checklist-item {{ $completion['pricing'] ? 'completed' : 'incomplete' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fas fa-tag mr-2"></i>
                                            Pricing
                                        </h6>
                                        <p class="mb-0 small">Set course price</p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="status-badge {{ $completion['pricing'] ? 'status-published' : 'status-draft' }}">
                                            {{ $completion['pricing'] ? 'Completed' : 'Incomplete' }}
                                        </span>
                                        <a href="{{ route('pricing.index', $course->id) }}"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-cogs mr-2"></i> Publish Settings
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('course.pending', $course->id) }}" method="POST"
                            id="publishForm">
                            @csrf
                            {{-- <div class="form-group">
                                <label class="font-weight-bold">Course Status</label>
                                <select name="status" class="form-control" id="courseStatus">
                                    <option value="draft" {{ $course->status === 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="published" {{ $course->status === 'published' ? 'selected' : '' }}>
                                        Published</option>
                                </select>
                            </div> --}}

                            {{-- <div class="form-group" id="scheduleSection" style="display: none;">
                                <label class="font-weight-bold">Schedule Publish Date</label>
                                <input type="datetime-local" name="publish_date" class="form-control"
                                    value="{{ $course->publish_date }}">
                                <small class="form-text text-muted">
                                    Course will auto-publish at this date/time
                                </small>
                            </div> --}}

                            {{-- <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="enableCertificate"
                                        name="enable_certificate" {{ $course->enable_certificate ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="enableCertificate">
                                        Enable Certificate of Completion
                                    </label>
                                </div>
                            </div> --}}

                            <div class="publish-actions text-center">
                                @if ($percentage == 100)
                                    @if ($course->status === 'draft')
                                        <button type="submit" name="action" value="pending"
                                            class="btn btn-success btn-block mb-3">
                                            <i class="fas fa-rocket mr-2"></i> Publish Request
                                        </button>
                                    @elseif ($course->status === 'pending')
                                        <span class="btn btn-warning btn-block mb-3">
                                            <i class="fas fa-rocket mr-2"></i> Requested
                                        </span>
                                    @elseif ($course->status === 'rejected')
                                        <span class="btn btn-danger btn-block mb-3">
                                            </i> Rejected
                                        </span>
                                        <button type="submit" name="action" value="pending"
                                            class="btn btn-success btn-block mb-3">
                                            <i class="fas fa-rocket mr-2"></i> Publish Request
                                        </button>   
                                    @elseif ($course->status === 'published')
                                        <span class="btn btn-success btn-block mb-3">
                                            <i class="fas fa-rocket mr-2"></i> Published
                                        </span>
                                    @endif
                                @else
                                    <div class="alert alert-warning mb-3">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Complete all checklist items to publish
                                    </div>
                                @endif

                                <a href="{{ route('course.preview', $course->id) }}" target="_blank"
                                    class="btn btn-outline-secondary btn-block">
                                    <i class="fas fa-external-link-alt mr-2"></i> Preview Course
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-chart-bar mr-2"></i> Course Stats
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-primary">
                                    {{ $course->sections->count() }}
                                </div>
                                <small class="text-muted">Sections</small>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="display-4 font-weight-bold text-info">
                                    {{ $course->sections->sum(function ($section) {
                                        return $section->lectures->count();
                                    }) }}
                                </div>
                                <small class="text-muted">Lectures</small>
                            </div>
                            <div class="col-6">
                                <div class="display-4 font-weight-bold text-warning">
                                    {{ $course->faqs->count() }}
                                </div>
                                <small class="text-muted">FAQs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Show/hide schedule section based on status
            $('#courseStatus').change(function() {
                if ($(this).val() === 'published') {
                    $('#scheduleSection').show();
                } else {
                    $('#scheduleSection').hide();
                }
            });

            // Trigger change on page load
            $('#courseStatus').trigger('change');

            // Confirm publish
            $('button[value="publish"]').click(function(e) {
                if (!confirm(
                        'Are you sure you want to publish this course? It will be visible to students.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
