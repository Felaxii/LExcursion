@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6">Travel Options to {{ $city }}</h2>

    <div class="mb-4">
        <p><strong>Departure Date:</strong> {{ $departureDate }}</p>
        @if($returnFlag && $returnDate)
            <p><strong>Return Date:</strong> {{ $returnDate }}</p>
        @endif
        <p><strong>Number of Travelers:</strong> {{ $passengers }}</p>
    </div>

    @php
        $offers = $flightData['data'] ?? [];
    @endphp

    @if(count($offers) > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($offers as $offer)
                @php
                    $grandTotal = $offer['price']['grandTotal'] ?? 'N/A';
                    $currency   = $offer['price']['currency'] ?? '';
                    $itineraries = $offer['itineraries'] ?? [];
                @endphp
                <div class="p-6 border rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Flight Option</h3>
                    <p class="mb-1"><strong>Price:</strong> €{{ $grandTotal }} {{ $currency }}</p>
                    @if($returnFlag && $returnDate)
                        <p class="mb-1 text-gray-600">Round Trip</p>
                    @else
                        <p class="mb-1 text-gray-600">One Way</p>
                    @endif

                    @foreach($itineraries as $itinerary)
                        @php $rawDuration = $itinerary['duration'] ?? 'N/A'; @endphp
                        <p class="mb-1"><strong>Itinerary Duration:</strong> {{ $rawDuration }}</p>
                        @foreach($itinerary['segments'] as $index => $segment)
                            @php
                                $depCode  = $segment['departure']['iataCode'] ?? '???';
                                $depTime  = $segment['departure']['at'] ?? '???';
                                $arrCode  = $segment['arrival']['iataCode'] ?? '???';
                                $arrTime  = $segment['arrival']['at'] ?? '???';
                                $segmentDuration = $segment['duration'] ?? 'N/A';
                                $carrierCode = $segment['carrierCode'] ?? '??';
                                $flightNumber = $segment['number'] ?? '??';
                            @endphp
                            <div class="ml-4 mb-2 p-2 bg-gray-50 rounded">
                                <strong>Segment {{ $index + 1 }}:</strong><br>
                                Depart: {{ $depCode }} at {{ $depTime }}<br>
                                Arrive: {{ $arrCode }} at {{ $arrTime }}<br>
                                Duration: {{ $segmentDuration }}<br>
                                Flight: {{ $carrierCode }} {{ $flightNumber }}
                            </div>
                        @endforeach
                        <hr class="my-2">
                    @endforeach

                    <button 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2"
                        onclick="purchaseTicket('Flight', '{{ $grandTotal }}', '{{ $currency }}')">
                        Purchase Ticket
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <p>No flight data available. Please try another date or destination.</p>
    @endif
</div>

<script>
function purchaseTicket(type, price, currency) {
    alert("You have chosen to purchase a " + type + " ticket for €" + price + " " + currency + ". This is a demo function.");
}
</script>
@endsection
