<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>FixMate</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">FixMate</h1>
        <p class="text-gray-600 mb-8 text-center max-w-xl">
            Find trusted handymen near you and book them in a few clicks.
        </p>

        <div class="space-x-3">
            <a href="{{ route('handymen.index') }}"
               class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Find a handyman
            </a>

            @auth
                <a href="{{ route('bookings.index') }}"
                   class="inline-flex items-center px-6 py-3 text-sm font-semibold text-indigo-700 bg-white border border-indigo-600 rounded-md hover:bg-indigo-50">
                    My bookings
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center px-6 py-3 text-sm font-semibold text-gray-700 bg-white border rounded-md hover:bg-gray-50">
                    Log in
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
