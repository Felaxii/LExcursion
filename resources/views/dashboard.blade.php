@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Welcome to Your Dashboard</h2>
    <p class="mb-6 text-gray-700">Use the quick links below to navigate:</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <a href="{{ route('profile.index') }}" class="block p-4 bg-white border rounded shadow hover:shadow-md transition duration-150">
            <h3 class="text-lg font-semibold text-blue-600">View/Edit Profile</h3>
            <p class="text-sm text-gray-600">Manage your personal details and profile settings.</p>
        </a>
        <a href="{{ route('map') }}" class="block p-4 bg-white border rounded shadow hover:shadow-md transition duration-150">
            <h3 class="text-lg font-semibold text-blue-600">Interactive Map</h3>
            <p class="text-sm text-gray-600">Explore destinations with our interactive map.</p>
        </a>
        <a href="{{ route('recommendations') }}" class="block p-4 bg-white border rounded shadow hover:shadow-md transition duration-150">
            <h3 class="text-lg font-semibold text-blue-600">Trip Recommendations</h3>
            <p class="text-sm text-gray-600">Discover personalized travel ideas and tips.</p>
        </a>
        <a href="{{ route('blog.index') }}" class="block p-4 bg-white border rounded shadow hover:shadow-md transition duration-150">
            <h3 class="text-lg font-semibold text-blue-600">Blog</h3>
            <p class="text-sm text-gray-600">Read travel stories, tips, and updates.</p>
        </a>
    </div>
</div>
@endsection
