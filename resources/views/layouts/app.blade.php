<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts and CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow p-4 flex items-center justify-between">
            <!-- Left side: Dashboard, Map, Recommendations, Blog -->
            <div class="flex space-x-6">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                <a href="{{ route('map') }}" class="text-gray-700 hover:text-gray-900">Map</a>
                <a href="{{ route('recommendations') }}" class="text-gray-700 hover:text-gray-900">Recommendations</a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-gray-900">Blog</a>
            </div>

            <!-- Right side: Profile dropdown -->
            <div class="flex items-center">
                @auth
                    <div class="relative">
                        <button id="profile-button" class="flex items-center focus:outline-none">
                            <div class="flex items-center space-x-2">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="h-10 w-10 rounded-full">
                                @endif
                                <span class="font-medium">
                                    {{ Auth::user()->nickname ?? Auth::user()->email }}
                                </span>
                            </div>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                @if(Auth::user()->isProfileComplete())
                                    Edit Profile
                                @else
                                    Complete Profile
                                @endif
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                @endauth
            </div>
        </nav>

        <!-- Optional Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Language Switcher -->
        <form action="{{ route('language.change') }}" method="POST" class="p-4">
            @csrf
            <select name="locale" onchange="this.form.submit()">
                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                <option value="lt" {{ app()->getLocale() === 'lt' ? 'selected' : '' }}>Lietuvių</option>
            </select>
        </form>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    @livewireScripts

    <!-- Profile Dropdown Toggle Script -->
    <script>
        document.getElementById('profile-button')?.addEventListener('click', function() {
            var dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        });
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
