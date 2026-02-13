@extends('adminlte::page')
@section('title', 'Profile Settings')

@section('content_header')
    <h1>Profile Settings</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- Profile Image Card --}}
            <div class="card card-primary card-outline">
                <div class="card-body box-profile text-center">

                    <img id="profilePreview" class="profile-user-img img-fluid img-circle mb-2"
                        src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('images/default-avater.jfif') }}"
                        alt="Profile Picture" style="cursor:pointer">
                    <h3 class="profile-username text-center mt-2">
                        {{ auth()->user()->name }}
                    </h3>
                    <p class="text-muted"> {{ auth()->user()->email }} </p>
                    <p class="text-muted mb-0">Click image to change</p>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Profile Form --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>

                <form action="{{ route('teacher.profile.update', auth()->user()) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- Hidden file input (MUST be inside form) --}}
                        <input type="file" name="profileImage" id="profileImageInput" class="d-none" accept="image/*">

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <hr>

                        <p class="text-muted">
                            Leave password fields empty if you don’t want to change it.
                        </p>

                        {{-- Password --}}
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Click image → open file picker
        document.getElementById('profilePreview').addEventListener('click', function() {
            document.getElementById('profileImageInput').click();
        });

        // Preview selected image
        document.getElementById('profileImageInput').addEventListener('change', function(e) {
            if (!e.target.files.length) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profilePreview').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endsection
