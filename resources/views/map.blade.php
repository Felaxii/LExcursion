@extends('layouts.app')

@section('content')
<style>
  /* map container */
  #map {
    width: 100%;
    height: 80vh;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 2px solid #E2E8F0;
  }

  /* controls bar */
  .controls-bar {
    background: #6B46C1;
    color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 1rem;
    margin-bottom: 1rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
  }
  .controls-bar label {
    font-weight: 500;
  }
  .controls-bar select,
  .controls-bar input[type="date"] {
    background: #fff;
    color: #1A202C;
    border-radius: 0.375rem;
    padding: 0.5rem;
    border: none;
    min-width: 8rem;
    transition: box-shadow .2s, outline .2s;
  }
  .controls-bar select:focus,
  .controls-bar input[type="date"]:focus {
    outline: 2px solid #6B46C1;
    box-shadow: 0 0 0 3px rgba(107,70,193, .3);
  }
  .controls-bar input[type="checkbox"] {
    accent-color: #fff;
    width: 1.25rem;
    height: 1.25rem;
  }
  .controls-bar input[disabled] {
    background: #EDF2F7;
    color: #A0AEC0;
    cursor: not-allowed;
  }

  /* modal overlay */
  .modal-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    display: none;
  }

  /* modal window */
  .modal-window {
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%);
    background: #fff;
    padding: 1.5rem;
    border-radius: 0.5rem;
    z-index: 1001;
    width: 320px;
    max-width: 90vw;
    display: none;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    text-align: center;
  }
  .modal-window h3 {
    margin-top: 0;
    font-size: 1.25rem;
    color: #6B46C1;
  }
  .modal-window button {
    margin: 0.5rem 0.25rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    font-weight: 500;
    transition: opacity .2s;
  }
  .modal-window button:hover {
    opacity: .9;
  }
  .modal-window .close-btn {
    background: #A0AEC0;
    color: #1A202C;
  }
  .modal-window #book-btn,
  .modal-window #travel-btn {
    background: #6B46C1;
    color: #fff;
  }

  /* custom map pin */
  .custom-pin {
    width: 24px; height: 24px;
    background: #6B46C1;
    border-radius: 50% 50% 50% 0;
    transform: rotate(-45deg);
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    position: relative;
  }
  .custom-pin::after {
    content: '';
    width: 10px; height: 10px;
    background: #fff;
    border-radius: 50%;
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
  }
</style>

<div class="max-w-7xl mx-auto px-4 py-6">
  <div class="controls-bar">
    <div class="flex items-center space-x-2">
      <label for="num-travelers">{{ __('map.travelers') }}</label>
      <select id="num-travelers">
        @for ($i = 1; $i <= 5; $i++)
          <option>{{ $i }}</option>
        @endfor
      </select>
    </div>
    <div class="flex items-center space-x-2">
      <label for="departure-date">{{ __('map.departure_date') }}</label>
      <input type="date" id="departure-date">
    </div>
    <div class="flex items-center space-x-2">
      <label class="flex items-center">
        <input type="checkbox" id="return">
        <span class="ml-1">{{ __('map.return_flight') }}</span>
      </label>
    </div>
    <div class="flex items-center space-x-2">
      <label for="return-date">{{ __('map.return_date') }}</label>
      <input type="date" id="return-date" disabled>
    </div>
  </div>

  <div id="map"></div>
</div>

