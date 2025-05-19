<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name','LExcursion') }}</title>

  <link rel="icon" href="{{ asset('images/mainicon.png') }}" type="image/png">
  <link rel="preconnect" href="https://fonts.bunny.net">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @livewireStyles
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">

  <nav class="bg-purple-700 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 flex items-center h-16 justify-between">
      <div class="flex items-center space-x-2">
        <img src="{{ asset('images/mainicon.png') }}" alt="Logo" class="w-8 h-8">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold">
          {{ __('LExcursion') }}
        </a>
      </div>

      <div class="hidden md:flex space-x-4">
        @php $isGen = request()->routeIs('trip-generator*') @endphp
        <a href="{{ route('trip-generator.show') }}"
           class="px-3 py-1 rounded-lg transition {{ $isGen ? 'bg-white text-purple-700 font-bold' : 'text-white hover:bg-white hover:text-purple-700' }}">
          {{ __('Trip Generator') }}
        </a>

        @php $isMap = request()->routeIs('map*') @endphp
        <a href="{{ route('map') }}"
           class="px-3 py-1 rounded-lg transition {{ $isMap ? 'bg-white text-purple-700 font-bold' : 'text-white hover:bg-white hover:text-purple-700' }}">
          {{ __('Map') }}
        </a>

        @php $isRec = request()->routeIs('recommendations*') @endphp
        <a href="{{ route('recommendations') }}"
           class="px-3 py-1 rounded-lg transition {{ $isRec ? 'bg-white text-purple-700 font-bold' : 'text-white hover:bg-white hover:text-purple-700' }}">
          {{ __('Recommendations') }}
        </a>

        @php $isBlog = request()->routeIs('blog.*') @endphp
        <a href="{{ route('blog.index') }}"
           class="px-3 py-1 rounded-lg transition {{ $isBlog ? 'bg-white text-purple-700 font-bold' : 'text-white hover:bg-white hover:text-purple-700' }}">
          {{ __('Blog') }}
        </a>
      </div>

      <div class="flex items-center space-x-4">
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
                  class="px-3 py-1 rounded-lg bg-white text-purple-700 font-medium hover:bg-purple-600 hover:text-white transition">
            {{ strtoupper(app()->getLocale()) }}
          </button>
          <div x-show="open" x-transition @click.outside="open = false"
               class="absolute right-0 mt-2 w-24 bg-white rounded-lg shadow-lg z-50 overflow-hidden">
            <form method="POST" action="{{ route('language.change') }}">
              @csrf
              <button type="submit" name="locale" value="en" class="w-full text-left px-4 py-2 text-purple-700 hover:bg-purple-50">EN</button>
            </form>
            <form method="POST" action="{{ route('language.change') }}">
              @csrf
              <button type="submit" name="locale" value="lt" class="w-full text-left px-4 py-2 text-purple-700 hover:bg-purple-50">LT</button>
            </form>
          </div>
        </div>

        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
                  class="px-3 py-1 rounded-lg bg-white text-purple-700 font-medium hover:bg-purple-600 hover:text-white transition">
            {{ session('currency','EUR') }}
          </button>
          <div x-show="open" x-transition @click.outside="open = false"
               class="absolute right-0 mt-2 w-28 bg-white rounded-lg shadow-lg z-50 overflow-hidden">
            @foreach(['USD','EUR','GBP','JPY','AUD','CAD','CHF','CNY'] as $code)
              <form method="POST" action="{{ route('currency.change') }}">
                @csrf
                <button type="submit" name="currency" value="{{ $code }}" class="w-full text-left px-4 py-2 text-purple-700 hover:bg-purple-50">{{ $code }}</button>
              </form>
            @endforeach
          </div>
        </div>

        @auth
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2">
              <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                   onerror="this.src='{{ asset('images/default-profile.png') }}'"
                   class="w-8 h-8 rounded-full object-cover">
              <span class="text-white">{{ Auth::user()->nickname ?? Auth::user()->email }}</span>
            </button>
            <div x-show="open" x-transition @click.outside="open = false"
                 class="absolute right-0 mt-2 bg-white text-gray-800 rounded-lg shadow-lg z-50">
              <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                {{ Auth::user()->isProfileComplete() ? __('Edit Profile') : __('Complete Profile') }}
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">{{ __('Logout') }}</button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="px-3 py-1 rounded-lg text-white hover:bg-white hover:text-purple-700 transition">{{ __('Login') }}</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="flex-1">
    @yield('content')
  </main>

  <footer class="bg-purple-800 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center">
      <p>© {{ date('Y') }} {{ __('LExcursion') }}</p>
      <div class="space-x-4 mt-2 md:mt-0">
        <a href="{{ route('static.about') }}" class="hover:underline">{{ __('static.about.title') }}</a>
        <a href="{{ route('static.terms') }}" class="hover:underline">{{ __('static.terms.title') }}</a>
        <a href="{{ route('static.privacy') }}" class="hover:underline">{{ __('static.privacy.title') }}</a>
        <a href="{{ route('static.contact') }}" class="hover:underline">{{ __('static.contact.title') }}</a>
      </div>
    </div>
  </footer>

  @livewireScripts
  <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
