<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CourseEdx</title>
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

        <h2 class="text-2xl font-semibold text-green-800 mb-6">Login</h2>

        <!-- Student Form -->
        <div id="studentForm" class="form">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4 text-left">
                    <label class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <button type="submit"
                    class="w-full py-2 bg-green-700 text-white font-semibold rounded-md hover:bg-green-800 transition">Login</button>
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="text-green-700 font-semibold hover:underline">
                            Register here
                        </a>
                    </p>
                </div>

            </form>
        </div>

    </div>

</body>

</html>
