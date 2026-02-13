<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CoureEdx</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-600 text-white px-4 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-600 text-white px-4 py-3 rounded shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed top-4 right-4 bg-yellow-500 text-black px-4 py-3 rounded shadow-lg">
            {{ $errors->first() }}
        </div>
    @endif


    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8 text-center">

        <!-- Logo -->
        {{-- <img src="https://upload.wikimedia.org/wikipedia/en/1/19/PTA_Logo.png" alt="PT&EC Logo" class="mx-auto w-24 mb-6"> --}}

        <h2 class="text-2xl font-semibold text-green-800 mb-6">Register</h2>

        <!-- Role Selection -->
        <div class="flex mb-6">
            <button id="studentBtn"
                class="flex-1 py-2 rounded-l-md bg-green-700 text-white font-semibold focus:outline-none"
                onclick="showStudent()">Student</button>
            <button id="teacherBtn"
                class="flex-1 py-2 rounded-r-md bg-gray-200 text-gray-700 font-semibold focus:outline-none"
                onclick="showTeacher()">Teacher</button>
        </div>

        <!-- Student Form -->
        <div id="studentForm" class="form">
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <input type="hidden" name="role" value="student">

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="flex items-center mt-4 text-left mb-4">
                    <input type="checkbox" name="acceptPrivacy" required class="form-checkbox text-green-700">
                    <label class="ml-2 text-gray-700 text-sm">
                        I agree to the 
                        <a href="{{ route('privacyPolicy') }}" class="underline text-green-700">
                            Terms & Conditions</a> and
                        <a href="{{ route('termsConditions') }}" class="underline text-green-700">Privacy
                            Privacy Policy</a>.
                        
                    </label>
                </div>
                <button type="submit"
                    class="w-full py-2 bg-green-700 text-white font-semibold rounded-md hover:bg-green-800 transition">Register
                    as Student</button>
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">
                            Login here
                        </a>
                    </p>
                </div>

            </form>
        </div>

        <!-- Teacher Form -->
        <div id="teacherForm" class="form hidden">
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <input type="hidden" name="role" value="teacher">

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div class="flex items-center mt-4 text-left mb-4">
                    <input type="checkbox" name="acceptPrivacy" required class="form-checkbox text-green-700">
                    <label class="ml-2 text-gray-700 text-sm">
                        I have read and agree to the
                        <a href="{{ route('privacy-policy.index') }}" class="underline text-green-700">Privacy
                            Policy</a>.
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-2 bg-green-800 text-white font-semibold rounded-md hover:bg-green-900 transition">Register
                    as Teacher</button>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">
                            Login here
                        </a>
                    </p>
                </div>

            </form>
        </div>

    </div>

    <script>
        function showStudent() {
            document.getElementById('studentForm').classList.remove('hidden');
            document.getElementById('teacherForm').classList.add('hidden');
            document.getElementById('studentBtn').classList.add('bg-green-700', 'text-white');
            document.getElementById('studentBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('teacherBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('teacherBtn').classList.remove('bg-green-800', 'text-white');
        }

        function showTeacher() {
            document.getElementById('teacherForm').classList.remove('hidden');
            document.getElementById('studentForm').classList.add('hidden');
            document.getElementById('teacherBtn').classList.add('bg-green-800', 'text-white');
            document.getElementById('teacherBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('studentBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('studentBtn').classList.remove('bg-green-700', 'text-white');
        }
        // Disable submit buttons initially and toggle based on checkbox
        document.querySelectorAll('input[name="acceptPrivacy"]').forEach(function(checkbox) {
            const form = checkbox.closest('form');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Initially disable submit button
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Enable/disable on checkbox change
            checkbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;

                if (this.checked) {
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        function showStudent() {
            document.getElementById('studentForm').classList.remove('hidden');
            document.getElementById('teacherForm').classList.add('hidden');
            document.getElementById('studentBtn').classList.add('bg-green-700', 'text-white');
            document.getElementById('studentBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('teacherBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('teacherBtn').classList.remove('bg-green-800', 'text-white');

            // Reset checkbox state when switching tabs (optional)
            document.querySelector('#studentForm input[name="acceptPrivacy"]').checked = false;
            document.querySelector('#studentForm button[type="submit"]').disabled = true;
        }

        function showTeacher() {
            document.getElementById('teacherForm').classList.remove('hidden');
            document.getElementById('studentForm').classList.add('hidden');
            document.getElementById('teacherBtn').classList.add('bg-green-800', 'text-white');
            document.getElementById('teacherBtn').classList.remove('bg-gray-200', 'text-gray-700');
            document.getElementById('studentBtn').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('studentBtn').classList.remove('bg-green-700', 'text-white');

            // Reset checkbox state when switching tabs (optional)
            document.querySelector('#teacherForm input[name="acceptPrivacy"]').checked = false;
            document.querySelector('#teacherForm button[type="submit"]').disabled = true;
        }
    </script>

</body>

</html>
