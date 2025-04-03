@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6">Edit Profile</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf>

        <div>
            <label for="nickname" class="block font-semibold mb-1">Nickname:</label>
            <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label for="full_name" class="block font-semibold mb-1">Full Name:</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label for="address" class="block font-semibold mb-1">Address:</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label for="occupation" class="block font-semibold mb-1">Occupation:</label>
            <input type="text" name="occupation" id="occupation" value="{{ old('occupation', $user->occupation) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label for="description" class="block font-semibold mb-1">Description:</label>
            <textarea name="description" id="description" rows="5" class="w-full border rounded p-2">{{ old('description', $user->description) }}</textarea>
        </div>

        <div>
            <label for="profile_picture" class="block font-semibold mb-1">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" class="w-full">
            @if($user->profile_picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="h-24 w-24 rounded object-cover">
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update Profile
        </button>
    </form>
</div>
@endsection
