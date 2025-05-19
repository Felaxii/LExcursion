@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-extrabold text-purple-700 mb-6">
    {{ __('recommendations.title') }}
  </h1>

  <form action="{{ route('recommendations') }}" method="GET" class="mb-8">
    <label for="trip_type" class="block text-lg font-medium text-gray-700 mb-2">
      {{ __('recommendations.select_type') }}
    </label>
    <select id="trip_type"
            name="trip_type"
            class="w-full sm:w-1/3 border border-purple-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
            onchange="this.form.submit()">
      <option value="leisure" {{ $trip_type==='leisure'?'selected':'' }}>
        {{ __('recommendations.types.leisure') }}
      </option>
      <option value="exploration" {{ $trip_type==='exploration'?'selected':'' }}>
        {{ __('recommendations.types.exploration') }}
      </option>
    </select>
  </form>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cities as $city)
      @php
        $key = Str::slug($city['name']);
        $full = __("recommendations.cities.{$key}.description");
        $trunc = Str::limit($full, 100);
      @endphp
      <div class="bg-white border border-purple-100 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
        <img src="{{ asset($city['image']) }}"
             alt="{{ __("recommendations.cities.{$key}.name") }}"
             class="w-full h-48 object-cover rounded-t-lg">

        <div class="p-5 space-y-3">
          <h2 class="text-xl font-semibold text-gray-800">
            {{ __("recommendations.cities.{$key}.name") }},
            <span class="text-gray-500">{{ __("recommendations.cities.{$key}.county") }}</span>
          </h2>

          <p id="desc-{{ $key }}"
             data-full="{{ $full }}"
             data-truncated="{{ $trunc }}"
             data-expanded="false"
             class="text-gray-600 text-sm leading-relaxed">
            {{ $trunc }}
          </p>
          <button id="btn-{{ $key }}"
                  class="text-purple-600 font-medium text-sm hover:underline focus:outline-none"
                  onclick="toggleDescription('{{ $key }}')">
            {{ __('recommendations.read_more') }}
          </button>

          <div class="mt-4 flex space-x-3">
            <a href="{{ route('travel-options', ['city'=>$city['name'],'travelers'=>1,'date'=>now()->toDateString()]) }}"
               class="flex-1 text-center py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg text-sm font-medium hover:from-purple-700 hover:to-purple-900 transition">
              {{ __('recommendations.travel_to') }}
            </a>
            <a href="{{ route('accommodations', ['city'=>$city['name'],'travelers'=>1]) }}"
               class="flex-1 text-center py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg text-sm font-medium hover:from-purple-700 hover:to-purple-900 transition">
              {{ __('recommendations.book_stay') }}
            </a>
          </div>
        </div>
      </div>
    @empty
      <p class="col-span-3 text-center text-gray-500">
        {{ __('recommendations.none') }}
      </p>
    @endforelse
  </div>
</div>

<script>
function toggleDescription(key) {
  const desc = document.getElementById('desc-' + key);
  const btn  = document.getElementById('btn-'  + key);
  const full = desc.dataset.full;
  const trunc= desc.dataset.truncated;
  const exp  = desc.dataset.expanded === 'true';

  desc.textContent = exp ? trunc : full;
  desc.dataset.expanded = (!exp).toString();
  btn.textContent      = exp 
    ? '{{ __("recommendations.read_more") }}' 
    : '{{ __("recommendations.show_less") }}';
}
</script>
@endsection
