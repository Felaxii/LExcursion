@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6">Your Profile</h2>

    <div class="flex items-center space-x-4 mb-6">
        @if($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="h-16 w-16 rounded-full object-cover">
        @else
            <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" class="h-16 w-16 rounded-full">
        @endif
        <div>
            <h3 class="text-xl font-semibold">{{ $user->nickname ?? $user->email }}</h3>
            <p class="text-gray-600">Email: {{ $user->email }}</p>
        </div>
    </div>

    <div class="mb-6">
        <p><strong>Password:</strong> ••••••••</p>
    </div>

    <div class="mb-6">
        <p><strong>Full Name:</strong> {{ $user->full_name ?? 'Not set' }}</p>
        <p><strong>Address:</strong> {{ $user->address ?? 'Not set' }}</p>
        <p><strong>Occupation:</strong> {{ $user->occupation ?? 'Not set' }}</p>
        <p><strong>Description:</strong> {{ $user->description ?? 'Not set' }}</p>
    </div>

    <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Edit Profile
    </a>
</div>
@endsection
