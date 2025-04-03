@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6">Hotels in {{ $city }}</h2>

    <!-- Search Form -->
    <div class="mb-6">
        <form method="GET" action="{{ route('accommodations') }}" class="flex flex-col sm:flex-row items-center gap-4">
            <!-- City Dropdown -->
            <div>
                <label for="city" class="block font-semibold">City:</label>
                <select id="city" name="city" class="border rounded p-1">
                    @php
                        $cities = [
                            'Riga', 'Tallinn', 'Rome', 'Munich', 'Nuremberg', 'Paris', 'Barcelona', 'Madrid',
                            'Oslo', 'Stockholm', 'Copenhagen', 'Bucharest', 'Milan', 'Nice', 'London', 'Dublin',
                            'Athens', 'Praha', 'Warsaw', 'Helsinki', 'Zagreb', 'Vienna', 'Istanbul', 'Sofia',
                            'Budapest', 'Bratislava', 'Timisoara', 'Cluj', 'Hamburg', 'Berlin', 'Krakow', 'Lisbon',
                            'Amsterdam', 'Brussels', 'Varna', 'Edinburgh', 'Palermo', 'Reykjavík', 'Malta', 'Thessaloniki'
                        ];
                    @endphp
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ $city == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Check-In Date -->
            <div>
                <label for="checkInDate" class="block font-semibold">Check-In Date:</label>
                <input type="date" id="checkInDate" name="checkInDate" value="{{ $checkInDate }}" class="border rounded p-1" min="{{ date('Y-m-d') }}">
            </div>

            <!-- Check-Out Date -->
            <div>
                <label for="checkOutDate" class="block font-semibold">Check-Out Date:</label>
                <input type="date" id="checkOutDate" name="checkOutDate" value="{{ $checkOutDate }}" class="border rounded p-1" min="{{ $checkInDate }}">
            </div>

            <!-- Adults -->
            <div>
                <label for="adults" class="block font-semibold">Adults:</label>
                <input type="number" id="adults" name="adults" value="{{ $adults }}" class="border rounded p-1" min="1">
            </div>

            <!-- Sort By Dropdown -->
            <div>
                <label for="order_by" class="block font-semibold">Sort By:</label>
                <select name="order_by" id="order_by" class="border rounded p-1">
                    <option value="price_asc" {{ $order_by == 'price_asc' ? 'selected' : '' }}>Price (Lowest to Highest)</option>
                    <option value="price_desc" {{ $order_by == 'price_desc' ? 'selected' : '' }}>Price (Highest to Lowest)</option>
                    <option value="rating" {{ $order_by == 'rating' ? 'selected' : '' }}>Rating</option>
                    <option value="best_rating_for_price" {{ $order_by == 'best_rating_for_price' ? 'selected' : '' }}>Best Rating for the Price</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Search Hotels
                </button>
            </div>
        </form>
    </div>

    <!-- Display Error Message -->
    @if($message)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <!-- Display Hotel List -->
    @if(isset($hotelsData['result']) && count($hotelsData['result']) > 0)
        <h2 class="text-2xl font-semibold mb-4">Available Hotels in {{ $city }}</h2>
        <div class="grid grid-cols-1 gap-6">
            @foreach($hotelsData['result'] as $hotel)
                @php
                    $name = $hotel['hotel_name'] ?? 'Hotel Unavailable';
                    $cityName = $hotel['city'] ?? 'Unknown';
                    $reviewScore = $hotel['review_score'] ?? 'N/A';
                    $price = $hotel['min_total_price'] ?? 'N/A';
                @endphp
                <div class="p-6 border rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">{{ $name }}</h3>
                    <p><strong>City:</strong> {{ $cityName }}</p>
                    <p><strong>Review Score:</strong> {{ $reviewScore }}</p>
                    <p><strong>Price:</strong> €{{ $price }}</p>
                    <!-- Purchase Button -->
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="purchaseHotel('{{ $name }}', '{{ $price }}')">
                        Purchase Room
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <p>No hotels found for the selected city and dates.</p>
    @endif
</div>

<script>
function purchaseHotel(hotelName, price) {
    // This function is a placeholder. You can replace it with your actual purchase logic.
    alert("You have chosen to purchase a room at " + hotelName + " for €" + price + ". This is a demo function.");
}
</script>
@endsection
