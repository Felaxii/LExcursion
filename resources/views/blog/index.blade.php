@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-extrabold text-purple-700">
      {{ __('blog.index.title') }}
    </h1>
    <a href="{{ route('blog.create') }}"
       class="inline-block bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-medium py-2 px-4 rounded-lg transition">
      {{ __('blog.index.create') }}
    </a>
  </div>

  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @if($posts->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($posts as $post)
        <div class="bg-white border border-purple-100 rounded-lg shadow hover:shadow-lg transition overflow-hidden">
          @if($post->cover_image)
            <img src="{{ asset('storage/'.$post->cover_image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-48 object-cover">
          @endif
          <div class="p-5 space-y-3">
            <h2 class="text-xl font-semibold text-gray-800">
              <a href="{{ route('blog.show', $post) }}" class="hover:text-purple-600 transition">
                {{ $post->title }}
              </a>
            </h2>
            <p class="text-gray-500 text-sm">
              {{ __('blog.index.by') }} {{ $post->user->name ?? __('blog.index.unknown') }}
            </p>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8">
      {{ $posts->links() }}
    </div>
  @else
    <p class="text-center text-gray-500">{{ __('blog.index.empty') }}</p>
  @endif
</div>
@endsection
