@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h2 class="text-3xl font-extrabold text-purple-700 mb-6 text-center">
    {{ __('travel_options.title', ['city' => $city]) }}
  </h2>

  <form method="GET" action="{{ route('travel-options') }}" class="bg-white p-4 rounded-xl shadow mb-8">
    <input type="hidden" name="city" value="{{ $city }}">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-center">
      @php
        $guess = 'images/' . \Illuminate\Support\Str::lower($city) . '.jpg';
        $imgPath = file_exists(public_path($guess)) ? $guess : 'images/default.jpg';
      @endphp
      <div class="flex items-center justify-center md:justify-start space-x-3">
        <img src="{{ asset($imgPath) }}"
             alt="{{ $city }}"
             class="h-10 w-10 object-cover rounded opacity-50">
        <span class="font-semibold text-gray-800">{{ $city }}</span>
      </div>
      <div>
        <label for="travelers" class="block text-sm font-medium text-gray-700">
          {{ __('travel_options.travelers') }}
        </label>
        <select name="travelers" id="travelers"
                class="mt-1 w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
          @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" {{ $passengers == $i ? 'selected' : '' }}>
              {{ $i }}
            </option>
          @endfor
        </select>
      </div>
      <div>
        <label for="date" class="block text-sm font-medium text-gray-700">
          {{ __('travel_options.departure_date') }}
        </label>
        <input type="date" name="date" id="date"
               value="{{ $departureDate }}"
               min="{{ now()->toDateString() }}"
               class="mt-1 w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
      </div>
      <div>
        <label class="flex items-center text-sm font-medium text-gray-700">
          <input type="checkbox" name="return" id="return"
                 class="h-4 w-4 text-purple-600 border-gray-300 rounded"
                 {{ $returnFlag ? 'checked' : '' }}>
          <span class="ml-2">{{ __('travel_options.return_flight') }}</span>
        </label>
        <input type="date" name="returnDate" id="returnDate"
               value="{{ $returnDate }}"
               min="{{ $departureDate }}"
               class="mt-1 w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 {{ $returnFlag ? '' : 'opacity-50' }}"
               {{ $returnFlag ? '' : 'disabled' }}>
      </div>
      <div class="md:col-span-1 flex justify-center md:justify-end">
        <button type="submit"
                class="inline-block bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-semibold py-2 px-6 rounded-lg transition">
          {{ __('travel_options.apply') }}
        </button>
      </div>
    </div>
  </form>

  @php
    $offers = data_get($flightData, 'data', []);
  @endphp

  @if($offers && count($offers))
    <div class="grid grid-cols-1 gap-6">
      @foreach($offers as $offer)
        @php
          $price = data_get($offer, 'price.grandTotal', 'N/A');
          $cur   = data_get($offer, 'price.currency', session('currency','EUR'));
          $itins = data_get($offer, 'itineraries', []);
        @endphp

        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
          <h3 class="text-2xl font-bold text-purple-700 mb-3">
            {{ __('travel_options.option') }}
          </h3>

          <p class="text-gray-800 mb-2">
            <span class="font-medium">{{ __('travel_options.price') }}:</span>
            <span class="text-lg">{{ $cur }} {{ $price }}</span>
          </p>

          <p class="text-gray-500 mb-4">
            {{ $returnFlag && $returnDate
               ? __('travel_options.round_trip')
               : __('travel_options.one_way') }}
          </p>

          @foreach($itins as $itin)
            <p class="text-gray-700 mb-1">
              <span class="font-medium">{{ __('travel_options.itinerary_duration') }}:</span>
              {{ data_get($itin, 'duration', 'N/A') }}
            </p>
            @foreach(data_get($itin, 'segments', []) as $i => $seg)
              <div class="ml-4 mb-3 p-4 bg-gray-50 rounded-lg">
                <p class="font-semibold mb-1">{{ __('travel_options.segment', ['num' => $i+1]) }}</p>
                <p class="text-gray-700">
                  {{ __('travel_options.depart') }}: {{ data_get($seg, 'departure.iataCode') }} — {{ data_get($seg, 'departure.at') }}
                </p>
                <p class="text-gray-700">
                  {{ __('travel_options.arrive') }}: {{ data_get($seg, 'arrival.iataCode') }} — {{ data_get($seg, 'arrival.at') }}
                </p>
                <p class="text-gray-700">
                  {{ __('travel_options.duration') }}: {{ data_get($seg, 'duration') }}
                </p>
                <p class="text-gray-700">
                  {{ __('travel_options.flight') }}: {{ data_get($seg, 'carrierCode') }} {{ data_get($seg, 'number') }}
                </p>
              </div>
            @endforeach
            <hr class="my-2">
          @endforeach

          <div class="flex space-x-4 mt-6">
            <button onclick="purchaseTicket('{{ __('travel_options.option') }}','{{ $price }}','{{ $cur }}')"
                    class="flex-1 bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-semibold py-2 rounded-lg transition">
              {{ __('travel_options.purchase_ticket') }}
            </button>
            <a href="{{ route('accommodations', ['city' => $city, 'travelers' => $passengers]) }}"
               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 rounded-lg text-center transition">
              {{ __('travel_options.book_stay') }}
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-center text-gray-500">{{ __('travel_options.no_data') }}</p>
  @endif
</div>

<script>
  document.getElementById('return').addEventListener('change', function(){
    const rd = document.getElementById('returnDate');
    if(this.checked){
      rd.disabled = false;
      rd.classList.remove('opacity-50');
    } else {
      rd.disabled = true;
      rd.classList.add('opacity-50');
      rd.value = '';
    }
  });

  function purchaseTicket(type, price, currency) {
    alert(`${type}: ${currency} ${price}. {{ __('travel_options.demo_alert') }}`);
  }
</script>
@endsection