<div id="modal-overlay" class="modal-overlay"></div>
<div id="modal-window" class="modal-window">
  <h3 id="modal-city-name"></h3>
  <p>{{ __('map.choose_option') }}</p>
  <button id="book-btn">{{ __('map.book_stay') }}</button>
  <button id="travel-btn">{{ __('map.travel_to') }}</button>
  <br>
  <button id="close-modal" class="close-btn">{{ __('map.close') }}</button>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const depInput  = document.getElementById('departure-date');
  const retCheck  = document.getElementById('return');
  const retInput  = document.getElementById('return-date');
  const today     = new Date().toISOString().split('T')[0];

  depInput.value = today;
  depInput.min   = today;

  function toggleReturn() {
    if (retCheck.checked) {
      retInput.disabled = false;
      retInput.min      = depInput.value;
      const next = new Date();
      next.setDate(next.getDate() + 1);
      retInput.value = next.toISOString().split('T')[0];
    } else {
      retInput.disabled = true;
      retInput.value    = '';
    }
  }

  retCheck.addEventListener('change', toggleReturn);
  depInput.addEventListener('change', () => {
    retInput.min = depInput.value;
    if (!retInput.disabled && retInput.value < depInput.value) {
      retInput.value = depInput.value;
    }
  });

  toggleReturn();

  const map = L.map('map').setView([54, 15], 4);
  map
    .setMaxBounds([[34.5, -25], [72, 45]])
    .setMinZoom(3)
    .setMaxZoom(10);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  fetch('/data/europe.geojson')
    .then(r => r.json())
    .then(data => {
      L.geoJSON(data, {
        style: () => ({ color: '#6B46C1', weight: 2, fillOpacity: 0.1 }),
        onEachFeature: (feat, layer) =>
          layer.on('click', () => onCountryClick(feat, layer))
      }).addTo(map);
    });

  function onCountryClick(feature, layer) {
    const name = feature.properties.NAME
              || feature.properties.ADMIN
              || feature.properties.name;
    layer.bindPopup(`<b>${name}</b>`).openPopup();
    map.fitBounds(layer.getBounds());
    loadPOI(name);
  }

  function loadPOI(country) {
    if (window.poiLayer) map.removeLayer(window.poiLayer);

    fetch('/data/cities.json')
      .then(r => r.json())
      .then(cities => {
        window.poiLayer = L.layerGroup();
        Object.entries(cities).forEach(([city, info]) => {
          const icon = L.divIcon({
            className: 'custom-pin',
            iconSize:    [24, 24],
            iconAnchor:  [12, 24],
            popupAnchor: [0, -24]
          });

          const popupContent = `
            <b>${city}</b><br>
            ${info.description}<br>
            <a href="#"
               class="text-indigo-600 underline"
               onclick="openCityOptions('${city}')">
              {{ __('map.select') }}
            </a>
          `;

          L.marker(info.coords, { icon })
           .addTo(window.poiLayer)
           .bindPopup(popupContent);
        });
        map.addLayer(window.poiLayer);
      });
  }

  window.openCityOptions = city => {
    document.getElementById('modal-city-name').textContent = city;
    document.getElementById('modal-overlay').style.display = 'block';
    document.getElementById('modal-window').style.display  = 'block';
  };

  document.getElementById('book-btn').onclick = () => {
    const city = document.getElementById('modal-city-name').textContent;
    const n    = document.getElementById('num-travelers').value;
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('modal-window').style.display  = 'none';
    window.location.href = `/accommodations?city=${encodeURIComponent(city)}&travelers=${n}`;
  };

  document.getElementById('travel-btn').onclick = () => {
    const city  = document.getElementById('modal-city-name').textContent;
    const n     = document.getElementById('num-travelers').value;
    const d     = depInput.value;
    const isRet = retCheck.checked ? 1 : 0;
    const rd    = isRet ? retInput.value : '';
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('modal-window').style.display  = 'none';
    setTimeout(() => {
      window.location.href =
        `/travel-options?city=${encodeURIComponent(city)}` +
        `&travelers=${n}&date=${d}&return=${isRet}` +
        `&returnDate=${encodeURIComponent(rd)}`;
    }, 500);
  };

  document.getElementById('close-modal').onclick = () => {
    document.getElementById('modal-overlay').style.display = 'none';
    document.getElementById('modal-window').style.display  = 'none';
  };
});
</script>
@endsection
