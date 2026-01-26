@extends('adminlte::page')

@section('title', 'Create Social Link')

@section('content_header')
    <h1>Create Social Link</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Social Link</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('social-links.store') }}" method="POST">
                @csrf

                {{-- Platform --}}
                <div class="form-group">
                    <label for="platform">Platform</label>
                    <select name="platform" id="platform" class="form-control" required onchange="updateIcon()">
                        <option value="">Select Platform</option>
                        <option value="Instagram" data-icon="fab fa-instagram">Instagram</option>
                        <option value="Facebook" data-icon="fab fa-facebook">Facebook</option>
                        <option value="LinkedIn" data-icon="fab fa-linkedin">LinkedIn</option>
                        <option value="X" data-icon="fab fa-x-twitter">X (Twitter)</option>
                        <option value="GitHub" data-icon="fab fa-github">GitHub</option>
                        <option value="YouTube" data-icon="fab fa-youtube">YouTube</option>
                        <option value="WhatsApp" data-icon="fab fa-whatsapp">WhatsApp</option>
                    </select>
                </div>

                {{-- Icon Preview --}}
                <div class="form-group">
                    <label>Icon Preview</label>
                    <div>
                        <i id="iconPreview" class="fa-2x"></i>
                    </div>
                    <input type="hidden" name="icon_class" id="iconClass">
                </div>

                {{-- URL --}}
                <div class="form-group">
                    <label for="url">Profile URL</label>
                    <input type="url" name="url" class="form-control" placeholder="https://instagram.com/username"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Social Link
                </button>
            </form>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function updateIcon() {
            const select = document.getElementById('platform');
            const selectedOption = select.options[select.selectedIndex];
            const iconClass = selectedOption.getAttribute('data-icon');

            const iconPreview = document.getElementById('iconPreview');
            const iconInput = document.getElementById('iconClass');

            if (iconClass) {
                console.log("Icon class found: " + iconClass);
                iconPreview.className = iconClass + ' fa-2x';
            }else{
                console.log("No icon class found");
            }
        }
    </script>

@endsection
