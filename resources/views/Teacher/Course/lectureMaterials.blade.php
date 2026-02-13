@extends('layouts.CourseBuilder')

@section('title', 'Lecture Materials')
@section('page-title', 'Lecture Materials')
@section('page-subtitle', 'Upload supporting files for lectures')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="step p-4" id="step-1">
                
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Tip:</strong> Upload supporting materials like PDFs, presentations, code files, or resources 
                    that help students learn better.
                </div>
                
                <form action="{{ route('courses.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data" id="materialsForm">
                    @csrf
                    
                    <div id="materialsContainer">
                        @foreach($course->sections as $sectionIndex => $section)
                            <div class="card card-outline card-info mb-4">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        <i class="fas fa-folder mr-2"></i>
                                        Section {{ $sectionIndex + 1 }}: {{ $section->title }}
                                    </h4>
                                </div>
                                
                                <div class="card-body">
                                    @foreach($section->lectures as $lectureIndex => $lecture)
                                        <div class="lecture-materials-section border rounded p-3 mb-3">
                                            <h5 class="mb-3">
                                                <i class="fas fa-video mr-2"></i>
                                                Lecture {{ $lectureIndex + 1 }}: {{ $lecture->title }}
                                            </h5>
                                            
                                            <!-- Existing Materials for this lecture -->
                                            @if($lecture->materials && $lecture->materials->count() > 0)
                                                <div class="existing-materials mb-4">
                                                    <h6 class="text-muted mb-2">
                                                        <i class="fas fa-paperclip mr-1"></i> 
                                                        Existing Materials ({{ $lecture->materials->count() }})
                                                    </h6>
                                                    <div class="list-group">
                                                        @foreach($lecture->materials as $material)
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <i class="fas fa-file-{{$material->fileType }} mr-2"></i>
                                                                    <strong>{{ $material->fileName }}</strong>
                                                                    <br>
                                                                    <small class="text-muted">
                                                                        Uploaded: {{ $material->created_at->format('M d, Y') }}
                                                                    </small>
                                                                </div>
                                                                <div>
                                                                    <a href="{{ asset($material->filePath) }}" 
                                                                       class="btn btn-sm btn-outline-primary mr-1" 
                                                                       target="_blank" 
                                                                       title="Preview">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ asset($material->filePath) }}" 
                                                                       class="btn btn-sm btn-outline-success mr-1" 
                                                                       download
                                                                       title="Download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            onclick="deleteMaterial({{ $material->id}})"
                                                                            title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-light mb-3">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                    No materials uploaded for this lecture yet.
                                                </div>
                                            @endif
                                            
                                            <!-- Upload new materials for this lecture -->
                                            <div class="upload-section">
                                                <div class="form-group">
                                                    <label for="materials_{{ $lecture->id }}">
                                                        <strong>Upload New Materials</strong>
                                                    </label>
                                                    <p class="text-muted small mb-2">
                                                        Select multiple files to upload (PDF, PPT, Word, Excel, ZIP, TXT etc.)
                                                    </p>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" 
                                                                   name="materials[{{ $lecture->id }}][]" 
                                                                   class="custom-file-input lecture-materials" 
                                                                   id="materials_{{ $lecture->id }}" 
                                                                   multiple
                                                                   data-lecture-id="{{ $lecture->id }}"
                                                                   accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar,.7z,.csv,.json,.xml,.md">
                                                            <label class="custom-file-label" for="materials_{{ $lecture->id }}">
                                                                Choose files...
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Maximum file size: 50MB each. Supported: PDF, PPT, Word, Excel, ZIP, TXT
                                                    </small>
                                                    
                                                    <!-- Selected files preview -->
                                                    <div id="selectedFiles_{{ $lecture->id }}" class="mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- No sections/lectures message -->
                    @if($course->sections->count() === 0)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h4>No Lectures Found</h4>
                            <p>You need to create sections and lectures first before uploading materials.</p>
                            <a href="{{ route('courses.curriculum', $course->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i> Create Curriculum First
                            </a>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    @if($course->sections->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('courses.requirements', $course->id) }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i> Back to Requirements
                                    </a>
                                    
                                    <div>
                                        <button type="submit" class="btn btn-primary" id="saveMaterialsBtn">
                                            <i class="fas fa-save mr-2"></i> Upload Materials
                                        </button>
                                        
                                        <a href="" 
                                           class="btn btn-success ml-2">
                                            Next: Pricing <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Material</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this material? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .lecture-materials-section {
        background-color: #f8f9fa;
        border-left: 4px solid #17a2b8 !important;
    }
    .file-icon {
        font-size: 1.2rem;
        margin-right: 8px;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .selected-file-item {
        background-color: #e7f3ff;
        border: 1px solid #b3d7ff;
        border-radius: 4px;
        padding: 8px 12px;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    .file-size {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    // File icon helper function
    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const icons = {
            'pdf': 'file-pdf',
            'ppt': 'file-powerpoint',
            'pptx': 'file-powerpoint',
            'doc': 'file-word',
            'docx': 'file-word',
            'xls': 'file-excel',
            'xlsx': 'file-excel',
            'txt': 'file-alt',
            'zip': 'file-archive',
            'rar': 'file-archive',
            '7z': 'file-archive',
            'csv': 'file-csv',
            'json': 'file-code',
            'xml': 'file-code',
            'md': 'file-alt'
        };
        return icons[ext] || 'file';
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Show selected files preview
    document.querySelectorAll('.lecture-materials').forEach(input => {
        input.addEventListener('change', function() {
            const lectureId = this.getAttribute('data-lecture-id');
            const previewContainer = document.getElementById(`selectedFiles_${lectureId}`);
            previewContainer.innerHTML = '';
            
            if (this.files.length > 0) {
                let html = '<div class="mt-2"><strong>Selected Files:</strong><div class="mt-1">';
                
                Array.from(this.files).forEach(file => {
                    const icon = getFileIcon(file.name);
                    html += `
                        <div class="selected-file-item">
                            <i class="fas fa-${icon} file-icon"></i>
                            <span>${file.name}</span>
                            <span class="file-size ml-2">(${formatFileSize(file.size)})</span>
                        </div>
                    `;
                });
                
                html += '</div></div>';
                previewContainer.innerHTML = html;
            }
        });
    });

    // Custom file input label
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function() {
            let fileName = 'Choose files...';
            if (this.files.length > 0) {
                if (this.files.length === 1) {
                    fileName = this.files[0].name;
                } else {
                    fileName = `${this.files.length} files selected`;
                }
            }
            this.nextElementSibling.textContent = fileName;
        });
    });

    // Delete material
    let materialToDelete = null;
    
    function deleteMaterial(materialId) {
        materialToDelete = materialId;
        $('#deleteMaterialModal').modal('show');
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (!materialToDelete) return;
        
        fetch(`/teacher/materials/${materialToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
                toastr.success('Material deleted successfully');
            } else {
                toastr.error('Failed to delete material');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error deleting material');
        })
        .finally(() => {
            $('#deleteMaterialModal').modal('hide');
            materialToDelete = null;
        });
    });

    // Form submission with progress
    document.getElementById('materialsForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('saveMaterialsBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';
    });
</script>
@endpush