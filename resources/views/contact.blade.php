@extends('layouts.user')
@section('page-title', 'Contact Us')

@section('main-content')

    <!-- ================= HERO SECTION ================= -->
    <section class="relative h-[50vh]">
        <img src="https://images.unsplash.com/photo-1492724441997-5dc865305da7"
            class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/40"></div>

        <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
            <div class="text-white max-w-2xl">
                <h1 class="text-5xl font-extrabold">
                    Contact <span class="text-teal-400">Us</span>
                </h1>
                <p class="mt-4 text-gray-200 text-lg">
                    We’d love to hear from you. Get in touch anytime.
                </p>
            </div>
        </div>
    </section>

    <!-- ================= CONTACT INFO ================= -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-center">

            <div class="p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-teal-600">Address</h3>
                <p class="text-gray-600">
                    Your Institute Name<br>
                    City, Country
                </p>
            </div>

            <div class="p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-teal-600">Email</h3>
                <p class="text-gray-600">
                    support@yourlms.com<br>
                    info@yourlms.com
                </p>
            </div>

            <div class="p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-semibold mb-2 text-teal-600">Phone</h3>
                <p class="text-gray-600">
                    +92 300 1234567<br>
                    +92 311 7654321
                </p>
            </div>

        </div>
    </section>

    <!-- ================= CONTACT FORM ================= -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold mb-6 text-center">Send Us a Message</h2>

                <form method="POST" action="{{ route('contact.submit') }}" class="grid md:grid-cols-2 gap-6">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2
                               focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Your name" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2
                               focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Your email" required>
                    </div>

                    <!-- Subject -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Subject</label>
                        <input type="text" name="subject"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2
                               focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Subject" required>
                    </div>

                    <!-- Message -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" rows="5"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2
                               focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Write your message..." required></textarea>
                    </div>

                    <!-- Button -->
                    <div class="md:col-span-2 text-center">
                        <button type="submit"
                            class="bg-teal-500 hover:bg-teal-600 text-white px-10 py-3
                               rounded-lg font-semibold transition">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ================= MAP ================= -->
    {{-- <section class="h-[400px] w-full">
    <iframe
        src="https://www.google.com/maps?q=Islamabad,Pakistan&output=embed"
        class="w-full h-full border-0"
        loading="lazy">
    </iframe>
    </section> --}}

@endsection
