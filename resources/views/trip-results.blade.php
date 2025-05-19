<div class="bg-white p-6 rounded-lg shadow space-y-6">
  <h2 class="text-2xl font-semibold text-gray-800"> {{ __('Here are your suggestions:') }} </h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($results as $city)
      <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
        <div class="p-4">
          <h3 class="text-xl font-bold text-purple-700">{{ $city['name'] }}, {{ $city['country'] }}</h3>
          <p class="mt-2 text-gray-600">{{ $city['reason'] }}</p>
        </div>
        <div class="bg-gray-50 p-4 flex space-x-2">
          <a href="{{ $city['travelUrl'] }}"
             class="flex-1 text-center bg-purple-600 text-white py-1 rounded-lg">
            {{ __('Travel to') }}
          </a>
          <a href="{{ $city['stayUrl'] }}"
             class="flex-1 text-center bg-green-500 text-white py-1 rounded-lg">
            {{ __('Book Stay') }}
          </a>
        </div>
      </div>
    @endforeach
  </div>
</div>
