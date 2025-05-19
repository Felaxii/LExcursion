@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
  <article class="bg-white border border-purple-100 rounded-lg shadow-md overflow-hidden">
    <header class="p-6 bg-purple-50">
      <h1 class="text-3xl font-extrabold text-purple-700">{{ $post->title }}</h1>
      <p class="mt-2 text-sm text-gray-500">
        {{ __('blog.show.by') }} {{ $post->user->name ?? __('blog.show.unknown') }}
      </p>
    </header>

    @if($post->cover_image)
      <img src="{{ asset('storage/'.$post->cover_image) }}"
           alt="{{ $post->title }}"
           class="w-full h-64 object-cover">
    @endif

    <div class="p-6 prose max-w-none">
      {!! $post->content !!}
    </div>

    <footer class="p-6 flex justify-between items-center bg-purple-50">
      <a href="{{ route('blog.index') }}"
         class="text-purple-600 hover:underline">
        &larr; {{ __('blog.show.back') }}
      </a>

      @auth
        @if(auth()->id()=== $post->user_id || auth()->user()->isAdmin())
          <div class="space-x-3">
            <a href="{{ route('blog.edit', $post) }}"
               class="inline-block bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white py-2 px-4 rounded-lg transition">
              {{ __('blog.show.edit') }}
            </a>
            <form action="{{ route('blog.destroy', $post) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('{{ __('blog.show.confirm_delete') }}')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition">
                {{ __('blog.show.delete') }}
              </button>
            </form>
          </div>
        @endif
      @endauth
    </footer>
  </article>
</div>
@endsection
