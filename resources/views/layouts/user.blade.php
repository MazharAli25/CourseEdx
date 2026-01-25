<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page-title') | {{ $systemSetting->webTitle ? $systemSetting->webTitle : 'website' }} </title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicon -->
    @if (isset($systemSetting->favicon))
        <link rel="shortcut icon" href="{{ asset($systemSetting->favicon) }}" type="image/png">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="bg-slate-50 text-gray-800">
    <!-- ================= NAVBAR ================= -->
    <!-- ================= TOP ICON BAR ================= -->
    <x-top-icon-bar />

    <!-- ================= MAIN NAVBAR ================= -->
    <x-main-nav-bar />
    @yield('main-content')

    <!-- ================= FOOTER ================= -->
    <x-footer />

    <!-- ================= SWIPER JS ================= -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
    </script>
</body>

</html>
