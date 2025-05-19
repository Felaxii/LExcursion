@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-purple-700 mb-6">{{ __('profile.edit_profile') }}</h2>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc pl-5 space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div>
        <label for="nickname" class="block text-gray-700 mb-1">{{ __('profile.field_nickname') }}</label>
        <input type="text" name="nickname" id="nickname"
               value="{{ old('nickname', $user->nickname) }}"
               class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-2">
      </div>

      <div>
        <label for="full_name" class="block text-gray-700 mb-1">{{ __('profile.field_full_name') }}</label>
        <input type="text" name="full_name" id="full_name"
               value="{{ old('full_name', $user->full_name) }}"
               class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-2">
      </div>

      <div>
        <label for="address" class="block text-gray-700 mb-1">{{ __('profile.field_address') }}</label>
        <input type="text" name="address" id="address"
               value="{{ old('address', $user->address) }}"
               class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-2">
      </div>

      <div>
        <label for="occupation" class="block text-gray-700 mb-1">{{ __('profile.field_occupation') }}</label>
        <input type="text" name="occupation" id="occupation"
               value="{{ old('occupation', $user->occupation) }}"
               class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-2">
      </div>

      <div>
        <label for="description" class="block text-gray-700 mb-1">{{ __('profile.field_description') }}</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 p-2">{{ old('description', $user->description) }}</textarea>
      </div>

      <div>
        <label for="profile_picture" class="block text-gray-700 mb-1">{{ __('profile.field_profile_picture') }}</label>
        <input type="file" name="profile_picture" id="profile_picture" class="w-full">
        @if($user->profile_picture)
          <div class="mt-4">
            <img src="{{ asset('storage/' . $user->profile_picture) }}"
                 alt="{{ __('profile.profile_picture_alt') }}"
                 class="h-32 w-32 rounded-full object-cover border-2 border-purple-600">
          </div>
        @endif
      </div>

      <button type="submit"
              class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900
                     text-white font-medium py-3 rounded-lg transition">
        {{ __('profile.update_profile_btn') }}
      </button>
    </form>
  </div>
</div>
@endsection
