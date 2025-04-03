<div>
    <h1>{{ __('messages.find_destination') }}</h1>
    <div id="map" style="height: 600px;"></div>

    <!-- Input for simulating country selection -->
    <input type="text" wire:model="country" placeholder="Enter country (e.g., France)" />

    <ul>
        @foreach($destinations as $destination)
            <li>{{ $destination['city_name'] }} - {{ $destination['country'] }}</li>
        @endforeach
    </ul>
</div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script>
        document.addEventListener('livewire:load', function () {
            var map = L.map('map').setView([54, 15], 4);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            // Future enhancement: add map click events to update the Livewire component... soooon
        });
    </script>
@endpush
