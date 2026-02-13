@extends('layouts.CourseBuilder')

@section('title', 'Course Requirements')
@section('page-title', 'Requirements & Target Audience')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="step p-4" id="step-1">
                <form action="" method="POST" id="requirementsForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Tip:</strong> Be specific about what students need to know and who this course is for.
                        This helps students decide if the course is right for them.
                    </div>
                    
                    <div class="row">
                        <!-- Left Column: Requirements -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-tasks mr-2"></i>
                                        Course Requirements
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="requirements">
                                            <strong>What do students need to know before taking this course?</strong>
                                        </label>
                                        <p class="text-muted small mb-2">
                                            List any prerequisites, software, tools, or knowledge required.
                                        </p>
                                        <textarea name="requirements" id="requirements" 
                                                  class="form-control @error('requirements') is-invalid @enderror"
                                                  rows="10"
                                                  placeholder="Example:
• Basic understanding of HTML & CSS
• Laptop with internet connection
• No prior programming experience needed">{{ old('requirements', $course->requirements) }}</textarea>
                                        @error('requirements')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="alert alert-light mt-3">
                                        <h6><i class="fas fa-lightbulb mr-1"></i> Good examples:</h6>
                                        <ul class="mb-0">
                                            <li>"No prior experience needed - perfect for beginners"</li>
                                            <li>"Basic knowledge of JavaScript required"</li>
                                            <li>"A computer with Python installed"</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column: Target Audience -->
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-users mr-2"></i>
                                        Target Audience
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="target_audience">
                                            <strong>Who is this course for?</strong>
                                        </label>
                                        <p class="text-muted small mb-2">
                                            Describe the ideal student for this course.
                                        </p>
                                        <textarea name="target_audience" id="target_audience" 
                                                  class="form-control @error('target_audience') is-invalid @enderror"
                                                  rows="10"
                                                  placeholder="Example:
• Beginners who want to learn web development
• Designers looking to add coding skills
• Students preparing for front-end developer jobs">{{ old('target_audience', $course->target_audience) }}</textarea>
                                        @error('target_audience')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group mt-4">
                                        <label for="what_you_will_learn">
                                            <strong>What will students learn? (Optional)</strong>
                                        </label>
                                        <p class="text-muted small mb-2">
                                            Key skills or outcomes students will achieve.
                                        </p>
                                        <textarea name="what_you_will_learn" id="what_you_will_learn" 
                                                  class="form-control"
                                                  rows="5"
                                                  placeholder="Example:
• Build responsive websites with HTML & CSS
• Create interactive web applications
• Deploy websites to live servers">{{ old('what_you_will_learn', $course->what_you_will_learn) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('courses.curriculum', $course->id) }}" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Curriculum
                                </a>
                                
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i> Save Requirements
                                    </button>
                                    
                                    <a href="{{ route('courses.faqs', $course->id) }}" 
                                       class="btn btn-success ml-2">
                                        Next: FAQs <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card-primary {
        border-top: 3px solid #007bff;
    }
    .card-success {
        border-top: 3px solid #28a745;
    }
    textarea {
        font-size: 14px;
        line-height: 1.6;
    }
    textarea:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-resize textareas based on content
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
    
    // Apply to all textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
        // Initialize on load
        autoResize(textarea);
    });
    
    // Character counter (optional)
    document.querySelectorAll('textarea').forEach(textarea => {
        const counter = document.createElement('div');
        counter.className = 'text-right text-muted small mt-1';
        counter.innerHTML = `<span class="char-count">0</span> characters`;
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            counter.querySelector('.char-count').textContent = count;
            
            // Visual feedback
            if (count > 1000) {
                counter.style.color = '#28a745';
            } else if (count > 100) {
                counter.style.color = '#007bff';
            } else {
                counter.style.color = '#6c757d';
            }
        });
        
        // Trigger initial count
        textarea.dispatchEvent(new Event('input'));
    });
</script>
@endpush