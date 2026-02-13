@extends('adminlte::page')

@section('title', 'Edit Social Link')

@section('content_header')
    <h1>Edit Social Link</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Social Link</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('social-links.update', encrypt($socialLink->id)) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Platform --}}
                <div class="form-group">
                    <label for="platform">Platform</label>
                    <select name="platform" id="platform" class="form-control" required onchange="updateIcon()">
                        <option value="">Select Platform</option>
                        <option value="Instagram" data-icon="fab fa-instagram"
                            {{ $socialLink->platform == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="Facebook" data-icon="fab fa-facebook"
                            {{ $socialLink->platform == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="LinkedIn" data-icon="fab fa-linkedin"
                            {{ $socialLink->platform == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="X" data-icon="fab fa-twitter"
                            {{ $socialLink->platform == 'X' ? 'selected' : '' }}>X (Twitter)</option>
                        <option value="GitHub" data-icon="fab fa-github"
                            {{ $socialLink->platform == 'GitHub' ? 'selected' : '' }}>GitHub</option>
                        <option value="YouTube" data-icon="fab fa-youtube"
                            {{ $socialLink->platform == 'YouTube' ? 'selected' : '' }}>YouTube</option>
                        <option value="WhatsApp" data-icon="fab fa-whatsapp"
                            {{ $socialLink->platform == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
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
                    <input type="url" name="url" class="form-control" value="{{ $socialLink->url }}" placeholder="https://instagram.com/username"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Social Link
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
                iconPreview.className = iconClass + ' fa-2x';
                iconInput.value = iconClass;
            } else {
                iconPreview.className = '';
                iconInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateIcon(); // show icon for already-selected platform
        });
    </script>


@endsection
