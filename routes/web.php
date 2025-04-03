<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TravelOptionsController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationsController;

// Home page
Route::view('/', 'welcome');

// Dashboard page 
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Language change route
Route::post('/language-change', function (Request $request) {
    $locale = $request->input('locale', 'en');
    session(['locale' => $locale]);
    return redirect()->back();
})->name('language.change');

// Map page
Route::get('/map', function () {
    return view('map');
})->name('map');

// Recommendations page 
Route::get('/recommendations', [RecommendationsController::class, 'index'])->name('recommendations');


// Blog resource routes
Route::resource('blog', BlogController::class);

// Accommodation page 
Route::get('/accommodations', [AccommodationController::class, 'show'])->name('accommodations');

// Travel options page
Route::get('/travel-options', [TravelOptionsController::class, 'show'])->name('travel-options');

// Authentication routes
require __DIR__.'/auth.php';

// Profile routes 
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
