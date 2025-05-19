@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">
  <h1 class="text-3xl font-extrabold text-purple-700 text-center">
    {{ __('trip_generator.title') }}
  </h1>

  <form method="POST" action="{{ route('trip-generator.generate') }}"
        class="bg-white p-6 rounded-lg shadow space-y-4">
    @csrf

    {{-- Type --}}
    <div>
      <label for="type" class="block font-medium text-gray-700">
        {{ __('trip_generator.fields.type') }}
      </label>
      <select id="type" name="type"
              class="mt-1 w-full border-gray-300 rounded-lg">
        <option value="leisure"    @selected(old('type')=='leisure')>
          {{ __('trip_generator.types.leisure') }}
        </option>
        <option value="exploration" @selected(old('type')=='exploration')>
          {{ __('trip_generator.types.exploration') }}
        </option>
      </select>
      @error('type') <p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Price Level --}}
    <div>
      <label for="price_level" class="block font-medium text-gray-700">
        {{ __('trip_generator.fields.price_level') }}
      </label>
      <select id="price_level" name="price_level"
              class="mt-1 w-full border-gray-300 rounded-lg">
        <option value="any"    @selected(old('price_level')=='any')>
          {{ __('trip_generator.price.any') }}
        </option>
        <option value="low"    @selected(old('price_level')=='low')>
          {{ __('trip_generator.price.low') }}
        </option>
        <option value="medium" @selected(old('price_level')=='medium')>
          {{ __('trip_generator.price.medium') }}
        </option>
        <option value="high"   @selected(old('price_level')=='high')>
          {{ __('trip_generator.price.high') }}
        </option>
      </select>
      @error('price_level') <p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    {{-- Geography --}}
    <fieldset class="space-y-2">
      <legend class="font-medium text-gray-700">
        {{ __('trip_generator.fields.geography') }}
      </legend>
      @foreach(['beach','mountain','lake','city','countryside'] as $geo)
        <label class="inline-flex items-center mr-4">
          <input type="checkbox" name="geography[]" value="{{ $geo }}"
                 @checked(in_array($geo, old('geography', [])))
                 class="form-checkbox"/>
          <span class="ml-2">{{ __('trip_generator.geography.' . $geo) }}</span>
        </label>
      @endforeach
      @error('geography.*') <p class="text-red-600">{{ $message }}</p>@enderror
    </fieldset>

    {{-- Interests --}}
    <fieldset class="space-y-2">
      <legend class="font-medium text-gray-700">
        {{ __('trip_generator.fields.interests') }}
      </legend>
      @foreach(['food','architecture','events','shopping','nightlife'] as $i)
        <label class="inline-flex items-center mr-4">
          <input type="checkbox" name="interests[]" value="{{ $i }}"
                 @checked(in_array($i, old('interests', [])))
                 class="form-checkbox"/>
          <span class="ml-2">{{ __('trip_generator.interests.' . $i) }}</span>
        </label>
      @endforeach
      @error('interests.*') <p class="text-red-600">{{ $message }}</p>@enderror
      <p class="text-sm text-gray-500 mt-1">({{ __('trip_generator.multiselect') }})</p>
    </fieldset>

    {{-- Extra --}}
    <div>
      <label for="extra" class="block font-medium text-gray-700">
        {{ __('trip_generator.fields.extra') }}
      </label>
      <input type="text" id="extra" name="extra"
             value="{{ old('extra') }}"
             class="mt-1 w-full border-gray-300 rounded-lg"
             placeholder="{{ __('trip_generator.placeholders.extra') }}" />
      @error('extra') <p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-purple-800
                   text-white py-2 rounded-lg font-semibold">
      {{ __('trip_generator.buttons.generate') }}
    </button>
  </form>

  @if(session('error'))
    <div class="text-red-600 text-center">
      {{ session('error') }}
    </div>
  @endif

  @if(!empty($cities))
    <div class="space-y-6">
      @foreach($cities as $c)
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-xl font-semibold text-purple-700">
            {{ $c['name'] }}, {{ $c['country'] }}
          </h3>
          <p class="mt-2 text-gray-700">{{ $c['description'] }}</p>
          <div class="mt-4 space-x-2">
            <a href="{{ route('accommodations', ['city'=>$c['name']]) }}"
               class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-4 py-1 rounded">
              {{ __('trip_generator.buttons.book_stay') }}
            </a>
            <a href="{{ route('travel-options', ['city'=>$c['name'],'travelers'=>1,'date'=>now()->toDateString() ]) }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">
              {{ __('trip_generator.buttons.travel_to') }}
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
