@extends('adminlte::page')

@section('title', 'Create Privacy Policy')

@section('content_header')
    <h1>Privacy Policy Sections</h1>
@endsection

@section('content')

    <div class="card">

        {{-- ================= UPDATED AREA START ================= --}}
        {{-- Removed "Add New Section" button from header --}}
        <div class="card-header">
            <h3 class="card-title">Manage Privacy Policy Sections</h3>
        </div>
        {{-- ================= UPDATED AREA END ================= --}}

        <div class="card-body">

            <form action="{{ route('privacy-policy.store') }}" method="POST">
                @csrf

                <div id="sectionsContainer">
                    <!-- Sections will be injected here -->
                </div>

                {{-- ================= UPDATED AREA START ================= --}}
                {{-- Both buttons moved to the bottom --}}
                <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-success" id="addSectionBtn">
                        <i class="fas fa-plus"></i> Add New Section
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Privacy Policy
                    </button>
                </div>
                {{-- ================= UPDATED AREA END ================= --}}

            </form>

        </div>
    </div>

@endsection

@section('js')
    <script>
        let sectionIndex = 0;

        document.getElementById('addSectionBtn').addEventListener('click', addSection);

        function addSection() {
            const container = document.getElementById('sectionsContainer');

            const html = `
            <div class="card mb-3 section-box">
                <div class="card-header bg-light d-flex align-items-center">
                    <strong>Section ${sectionIndex + 1}</strong>
                    <button type="button" class="btn btn-sm btn-danger remove-section ml-auto">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Section Heading</label>
                        <input type="text"
                            name="sections[${sectionIndex}][heading]"
                            class="form-control"
                            placeholder="Enter section heading"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Section Body</label>
                        <textarea name="sections[${sectionIndex}][body]"
                                class="form-control summernote"
                                rows="4"
                                placeholder="Enter section content"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <select type="number"
                                name="sections[${sectionIndex}][type]"
                                class="form-control"
                                value="${sectionIndex + 1}">
                                <option value="">Select Type</option>
                                <option value="pp">Privacy Policy</option>
                                <option value="tc">Terms & Conditions</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 d-flex align-items-center mt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                    class="custom-control-input"
                                    id="activeSwitch${sectionIndex}"
                                    name="sections[${sectionIndex}][is_active]"
                                    value="1"
                                    checked>
                                <label class="custom-control-label" for="activeSwitch${sectionIndex}">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            const newSection = container.lastElementChild;

            // Initialize Summernote for this specific textarea
            const textarea = $(newSection).find('.summernote');
            // In the addSection function, update the summernote initialization:
            textarea.summernote({
                height: 150,
                callbacks: {
                    onChange: function(contents) {
                        // Use $(this) to reference the current summernote instance
                        $(this).val(contents);
                    }
                },
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']], // ul = unordered list (dots)
                    ['view', ['codeview']] // Click this to see raw HTML
                ],
                // Don't strip tags
                codeviewFilter: false,
                codeviewIframeFilter: false
            });

            // Remove functionality
            newSection.querySelector('.remove-section').addEventListener('click', function() {
                this.closest('.section-box').remove();
            });

            sectionIndex++;
        }

        // Initialize first section
        addSection();

        // Replace the existing submit handler with this
        $('form').on('submit', function() {
            $('.summernote').each(function() {
                const $el = $(this);
                // Get code and destroy editor to ensure value is in textarea
                const code = $el.summernote('code');
                $el.summernote('destroy');
                $el.val(code);
            });
        });
    </script>
@endsection
