<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
        <!-- Logo -->
        <div>
            <a href="{{ url('/') }}">
                <img src="/logo.svg" alt="Logo" class="h-9 w-auto">
            </a>
        </div>
        <!-- Navigation Links -->
        <div class="space-x-4">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
            <a href="{{ route('profile') }}" class="text-blue-600 hover:underline">Profile</a>
            <a href="{{ url('/map') }}" class="text-blue-600 hover:underline">Map</a>
            <a href="{{ url('/recommendations') }}" class="text-blue-600 hover:underline">Recommendations</a>
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline">Blog</a>
        </div>
        <!-- Language Switcher (optional, if you want it in the header) -->
        <div>
            <form action="{{ route('language.change') }}" method="POST">
                @csrf
                <select name="locale" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                    <option value="lt" {{ app()->getLocale() === 'lt' ? 'selected' : '' }}>Lietuvių</option>
                </select>
            </form>
        </div>
    </div>
</nav>

