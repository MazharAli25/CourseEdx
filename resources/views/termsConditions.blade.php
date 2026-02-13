@extends('layouts.user')
@section('page-title', 'Terms & Conditions')

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
                    Terms & <span class="text-teal-400">Conditions</span>
                </h1>
                <p class="mt-4 text-gray-200 text-lg">
                    Please read these Terms & Conditions carefully before using CourseEdx.
                </p>
            </div>
        </div>
    </section>

    <!-- ================= CONTENT ================= -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-6">

            <div class="bg-slate-50 rounded-lg shadow-lg p-8 space-y-10">

                <p class="text-gray-600 text-sm">
                    Last updated: {{ $latestUpdate ? $latestUpdate->updated_at->format('M d, Y') : '' }}
                </p>

                <!-- Section -->
                @php
                    $i=1;
                @endphp
                @foreach ($tcs as $i => $tc)
                    <div>
                        
                        <h2 class="text-2xl font-bold text-teal-600 mb-3">
                            {{ $i+1 }}. {{ $tc->heading }}
                        </h2>
                        <p class="text-gray-700 leading-relaxed " style="margin-left: 2rem">
                            {!! $tc->body !!}
                        </p>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
        </div>
    </section>

@endsection
