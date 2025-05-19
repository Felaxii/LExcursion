@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h2 class="text-3xl font-extrabold text-purple-700 mb-8 text-center">
    {{ __('accommodations.title', ['city' => $city]) }}
  </h2>

  <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <form
      method="GET"
      action="{{ route('accommodations') }}"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end"
    >
      <div class="col-span-1 lg:col-span-1">
        <label for="city" class="block font-medium text-gray-700 mb-1">
          {{ __('accommodations.fields.city') }}
        </label>
        <input
          type="text"
          id="city"
          name="city"
          list="cities"
          value="{{ old('city', $city) }}"
          placeholder="{{ __('accommodations.fields.city_placeholder') }}"
          class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        />
        <datalist id="cities">
          @foreach([
            'Riga','Tallinn','Rome','Munich','Nuremberg','Paris','Barcelona','Madrid',
            'Oslo','Stockholm','Copenhagen','Bucharest','Milan','Nice','London','Dublin',
            'Athens','Praha','Warsaw','Helsinki','Zagreb','Vienna','Istanbul','Sofia',
            'Budapest','Bratislava','Timisoara','Cluj','Hamburg','Berlin','Krakow','Lisbon',
            'Amsterdam','Brussels','Varna','Edinburgh','Palermo','Reykjavík','Malta','Thessaloniki'
          ] as $c)
            <option value="{{ $c }}"></option>
          @endforeach
        </datalist>
      </div>

      <div>
        <label for="checkInDate" class="block font-medium text-gray-700 mb-1">
          {{ __('accommodations.fields.check_in') }}
        </label>
        <input
          type="date"
          id="checkInDate"
          name="checkInDate"
          value="{{ $checkInDate }}"
          min="{{ date('Y-m-d') }}"
          class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        >
      </div>

      <div>
        <label for="checkOutDate" class="block font-medium text-gray-700 mb-1">
          {{ __('accommodations.fields.check_out') }}
        </label>
        <input
          type="date"
          id="checkOutDate"
          name="checkOutDate"
          value="{{ $checkOutDate }}"
          min="{{ $checkInDate }}"
          class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        >
      </div>

      <div>
        <label for="adults" class="block font-medium text-gray-700 mb-1">
          {{ __('accommodations.fields.adults') }}
        </label>
        <input
          type="number"
          id="adults"
          name="adults"
          value="{{ $adults }}"
          min="1"
          class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
          required
        >
      </div>

      <div>
        <label for="order_by" class="block font-medium text-gray-700 mb-1">
          {{ __('accommodations.fields.sort_by') }}
        </label>
        <select
          id="order_by"
          name="order_by"
          class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
        >
          <option value="price_asc" {{ $order_by === 'price_asc' ? 'selected' : '' }}>
            {{ __('accommodations.sort.price_asc') }}
          </option>
          <option value="price_desc" {{ $order_by === 'price_desc' ? 'selected' : '' }}>
            {{ __('accommodations.sort.price_desc') }}
          </option>
          <option value="rating" {{ $order_by === 'rating' ? 'selected' : '' }}>
            {{ __('accommodations.sort.rating') }}
          </option>
          <option value="best_rating_for_price" {{ $order_by === 'best_rating_for_price' ? 'selected' : '' }}>
            {{ __('accommodations.sort.best_rating_for_price') }}
          </option>
        </select>
      </div>

      <div class="lg:col-span-1">
        <button
          type="submit"
          class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-medium py-2 rounded-lg transition"
        >
          {{ __('accommodations.buttons.search') }}
        </button>
      </div>
    </form>
  </div>

  @if($message)
    <div class="max-w-2xl mx-auto mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded-lg">
      {{ $message }}
    </div>
  @endif

  @if(!empty($hotelsData['result']))
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
      {{ __('accommodations.available', ['city' => $city]) }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($hotelsData['result'] as $hotel)
        @php
          $name        = $hotel['hotel_name']      ?? __('accommodations.unavailable');
          $cityName    = $hotel['city']            ?? __('accommodations.unknown');
          $reviewScore = $hotel['review_score']    ?? 'N/A';
          $priceValue  = $hotel['min_total_price'] ?? 0;
          $price       = number_format($priceValue, 2);
          $currency    = session('currency', 'EUR');
        @endphp

        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col justify-between">
          <div>
            @if(!empty($hotel['image_url']))
              <img src="{{ $hotel['image_url'] }}" alt="{{ $name }}" class="rounded-lg mb-4 object-cover h-48 w-full" />
            @endif

            <h3 class="text-xl font-semibold text-purple-700 mb-2">{{ $name }}</h3>
            <p class="text-gray-600"><strong>{{ __('accommodations.fields.city') }}:</strong> {{ $cityName }}</p>
            <p class="text-gray-600"><strong>{{ __('accommodations.fields.review_score') }}:</strong> {{ $reviewScore }}</p>
            <p class="text-gray-600"><strong>{{ __('accommodations.fields.price') }}:</strong> {{ $currency }} {{ $price }}</p>
          </div>

          <div>
            <button class="mt-4 bg-green-500 hover:bg-green-600 text-white font-medium py-2 rounded-lg transition w-full" onclick="purchaseHotel('{{ $name }}', '{{ $price }}')">
              {{ __('accommodations.buttons.purchase') }}
            </button>

            <div class="mt-4">
              @if(config('services.google_maps.key'))
                <iframe width="100%" height="200" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google_maps.key') }}&q={{ urlencode($name.' '.$city) }}" allowfullscreen></iframe>
              @else
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($name.' '.$city) }}" target="_blank" class="text-purple-600 hover:underline">
                  {{ __('accommodations.buttons.view_map') }}
                </a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-center text-gray-500">{{ __('accommodations.none') }}</p>
  @endif
</div>

<script>
function purchaseHotel(hotelName, price) {
  const currency = "{{ session('currency', 'EUR') }}";
  alert(`{{ __('accommodations.alert.choose') }} ${hotelName} {{ __('accommodations.alert.for') }} ${currency}${price}.`);
}
</script>
@endsection
