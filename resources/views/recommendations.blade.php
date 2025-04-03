@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">City Recommendations</h1>

    <!-- Trip Type Selector -->
    <form action="{{ route('recommendations') }}" method="GET" class="mb-6">
        <label for="trip_type" class="block font-medium mb-2">Select Trip Type:</label>
        <select id="trip_type" name="trip_type" class="border rounded p-2 w-full" onchange="this.form.submit()">
            <option value="leisure" {{ $trip_type === 'leisure' ? 'selected' : '' }}>Leisure</option>
            <option value="exploration" {{ $trip_type === 'exploration' ? 'selected' : '' }}>Exploration</option>
        </select>
    </form>

    <!-- City Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($cities as $city)
            @php
                $slug = Str::slug($city['name']);
                $truncated = Str::limit($city['description'], 100);
            @endphp
            <div class="bg-white shadow rounded overflow-hidden p-4">
                <img src="{{ asset($city['image']) }}" alt="{{ $city['name'] }}" class="w-full h-48 object-cover mb-4">
                <h2 class="font-bold text-xl mb-2">{{ $city['name'] }}, {{ $city['county'] }}</h2>
                <p id="desc-{{ $slug }}" data-full="{{ $city['description'] }}" data-truncated="{{ $truncated }}" data-expanded="false" class="text-gray-700">
                    {{ $truncated }}
                </p>
                <button id="btn-{{ $slug }}" class="text-blue-500 text-sm focus:outline-none" onclick="toggleDescription('{{ $slug }}')">Read more</button>
                <div class="mt-4 flex justify-between">
                    <!-- "Travel to" button -->
                    <a href="{{ route('travel-options') }}?city={{ urlencode($city['name']) }}&travelers=1&date={{ date('Y-m-d') }}" 
                       class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                        Travel to
                    </a>
                    <!-- "Book a place to stay" button -->
                    <a href="{{ route('accommodations') }}?city={{ urlencode($city['name']) }}&travelers=1" 
                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        Book a place to stay
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-600">No cities found for the selected trip type.</p>
        @endforelse
    </div>
</div>

<script>
function toggleDescription(slug) {
    var descElem = document.getElementById('desc-' + slug);
    var btn = document.getElementById('btn-' + slug);
    var expanded = descElem.getAttribute('data-expanded') === 'true';
    var fullText = descElem.getAttribute('data-full');
    var truncatedText = descElem.getAttribute('data-truncated');

    if (expanded) {
        descElem.innerText = truncatedText;
        descElem.setAttribute('data-expanded', 'false');
        btn.innerText = 'Read more';
    } else {
        descElem.innerText = fullText;
        descElem.setAttribute('data-expanded', 'true');
        btn.innerText = 'Show less';
    }
}
</script>
@endsection
