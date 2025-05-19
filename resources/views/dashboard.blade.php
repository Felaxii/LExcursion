@extends('layouts.app')

@section('content')
<section id="hero"
         class="relative flex items-center justify-center h-screen bg-center bg-cover"
         style="background-image: url('{{ asset('images/flight.png') }}');">
  <div class="absolute inset-0 bg-black bg-opacity-60"></div>
  <div class="relative z-10 text-center px-6">
    <img src="{{ asset('images/mainicon.png') }}"
         alt="{{ __('LExcursion') }} Logo"
         class="mx-auto w-32 h-32 mb-4"/>
    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">
      {{ __('Welcome Aboard!') }}
    </h1>
    <p class="text-lg md:text-2xl text-gray-200 mb-8">
      {{ __('Plan your next European adventure instantly with LExcursion — the spontaneous trip generator from Vilnius powered by real-time data.') }}
    </p>
    <button id="learn-more-btn"
            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition">
      {{ __('Learn More') }}
    </button>
  </div>
</section>

<section id="about" class="hidden-section scroll-mt-20 bg-gray-50 py-20">
  <div class="w-full text-center px-8 md:px-16">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('About LExcursion') }}</h2>
    <p class="text-gray-600 text-lg">
      {{ __('LExcursion is a college capstone project born from my passion for traveling across Europe. It instantly generates spontaneous trips from Vilnius, finds the best accommodations and flights—all in one place. Inspired by my own adventures and leading travel sites, LExcursion makes planning easy, fun, and reliable.') }}
    </p>
  </div>
</section>

<section id="features" class="hidden-section py-20 relative overflow-hidden">
  <div class="hidden xl:block absolute inset-y-0 left-0 w-20 bg-gray-100"></div>
  <div class="hidden xl:block absolute inset-y-0 right-0 w-20 bg-gray-100"></div>
  <div class="max-w-5xl mx-auto space-y-20 px-4">
    <div class="feature-item md:flex md:items-center md:space-x-8">
      <div class="md:w-1/2">
        <img src="{{ asset('images/Generator.png') }}"
             alt="{{ __('Trip Generator') }}"
             class="rounded-lg shadow-lg">
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0 text-center md:text-left">
        <h3 class="text-3xl font-semibold text-gray-800 mb-2">{{ __('Trip Generator') }}</h3>
        <p class="text-gray-600 mb-4">
          {{ __('Use AI to instantly generate a custom list of European destinations just for you—filter by budget, scenery, activities and more.') }}
        </p>
        <a href="{{ route('trip-generator.show') }}"
           class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition">
          {{ __('Get Started') }}
        </a>
      </div>
    </div>

    <div class="feature-item md:flex md:items-center md:space-x-8 md:flex-row-reverse">
      <div class="md:w-1/2">
        <img src="{{ asset('images/Map.png') }}"
             alt="{{ __('Interactive Map') }}"
             class="rounded-lg shadow-lg">
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0 text-center md:text-left">
        <h3 class="text-3xl font-semibold text-gray-800 mb-2">{{ __('Interactive Map') }}</h3>
        <p class="text-gray-600 mb-4">
          {{ __('Select any of our pre-selected European cities, read a quick summary, then choose “Travel to” for flights or “Book a place to stay” for accommodation options.') }}
        </p>
        <a href="{{ route('map') }}"
           class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition">
          {{ __('Go to Map') }}
        </a>
      </div>
    </div>

    <div class="feature-item md:flex md:items-center md:space-x-8">
      <div class="md:w-1/2">
        <img src="{{ asset('images/Recommendations.png') }}"
             alt="{{ __('Trip Recommendations') }}"
             class="rounded-lg shadow-lg">
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0 text-center md:text-left">
        <h3 class="text-3xl font-semibold text-gray-800 mb-2">{{ __('Trip Recommendations') }}</h3>
        <p class="text-gray-600 mb-4">
          {{ __('Discover hand-picked destinations in “Leisure” for relaxation and “Exploration” for adventure—each with personal tips.') }}
        </p>
        <a href="{{ route('recommendations') }}"
           class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition">
          {{ __('See Recommendations') }}
        </a>
      </div>
    </div>

    <div class="feature-item md:flex md:items-center md:space-x-8 md:flex-row-reverse">
      <div class="md:w-1/2">
        <img src="{{ asset('images/Blog.png') }}"
             alt="{{ __('Travel Blog') }}"
             class="rounded-lg shadow-lg">
      </div>
      <div class="md:w-1/2 mt-6 md:mt-0 text-center md:text-left">
        <h3 class="text-3xl font-semibold text-gray-800 mb-2">{{ __('Travel Blog') }}</h3>
        <p class="text-gray-600 mb-4">
          {{ __('Read and share real travel stories, tips, and photos from fellow explorers—keep the adventure going beyond the map!') }}
        </p>
        <a href="{{ route('blog.index') }}"
           class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-5 rounded-lg transition">
          {{ __('Visit Blog') }}
        </a>
      </div>
    </div>
  </div>
</section>

<style>
  .hidden-section { display: none; }
  .hidden-section.reveal { display: block; animation: fadeDown 600ms ease both; }
  @keyframes fadeDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .feature-item {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 600ms ease, transform 600ms ease;
  }
  .feature-item.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<script>
  document.getElementById('learn-more-btn').addEventListener('click', () => {
    ['about','features'].forEach(id =>
      document.getElementById(id).classList.add('reveal')
    );
    setTimeout(() =>
      document.getElementById('about').scrollIntoView({ behavior: 'smooth' }), 100
    );
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      entry.target.classList.toggle('visible', entry.intersectionRatio > 0.2);
    });
  }, { threshold: [0, 0.2, 1] });

  document.querySelectorAll('.feature-item').forEach(el => observer.observe(el));
</script>
@endsection
