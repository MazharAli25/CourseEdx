<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (required for toast) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="bg-light">

    {{-- Toast --}}
    @if (session('message'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 text-center">

                        <h4 class="mb-3">Verify Your Email Address</h4>

                        <p class="text-muted">
                            Thanks for signing up! Before continuing, please verify your
                            email address by clicking the link we sent to your email.
                        </p>

                        <hr>

                        <p class="mb-3">
                            Didn’t receive the email?
                        </p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                Resend Verification Email
                            </button>
                        </form>

                        <div class="mt-3">
                            <small class="text-muted">
                                Please check your spam folder as well.
                            </small>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Auto show toast --}}
    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastEl = document.getElementById('successToast');
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 4000
                });
                toast.show();
            });
        </script>
    @endif

</body>
</html>
