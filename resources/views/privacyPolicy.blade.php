@extends('layouts.user')
@section('page-title', 'Privacy Policy')

@section('main-content')

    <style>
        ul{
            list-style: disc;
            margin-left: 1.5rem;
        }
        ol{
            list-style: decimal;
        }
    </style>

    <!-- ================= HERO SECTION ================= -->
    <section class="relative h-[45vh]">
        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d"
            class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-black/40"></div>

        <div class="relative max-w-7xl mx-auto h-full flex items-center px-6">
            <div class="text-white max-w-2xl">
                <h1 class="text-5xl font-extrabold">
                    Privacy <span class="text-teal-400">Policy</span>
                </h1>
                <p class="mt-4 text-gray-200 text-lg">
                    Your privacy matters to us at CourseEdx.
                </p>
            </div>
        </div>
    </section>

    <!-- ================= CONTENT ================= -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-6">

            <div class="bg-slate-50 rounded-lg shadow-lg p-8 space-y-10">

                <p class="text-gray-600 text-sm">
                    Last updated: {{ $latestUpdate->updated_at->format('M d, Y') }}
                </p>

                <!-- Section -->
                @php
                    $i=1;
                @endphp
                @foreach ($policies as $i => $policy)
                    <div>
                        
                        <h2 class="text-2xl font-bold text-teal-600 mb-3">
                            {{ $i+1 }}. {{ $policy->heading }}
                        </h2>
                        <p class="text-gray-700 leading-relaxed " style="margin-left: 2rem">
                            {!! $policy->body !!}
                        </p>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    2. How We Use Your Information
                </h2>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>To create and manage user accounts</li>
                    <li>To communicate with you via email</li>
                    <li>To respond to your inquiries</li>
                    <li>To improve our services</li>
                </ul>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    3. Contact Forms
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    When you submit a message through our contact form, we collect your
                    email address and message. This information is stored in our database
                    and used only to respond to your request.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    4. Cookies
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    CourseEdx uses essential Laravel session cookies to maintain user
                    sessions and keep you logged in. These cookies are required for the
                    website to function properly and are not used for advertising or
                    tracking.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    5. Emails
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We use Laravel Mail to send account-related and support emails. Emails are delivered using Gmail as a third-party email service provider.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    6. Third-Party Services
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    We use Gmail solely for sending emails. No analytics, advertising,
                    or payment services are used on CourseEdx.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    7. User Rights
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    You may contact us to request access to or correction of your personal data. At this time, automatic account deletion is not available.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    8. Children’s Privacy
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    CourseEdx is not intended for children under the age of 13, and we do
                    not knowingly collect personal information from children.
                </p>
            </div> --}}

                <!-- Section -->
                {{-- <div>
                <h2 class="text-2xl font-bold text-teal-600 mb-3">
                    9. Contact Us
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    If you have any questions about this Privacy Policy, please contact us at:
                </p>
                <p class="mt-2 font-semibold text-gray-800">
                    mazhar@gmail.com
                </p>
            </div> --}}

            </div>
        </div>
    </section>

@endsection
