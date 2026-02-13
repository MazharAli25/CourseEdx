@extends('layouts.CourseBuilder')

@section('css')
    <style>
        .faq-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 15px;
            background: white;
        }

        .faq-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .faq-header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
        }

        .faq-question {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .faq-answer {
            padding: 20px;
            background: white;
            border-radius: 0 0 8px 8px;
            line-height: 1.6;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #dee2e6;
        }
    </style>
@endsection

@section('title', 'Manage FAQs')
@section('page-title', 'Manage FAQs - ' . $course->title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- FAQs List -->
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-question-circle mr-1"></i> Course FAQs
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ count($faqs) }} Questions</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (count($faqs) > 0)
                        <div class="list-group list-group-flush" id="faqList">
                            @foreach ($faqs as $index => $faq)
                                <div class="p-4 list-group-item faq-card">
                                    <div class="faq-header d-flex justify-content-between align-items-center">
                                        <h5 class="faq-question mb-0">
                                            {{ $index + 1 }}. {{ $faq->question }}
                                        </h5>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary edit-faq-btn mr-2"
                                                data-toggle="modal" data-target="#editFaqModal"
                                                data-id="{{ $faq->id }}" data-question="{{ $faq->question }}"
                                                data-answer="{{ htmlspecialchars($faq->answer, ENT_QUOTES, 'UTF-8') }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-faq-btn"
                                                data-toggle="modal" data-target="#deleteFaqModal"
                                                data-id="{{ $faq->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="faq-answer ml-4">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state m-4">
                            <i class="fas fa-question-circle"></i>
                            <h4>No FAQs Yet</h4>
                            <p>Add some frequently asked questions to help your students.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Add FAQ Form -->
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus mr-1"></i> Add New FAQ
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('faq.index', $course->id) }}" method="POST" id="faqForm">
                        @csrf

                        <div class="form-group">
                            <label for="question">Question</label>
                            <textarea name="question" class="form-control" rows="3" placeholder="Enter the question" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea name="answer" class="form-control summernote" rows="5" placeholder="Enter the answer" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Save FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="editFaqForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <textarea name="question" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="answer" class="form-control summernote" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete FAQ Modal -->
    <div class="modal fade" id="deleteFaqModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="deleteFaqForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['view', ['fullscreen']]
                ]
            });

            // Edit FAQ button click
            $('.edit-faq-btn').click(function() {
                var faqId = $(this).data('id');
                var question = $(this).data('question');
                var encodedAnswer = $(this).data('answer');

                // Decode the HTML entities
                var answer = $('<div/>').html(encodedAnswer).text();

                $('#editFaqForm textarea[name="question"]').val(question);

                var answerTextarea = $('#editFaqForm textarea[name="answer"]');

                // Destroy and reinitialize Summernote
                if (answerTextarea.summernote('instance')) {
                    answerTextarea.summernote('destroy');
                }

                // Initialize fresh
                answerTextarea.summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ]
                });

                // Set the content
                answerTextarea.summernote('code', answer);

                $('#editFaqForm').attr('action', '/teacher/courses/{{ $course->id }}/faq/' + faqId);
            });

            // Delete FAQ button click
            $('.delete-faq-btn').click(function() {
                var faqId = $(this).data('id');
                $('#deleteFaqForm').attr('action', '/teacher/courses/{{ $course->id }}/faq/' + faqId);
            });

            // Handle form submission
            $('#faqForm').submit(function() {
                var content = $('.summernote').summernote('code');
                $(this).find('textarea[name="answer"]').val(content);
                return true;
            });

            $('#editFaqForm').submit(function() {
                return true;
            });

            $('#deleteFaqForm').submit(function() {
                return true;
            });
        });
    </script>
@endpush
