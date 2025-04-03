@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Blog Posts</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('blog.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create New Post
        </a>
    </div>

    @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <div class="bg-white border rounded shadow p-4">
                    @if($post->cover_image)
                        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded mb-4">
                    @endif
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('blog.show', $post->id) }}" class="text-blue-600 hover:underline">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 text-sm">by {{ $post->user->name ?? 'Unknown' }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @else
        <p>No blog posts available at the moment.</p>
    @endif
</div>
@endsection
