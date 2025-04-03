@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Create a New Blog Post</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="title" class="block font-semibold mb-1">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border rounded p-2">
        </div>

        <div>
            <label for="cover_image" class="block font-semibold mb-1">Cover Image:</label>
            <input type="file" name="cover_image" id="cover_image" class="w-full">
        </div>

        <div>
            <label for="content" class="block font-semibold mb-1">Content:</label>
            <textarea name="content" id="content" rows="10" required class="w-full border rounded p-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Submit
        </button>
    </form>
</div>
@endsection
