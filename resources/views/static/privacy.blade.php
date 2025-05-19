@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
  <div class="bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-3xl font-extrabold text-purple-700 mb-4">{{ __('static.privacy.title') }}</h1>
    <p class="text-gray-700 leading-relaxed">{{ __('static.privacy.body') }}</p>
  </div>
</div>
@endsection
