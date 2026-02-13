<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto flex items-center gap-6 px-4 py-4">
        <!-- Logo -->
        @if ($systemSetting && $systemSetting->logo)
            <a href="{{ route('home') }}"><img src="{{ asset($systemSetting->logo) }}" alt="Logo" class="h-10 w-auto" /></a>
        @else
            <div class="flex items-center text-2xl font-bold">
                <span class="text-blue-900">Course</span>
                <span class="text-pink-600 text-sm ml-1">edx</span>
            </div>
        @endif
        <!-- Search -->
        <div class="flex-1 relative">
            <input type="text" placeholder="Search Courses"
                class="w-full border rounded-full px-5 py-2 pl-12 focus:outline-none" />
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>

        <!-- Right Links -->
        <div class="flex items-center gap-6 text-sm font-medium">
            <div class="flex items-center gap-1 cursor-pointer">
                <a href="{{ route('about') }}" class="hover:text-teal-600">About Us</a>
            </div>
            <div class="flex items-center gap-1 cursor-pointer">
                <a href="{{ route('contact') }}" class="hover:text-teal-600">Contact Us</a>
            </div>
            <div class="flex items-center gap-1 cursor-pointer">
                Categories
                <i class="fa-solid fa-caret-down text-xs"></i>
            </div>
            @auth()
                @if (auth()->user()->role === 'super-admin')
                    <!-- Admin Navbar -->
                    <span class="font-semibold">Super Admin</span>
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <!-- Trigger -->
                        <button id="profileBtn" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('images/default-avater.jfif') }}"
                                class="w-9 h-9 rounded-full object-cover" />
                            <i class="fa-solid fa-chevron-down text-xs text-gray-600"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg overflow-hidden z-50">
                            <a href="{{ route('super.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>

                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-gear mr-2"></i> Settings
                            </a>
                            <hr />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'student')
                    <span>Teach on CourseEdx</span>

                    <div class="relative cursor-pointer">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full px-1">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <!-- Trigger -->
                        <button id="profileBtn" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('images/default-avater.jfif') }}"
                                class="w-9 h-9 rounded-full object-cover" />
                            <i class="fa-solid fa-chevron-down text-xs text-gray-600"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg overflow-hidden z-50">
                            <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ route('student.profile.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-gear mr-2"></i> Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-book mr-2"></i> My Courses
                            </a>
                            <hr />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'teacher')
                    <span>Learn on CourseEdx</span>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <!-- Trigger -->
                        <button id="profileBtn" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('images/default-avater.jfif') }}"
                                class="w-9 h-9 rounded-full object-cover" />
                            <i class="fa-solid fa-chevron-down text-xs text-gray-600"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg overflow-hidden z-50">
                            <a href="{{ route('teacher.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ route('teacher.profile.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa-solid fa-gear mr-2"></i> Settings
                            </a>
                            <hr />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest -->
                <a href="{{ route('login') }}"
                    class="hover:bg-teal-600 hover:text-white border-2 border-teal-600 text-teal-600 px-4 py-1.5 rounded-full">Login</a>
                <a href="{{ route('register') }}" class="bg-teal-600 text-white px-4 py-2 rounded-full">Sign
                    Up</a>
            @endauth
        </div>
    </div>
