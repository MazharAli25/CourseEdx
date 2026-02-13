@extends('layouts.user')
@section('page-title', 'About Us')

@section('main-content')

<!-- ================= HERO SECTION ================= -->
<section class="relative h-[60vh]">
    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644"
         class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/40"></div>

    <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
        <div class="text-white max-w-2xl">
            <h1 class="text-5xl font-extrabold leading-tight">
                About <span class="text-teal-400">Our LMS</span>
            </h1>
            <p class="mt-4 text-gray-200 text-lg">
                Empowering learners with quality education, skills, and certifications for a better future.
            </p>
        </div>
    </div>
</section>

<!-- ================= ABOUT CONTENT ================= -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl font-bold mb-4">Who We Are</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                Our Learning Management System is built to provide high-quality education and professional
                training to students, professionals, and institutions worldwide.
            </p>
            <p class="text-gray-600 leading-relaxed">
                We focus on practical knowledge, expert instructors, and industry-relevant courses to help
                learners achieve their academic and career goals.
            </p>
        </div>

        <div>
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f"
                 class="rounded-lg shadow-lg" alt="About LMS">
        </div>
    </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Why Choose Us</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-teal-600">Expert Instructors</h3>
                <p class="text-gray-600">
                    Learn from experienced professionals and certified educators.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-teal-600">Flexible Learning</h3>
                <p class="text-gray-600">
                    Study anytime, anywhere with lifetime access to courses.
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-3 text-teal-600">Certified Courses</h3>
                <p class="text-gray-600">
                    Earn recognized certificates to boost your career.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= STATS SECTION ================= -->
<section class="py-16 bg-teal-600 text-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8 text-center">
        <div>
            <h3 class="text-4xl font-bold">4500+</h3>
            <p class="mt-2">Courses</p>
        </div>
        <div>
            <h3 class="text-4xl font-bold">120+</h3>
            <p class="mt-2">Expert Tutors</p>
        </div>
        <div>
            <h3 class="text-4xl font-bold">50K+</h3>
            <p class="mt-2">Students</p>
        </div>
        <div>
            <h3 class="text-4xl font-bold">98%</h3>
            <p class="mt-2">Satisfaction</p>
        </div>
    </div>
</section>

<!-- ================= OUR MISSION ================= -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
        <p class="text-gray-600 leading-relaxed text-lg">
            To make quality education accessible, affordable, and effective for everyone by combining
            technology, innovation, and expert knowledge.
        </p>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-6 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Start Learning Today</h2>
        <p class="text-gray-300 mb-6">
            Join thousands of learners and upgrade your skills with us.
        </p>
        <a href=""
           class="inline-block bg-teal-500 hover:bg-teal-600 px-8 py-3 rounded-lg font-semibold transition">
            Explore Courses
        </a>
    </div>
</section>

@endsection
