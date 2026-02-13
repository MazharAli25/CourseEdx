@extends('adminlte::page')

@section('title', 'Create New Course')

@section('content_header')
    <h1>Create New Course</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data" id="courseForm">
            @csrf

            <!-- Wizard Steps -->
            <div class="step p-4" id="step-0">
                <h4 class="mb-3"><i class="fas fa-info-circle"></i> Course Info</h4>
                <div class="form-group">
                    <label>Course Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter course title" required>
                </div>
                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="description" class="form-control" placeholder="Brief description"></textarea>
                </div>
                <div class="form-group">
                    <label>Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control-file" accept="image/*">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        <select name="category_id" id="categorySelect" class="form-control" required>
                            <option value="">Select Category</option>
                            {{-- @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Subcategory</label>
                        <select name="subcategory_id" id="subcategorySelect" class="form-control" required>
                            <option value="">Select Subcategory</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Step 2: Curriculum -->
            <div class="step p-4" id="step-1" style="display:none;">
                <h4 class="mb-3"><i class="fas fa-book"></i> Curriculum</h4>
                <div id="sectionsContainer"></div>
                <button type="button" class="btn btn-success mt-2" onclick="addSection()"><i class="fas fa-plus"></i> Add Section</button>
            </div>

            <!-- Step 3: Requirements & Target Audience -->
            <div class="step p-4" id="step-2" style="display:none;">
                <h4 class="mb-3"><i class="fas fa-tasks"></i> Requirements & Target Audience</h4>
                <div class="form-group">
                    <label>Course Requirements</label>
                    <textarea name="requirements" class="form-control" placeholder="E.g., Basic Python knowledge..."></textarea>
                </div>
                <div class="form-group">
                    <label>Who Can Learn This / Target Audience</label>
                    <textarea name="target_audience" class="form-control" placeholder="E.g., Beginners in web development..."></textarea>
                </div>
            </div>

            <!-- Step 4: FAQs -->
            <div class="step p-4" id="step-3" style="display:none;">
                <h4 class="mb-3"><i class="fas fa-question-circle"></i> FAQs</h4>
                <div id="faqContainer"></div>
                <button type="button" class="btn btn-info mt-2" onclick="addFAQ()"><i class="fas fa-plus"></i> Add FAQ</button>
            </div>

            <!-- Step 5: Pricing & Publish -->
            <div class="step p-4" id="step-4" style="display:none;">
                <h4 class="mb-3"><i class="fas fa-dollar-sign"></i> Pricing & Publish</h4>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" placeholder="0 for free">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="draft">Draft</option>
                        <option value="published">Publish</option>
                    </select>
                </div>
            </div>

            <!-- Wizard Navigation -->
            <div class="mt-4 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display:none;">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                <button type="submit" class="btn btn-success" id="submitBtn" style="display:none;">Save Course</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    // Wizard Navigation
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    function showStep(n){
        steps.forEach((step,i)=> step.style.display = i===n?'block':'none');
        prevBtn.style.display = n===0?'none':'inline-block';
        nextBtn.style.display = n===steps.length-1?'none':'inline-block';
        submitBtn.style.display = n===steps.length-1?'inline-block':'none';
    }
    showStep(currentStep);

    nextBtn.addEventListener('click', ()=>{
        if(currentStep<steps.length-1) currentStep++;
        showStep(currentStep);
    });
    prevBtn.addEventListener('click', ()=>{
        if(currentStep>0) currentStep--;
        showStep(currentStep);
    });

    // Subcategory filtering
    

    // Sections & Lectures
    let sectionIndex = 0;
    function addSection(){
        const container = document.getElementById('sectionsContainer');
        const sectionHTML = `
        <div class="card card-outline card-primary mb-3 section-box">
            <div class="card-header">
                <strong>Section ${sectionIndex+1}</strong>
                <button type="button" class="btn btn-sm btn-danger float-right" onclick="this.closest('.section-box').remove()">Remove</button>
            </div>
            <div class="card-body">
                <input type="text" name="sections[${sectionIndex}][title]" class="form-control mb-2" placeholder="Section Title" required>
                <div id="lecturesContainer${sectionIndex}"></div>
                <button type="button" class="btn btn-success mt-2" onclick="addLecture(${sectionIndex})"><i class="fas fa-plus"></i> Add Lecture</button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend',sectionHTML);
        sectionIndex++;
    }

    function addLecture(secIdx){
        const lecturesContainer = document.getElementById(`lecturesContainer${secIdx}`);
        const lectureCount = lecturesContainer.children.length;
        const lectureHTML = `
        <div class="border p-2 mb-2 rounded lecture-box">
            <input type="text" name="sections[${secIdx}][lectures][${lectureCount}][title]" placeholder="Lecture Title" class="form-control mb-1" required>
            <label>Video URL:</label>
            <input type="url" name="sections[${secIdx}][lectures][${lectureCount}][video_url]" class="form-control mb-1">
            <label>Or Upload Video:</label>
            <input type="file" name="sections[${secIdx}][lectures][${lectureCount}][video_file]" class="form-control-file mb-1" accept="video/*">
            <label>Supporting Materials (PDF, PPT):</label>
            <input type="file" name="sections[${secIdx}][lectures][${lectureCount}][materials][]" multiple class="form-control-file mb-1" accept=".pdf,.ppt,.pptx">
            <textarea name="sections[${secIdx}][lectures][${lectureCount}][description]" class="form-control mb-1" placeholder="Lecture Description"></textarea>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.lecture-box').remove()">Remove Lecture</button>
        </div>`;
        lecturesContainer.insertAdjacentHTML('beforeend', lectureHTML);
    }

    // FAQs
    let faqIndex = 0;
    function addFAQ(){
        const container = document.getElementById('faqContainer');
        const html = `
        <div class="border p-3 mb-2 rounded">
            <input type="text" name="faqs[${faqIndex}][question]" placeholder="Question" class="form-control mb-1" required>
            <textarea name="faqs[${faqIndex}][answer]" placeholder="Answer" class="form-control mb-1" required></textarea>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('div').remove()">Remove FAQ</button>
        </div>`;
        container.insertAdjacentHTML('beforeend',html);
        faqIndex++;
    }
</script>
@endsection
