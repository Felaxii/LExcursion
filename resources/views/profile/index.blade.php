@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
    <div class="flex items-center space-x-6">
      @if($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}"
             alt="{{ __('profile.profile_picture_alt') }}"
             class="h-24 w-24 rounded-full object-cover border-2 border-purple-600">
      @else
        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.72 6.879 1.954M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
      @endif

      <div>
        <h2 class="text-2xl font-bold text-purple-700">{{ $user->nickname ?? $user->email }}</h2>
        <p class="text-gray-600">{{ __('profile.email') }} {{ $user->email }}</p>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow-lg p-8 mb-8 grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
      <p class="mb-4"><strong class="text-gray-700">{{ __('profile.full_name') }}</strong>
      <span class="text-gray-900">{{ $user->full_name ?? __('profile.not_set') }}</span></p>

      <p class="mb-4"><strong class="text-gray-700">{{ __('profile.address') }}</strong>
      <span class="text-gray-900">{{ $user->address ?? __('profile.not_set') }}</span></p>

      <p class="mb-4"><strong class="text-gray-700">{{ __('profile.occupation') }}</strong>
      <span class="text-gray-900">{{ $user->occupation ?? __('profile.not_set') }}</span></p>

      <p class="mb-4"><strong class="text-gray-700">{{ __('profile.description') }}</strong>
      <span class="text-gray-900">{{ $user->description ?? __('profile.not_set') }}</span></p>
    </div>
    <div class="flex items-center justify-center">
      <a href="{{ route('profile.edit') }}"
         class="bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900
                text-white font-medium py-3 px-6 rounded-lg transition">
        {{ __('profile.edit_profile_btn') }}
      </a>
    </div>
  </div>
</div>
@endsection
