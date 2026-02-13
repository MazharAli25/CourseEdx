<footer class="bg-slate-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-4 gap-10">
        <!-- Brand -->
        <div>
            <h3 class="text-2xl font-bold text-white">
                Course<span class="text-teal-400">Edx</span>
            </h3>
            <p class="text-sm mt-4 text-gray-400">
                Your success story begins here. Learn, grow, and build your future
                with industry-ready courses.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h4 class="font-semibold text-white mb-4">Explore</h4>
            <ul class="space-y-2 text-sm">
                <li>Courses</li>
                <li>Institutions</li>
                <li>Admissions</li>
                <li>Jobs</li>
            </ul>
        </div>

        <div>
            <h4 class="font-semibold text-white mb-4">Company</h4>
            <ul class="space-y-2 text-sm">
                <li>About Us</li>
                <li>Contact</li>
                <li>Privacy Policy</li>
                <li>Terms</li>
            </ul>
        </div>

        <!-- Social -->
        <div>
            <h4 class="font-semibold text-white mb-4">Follow Us</h4>
            <div class="flex gap-4 text-lg">
            @isset($socialLinks)
                @foreach ($socialLinks as $socialLink)
                    <a href="{{ $socialLink->url }}" target="_blank"><i class="{{ $socialLink->icon_class }}"></i></a>
                    
                @endforeach
                
            @endisset
            </div>
        </div>
    </div>

    <div class="border-t border-gray-700 text-center py-4 text-sm text-gray-400">
        © 2025 CourseEdx. All rights reserved.
    </div>
</footer>
