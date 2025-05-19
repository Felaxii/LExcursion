@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
  <div class="bg-white rounded-lg shadow-lg p-8 max-w-md mx-auto">
    <h1 class="text-3xl font-extrabold text-purple-700 mb-4">{{ __('static.contact.title') }}</h1>
    <p class="text-gray-700 mb-6 leading-relaxed">{{ __('static.contact.body') }}</p>
    <div class="space-y-4">
      <p><strong class="text-gray-700">{{ __('static.contact.address') }}:</strong><br>{{ __('static.contact.address') }}</p>
      <p><strong class="text-gray-700">{{ __('static.contact.email') }}:</strong><br><a href="mailto:{{ __('static.contact.email') }}" class="text-purple-600 hover:underline">{{ __('static.contact.email') }}</a></p>
      <p><strong class="text-gray-700">{{ __('static.contact.phone') }}:</strong><br><a href="tel:{{ __('static.contact.phone') }}" class="text-purple-600 hover:underline">{{ __('static.contact.phone') }}</a></p>
    </div>
  </div>
</div>
@endsection
