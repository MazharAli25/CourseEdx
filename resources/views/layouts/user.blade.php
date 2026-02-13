<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page-title') | {{ isset($systemSetting->webTitle) ? $systemSetting->webTitle : 'website' }} </title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=line-clamp"></script>
    <!-- Favicon -->
    @if (isset($systemSetting->favicon))
        <link rel="shortcut icon" href="{{ asset($systemSetting->favicon) }}" type="image/png">
    @endif
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    {{-- css --}}
    @yield('css')
</head>

<body class="bg-slate-50 text-gray-800">

    <!-- ================= NAVBAR ================= -->
    <!-- ================= TOP ICON BAR ================= -->
    <x-top-icon-bar />

    <!-- ================= MAIN NAVBAR ================= -->
    <x-main-nav-bar />

    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 3rem; right: 1rem; z-index: 1080;">

        {{-- Success --}}
        @if (session('success'))
            <div class="toast bg-success text-white mb-2" role="alert" data-delay="4000">
                <div class="toast-body">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Error --}}
        @if (session('error'))
            <div class="toast bg-danger text-white mb-2" role="alert" data-delay="4000">
                <div class="toast-body">
                    <i class="fas fa-times-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="toast bg-warning text-dark mb-2" role="alert" data-delay="5000">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            </div>
        @endif
    </div>
    @yield('main-content')

    <!-- ================= FOOTER ================= -->
    <x-footer />

    <!-- ================= SWIPER JS ================= -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Alpine.js with Collapse Plugin -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        new Swiper(".heroSwiper", {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        const profileBtn = document.getElementById("profileBtn");
        const dropdown = document.getElementById("profileDropdown");

        profileBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", () => {
            dropdown.classList.add("hidden");
        });
        $(document).ready(function() {
            // Toasts
            $('.toast').toast('show');
        });
    </script>
    @yield('js')
</body>

</html>
