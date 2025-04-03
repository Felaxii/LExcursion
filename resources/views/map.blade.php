@extends('layouts.app')

@section('content')
<style>
    #map { height: 80vh; }
    #map-controls {
        padding: 10px;
        background: #f0f0f0;
        margin-bottom: 10px;
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: none;
    }
    .modal-window {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        z-index: 1001;
        width: 300px;
        display: none;
    }
    .modal-window h3 { margin-top: 0; }
    .modal-window button {
        margin: 5px;
        padding: 8px 12px;
        border: none;
        background: #3388ff;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }
    .modal-window .close-btn { background: #ccc; }
</style>

<div id="map-controls">
    <label for="num-travelers">Travelers:</label>
    <select id="num-travelers">
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>

    <label for="departure-date">Departure Date:</label>
    <input type="date" id="departure-date">

    <label for="return">Return Flight:</label>
    <input type="checkbox" id="return">

    <span id="return-date-container" style="display: none; margin-left: 10px;">
        <label for="return-date">Return Date:</label>
        <input type="date" id="return-date">
    </span>
</div>

<div id="map"></div>

<div class="modal-overlay" id="modal-overlay"></div>

<div class="modal-window" id="modal-window">
    <h3 id="modal-city-name"></h3>
    <p>Please choose an option:</p>
    <button id="book-btn">Book a place to stay</button>
    <button id="travel-btn">Travel to</button>
    <br>
    <button id="close-modal" class="close-btn">Close</button>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    const vilniusCoords = [54.6872, 25.2797];

    function openCityOptions(cityName) {
        document.getElementById('modal-city-name').textContent = cityName;
        document.getElementById('modal-overlay').style.display = 'block';
        document.getElementById('modal-window').style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        var departureDateInput = document.getElementById('departure-date');
        departureDateInput.value = today;
        departureDateInput.setAttribute('min', today);

        var returnCheckbox = document.getElementById('return');
        var returnDateContainer = document.getElementById('return-date-container');
        var returnDateInput = document.getElementById('return-date');

        if (returnCheckbox.checked) {
            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var tomorrowStr = tomorrow.toISOString().split('T')[0];
            returnDateInput.value = tomorrowStr;
            returnDateInput.setAttribute('min', departureDateInput.value);
            returnDateContainer.style.display = 'inline-block';
        } else {
            returnDateContainer.style.display = 'none';
        }

        returnCheckbox.addEventListener('change', function() {
            if (returnCheckbox.checked) {
                returnDateContainer.style.display = 'inline-block';
                if (!returnDateInput.value) {
                    var tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    var tomorrowStr = tomorrow.toISOString().split('T')[0];
                    returnDateInput.value = tomorrowStr;
                }
                returnDateInput.setAttribute('min', departureDateInput.value);
            } else {
                returnDateContainer.style.display = 'none';
            }
        });

        departureDateInput.addEventListener('change', function() {
            if (returnCheckbox.checked) {
                returnDateInput.setAttribute('min', departureDateInput.value);
            }
        });

        var map = L.map('map').setView([54, 15], 4);

        var southWest = L.latLng(34.5, -25.0);
        var northEast = L.latLng(72.0, 45.0);
        var europeBounds = L.latLngBounds(southWest, northEast);
        map.setMaxBounds(europeBounds);
        map.setMinZoom(3);
        map.setMaxZoom(10);

        // OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // GeoJSON boundaries for Europe
        fetch('/data/europe.geojson')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    style: function(feature) {
                        return { color: "#3388ff", weight: 2, fillOpacity: 0.1 };
                    },
                    onEachFeature: function(feature, layer) {
                        layer.on('click', function(e) {
                            onCountryClick(feature, layer);
                        });
                    }
                }).addTo(map);
            })
            .catch(err => console.error('Error loading GeoJSON:', err));

        function onCountryClick(feature, layer) {
            map.fitBounds(layer.getBounds());
            var countryName = feature.properties.NAME || feature.properties.ADMIN || feature.properties.name;
            var popupContent = "<b>" + countryName + "</b>";
            layer.bindPopup(popupContent).openPopup();
            loadPointsOfInterest(countryName);
        }

        // Load city markers from cities.json
        function loadPointsOfInterest(countryName) {
            if (window.poiLayer) { map.removeLayer(window.poiLayer); }
            fetch('/data/cities.json')
                .then(response => response.json())
                .then(citiesData => {
                    window.citiesData = citiesData;
                    window.poiLayer = L.layerGroup();
                    for (var city in citiesData) {
                        var cityData = citiesData[city];
                        var marker = L.marker(cityData.coords).addTo(window.poiLayer);
                        marker.bindPopup("<b>" + city + "</b><br>" + cityData.description +
                            "<br><a href='#' onclick='openCityOptions(\"" + city + "\")'>Select</a>");
                    }
                    window.poiLayer.addTo(map);
                })
                .catch(err => console.error('Error loading cities JSON:', err));
        }

        document.getElementById('book-btn').addEventListener('click', function() {
            var cityName = document.getElementById('modal-city-name').textContent;
            var numTravelers = document.getElementById('num-travelers').value;
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('modal-window').style.display = 'none';
            window.location.href = "/accommodations?city=" + encodeURIComponent(cityName) +
                "&travelers=" + numTravelers;
        });

        document.getElementById('travel-btn').addEventListener('click', function() {
            var cityName = document.getElementById('modal-city-name').textContent;
            var numTravelers = document.getElementById('num-travelers').value;
            var departureDate = document.getElementById('departure-date').value;
            var isReturn = document.getElementById('return').checked ? 1 : 0;
            var returnDate = "";
            if (isReturn) {
                returnDate = document.getElementById('return-date').value;
            }
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('modal-window').style.display = 'none';
            if (window.citiesData && window.citiesData[cityName]) {
                var cityCoords = window.citiesData[cityName].coords;
                if (window.routeLine) { map.removeLayer(window.routeLine); }
                window.routeLine = L.polyline([vilniusCoords, cityCoords], { color: 'green' }).addTo(map);
            }
            setTimeout(function() {
                window.location.href = "/travel-options?city=" + encodeURIComponent(cityName) +
                    "&travelers=" + numTravelers +
                    "&date=" + departureDate +
                    "&return=" + isReturn +
                    "&returnDate=" + encodeURIComponent(returnDate);
            }, 1500);
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('modal-overlay').style.display = 'none';
            document.getElementById('modal-window').style.display = 'none';
        });
    });
</script>
@endsection
