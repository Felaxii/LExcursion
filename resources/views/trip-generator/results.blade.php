@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-6">
  <h1 class="text-3xl font-extrabold text-purple-700 text-center">
    {{ __('trip_generator.results.title') }}
  </h1>

  @if(session('error'))
    <p class="text-center text-red-600">{{ session('error') }}</p>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($cities as $city)
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">
          {{ $city['name'] }}, {{ $city['country'] }}
        </h2>
        <p class="text-gray-700 mb-2">{{ $city['description'] }}</p>
        <p class="italic text-gray-500 mb-4">{{ $city['reason'] }}</p>
        <div class="mt-auto flex space-x-2">
          <a href="{{ route('accommodations', ['city' => $city['name']]) }}"
             class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg text-center">
            {{ __('trip_generator.actions.book_stay') }}
          </a>
          <a href="{{ route('travel-options', [
                  'city'=> $city['name'],
                  'travelers'=>1,
                  'date'=> now()->toDateString()
                ]) }}"
             class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center">
            {{ __('trip_generator.actions.travel_to') }}
          </a>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-8 text-center">
    <a href="{{ route('trip-generator.show') }}"
       class="inline-block text-purple-600 hover:underline">
      &larr; {{ __('trip_generator.results.back') }}
    </a>
  </div>
</div>
@endsection
