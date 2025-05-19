@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-extrabold text-purple-700 mb-6">
    {{ __('blog.edit.title') }}
  </h1>

  @if($errors->any())
    <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')

    <div>
      <label for="title" class="block font-medium text-gray-700 mb-1">
        {{ __('blog.fields.title') }}
      </label>
      <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
             class="w-full border border-purple-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
      <label for="cover_image" class="block font-medium text-gray-700 mb-1">
        {{ __('blog.fields.cover_image') }}
      </label>
      <input type="file" name="cover_image" id="cover_image" class="w-full text-gray-700">
      @if($post->cover_image)
        <img src="{{ asset('storage/'.$post->cover_image) }}"
             alt="" class="mt-3 h-32 w-32 object-cover rounded-lg border">
      @endif
    </div>

    <div>
      <label for="content" class="block font-medium text-gray-700 mb-1">
        {{ __('blog.fields.content') }}
      </label>
      <textarea name="content" id="content" rows="10"
                class="w-full border border-purple-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('content', $post->content) }}</textarea>
    </div>

    <button type="submit"
            class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-medium py-3 rounded-lg transition">
      {{ __('blog.edit.update') }}
    </button>
  </form>
</div>
@endsection
