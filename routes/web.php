<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TravelOptionsController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MapController;  
use App\Http\Controllers\AiTripController;

use App\Http\Controllers\TripGeneratorController;

// Home page
Route::get('/', fn() => redirect()->route('dashboard'));

// AI Test
Route::get('/ai-test', [AIController::class, 'test']);

// Trip Generator page
Route::get('trip-generator', [AiTripController::class, 'index'])
     ->name('trip-generator.show');

Route::post('trip-generator', [AiTripController::class, 'generate'])
     ->name('trip-generator.generate');

// Dashboard page 
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Footer routes
Route::view('/about',   'static.about'  )->name('static.about');
Route::view('/terms',   'static.terms'  )->name('static.terms');
Route::view('/privacy', 'static.privacy')->name('static.privacy');
Route::view('/contact', 'static.contact')->name('static.contact');
    
// Language change route
Route::post('/language-change', function (Illuminate\Http\Request $request) {
    session(['locale' => $request->input('locale', 'en')]);
    return back();
})->name('language.change');

// Currency
Route::post('/currency/change', function(Request $r){
    $r->validate(['currency'=>'in:USD,EUR,GBP,JPY,AUD,CAD,CHF,CNY']);
    session(['currency'=>$r->currency]);
    return back()->withInput();
})->name('currency.change');

// Map page
Route::get('/map', [MapController::class, 'index'])
     ->name('map');

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
