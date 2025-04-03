@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <article class="bg-white border rounded shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

        @if($post->cover_image)
            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded mb-4">
        @endif

        <div class="mb-4 text-gray-700 break-words">
            {!! $post->content !!}
        </div>

        <p class="mb-4 text-sm text-gray-600">By: {{ $post->user->name ?? 'Unknown' }}</p>

        @auth
            @if(auth()->user()->id === $post->user_id || auth()->user()->isAdmin())
                <div class="flex space-x-4">
                    <a href="{{ route('blog.edit', $post->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Edit Post
                    </a>
                    <form action="{{ route('blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Delete Post
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="mt-6">
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline">Back to Blog List</a>
        </div>
    </article>
</div>
@endsection
