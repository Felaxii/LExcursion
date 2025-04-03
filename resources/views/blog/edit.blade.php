@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Blog Post</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block font-semibold mb-1">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required class="w-full border rounded p-2">
        </div>

        <div>
            <label for="cover_image" class="block font-semibold mb-1">Cover Image:</label>
            <input type="file" name="cover_image" id="cover_image" class="w-full">
            @if($post->cover_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="Current Cover" class="h-24 w-24 rounded object-cover">
                </div>
            @endif
        </div>

        <div>
            <label for="content" class="block font-semibold mb-1">Content:</label>
            <textarea name="content" id="content" rows="10" required class="w-full border rounded p-2">{{ old('content', $post->content) }}</textarea>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Update Post
        </button>
    </form>
</div>

<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
