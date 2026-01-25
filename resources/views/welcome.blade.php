@extends('layouts.user')


@section('main-content')
    <!-- ================= HERO CAROUSEL ================= -->
    <section>
        <div class="swiper heroSwiper h-[75vh]">
            @isset ($slider)
                @if (empty($slider))
                    <div class="swiper-wrapper">

                        <!-- Slide 1 -->
                        <div class="swiper-slide relative">
                            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                            <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                                <div class="text-white max-w-xl">
                                    <h1 class="text-5xl font-extrabold leading-tight">
                                        Better Learning<br>
                                        <span class="text-teal-400">Future Starts</span> Here
                                    </h1>
                                    <p class="mt-4 text-gray-200">
                                        Learn from top instructors with industry-ready courses.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide relative">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                            <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                                <div class="text-white max-w-xl">
                                    <h1 class="text-5xl font-extrabold">
                                        4500+ Online<br>
                                        <span class="text-teal-400">Professional Courses</span>
                                    </h1>
                                    <p class="mt-4 text-gray-200">
                                        Upskill yourself anytime, anywhere.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide relative">
                            <img src="https://images.unsplash.com/photo-1507537297725-24a1c029d3ca"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                            <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                                <div class="text-white max-w-xl">
                                    <h1 class="text-5xl font-extrabold">
                                        Build Your<br>
                                        <span class="text-teal-400">Dream Career</span>
                                    </h1>
                                    <p class="mt-4 text-gray-200">
                                        Certification & job-ready skills.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="swiper-wrapper">
                        <div class="swiper-slide relative">
                            <img src="{{ asset('carousel_images/' . $slider->image1) }}"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>
                        </div>

                        <div class="swiper-slide relative">
                            <img src="{{ asset('carousel_images/' . $slider->image2) }}"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>
                        </div>

                        <div class="swiper-slide relative">
                            <img src="{{ asset('carousel_images/' . $slider->image3) }}"
                                class="absolute inset-0 w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>
                        </div>
                    </div>
                @endif
            @else
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                        <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                            <div class="text-white max-w-xl">
                                <h1 class="text-5xl font-extrabold leading-tight">
                                    Better Learning<br>
                                    <span class="text-teal-400">Future Starts</span> Here
                                </h1>
                                <p class="mt-4 text-gray-200">
                                    Learn from top instructors with industry-ready courses.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                        <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                            <div class="text-white max-w-xl">
                                <h1 class="text-5xl font-extrabold">
                                    4500+ Online<br>
                                    <span class="text-teal-400">Professional Courses</span>
                                </h1>
                                <p class="mt-4 text-gray-200">
                                    Upskill yourself anytime, anywhere.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1507537297725-24a1c029d3ca"
                            class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>

                        <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
                            <div class="text-white max-w-xl">
                                <h1 class="text-5xl font-extrabold">
                                    Build Your<br>
                                    <span class="text-teal-400">Dream Career</span>
                                </h1>
                                <p class="mt-4 text-gray-200">
                                    Certification & job-ready skills.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            @endisset

            <div class="swiper-pagination"></div>
            <div class="swiper-button-next text-white"></div>
            <div class="swiper-button-prev text-white"></div>
        </div>
    </section>

@endsection
