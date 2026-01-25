    @extends('adminlte::page')

    @section('title', 'Website Settings')

    @section('content_header')
        <h1>Website Settings</h1>
    @endsection

    @section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('super.homeCustomizationUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Website Title --}}
                <div class="form-group">
                    <label for="site_title">Website Title</label>
                    <input type="text"
                        name="webTitle"
                        class="form-control"
                        value="{{ old('webTitle', $systemSetting->webTitle ?? '') }}"
                        placeholder="Enter website title">
                </div>

                <div class="row">
                    {{-- Logo --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Website Logo</label>
                            <input type="file"
                                name="logo"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(this, 'logoPreview')">

                            <div class="mt-2">
                                <img id="logoPreview"
                                     src="{{ isset($systemSetting->logo) ? asset($systemSetting->logo) : '' }}"
                                    style="max-height: 80px;">
                            </div>
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Favicon</label>
                            <input type="file"
                                name="favicon"
                                class="form-control"
                                accept="image/*"
                                onchange="previewImage(this, 'faviconPreview')">

                            <div class="mt-2">
                                <img id="faviconPreview"
                                    src="{{ isset($systemSetting->favicon) ? asset($systemSetting->favicon) : '' }}"
                                    style="max-height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById(previewId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endsection
