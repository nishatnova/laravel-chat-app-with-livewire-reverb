<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(UserController::class)->group(function(){
    Route::get('dashboard', 'index')->name('dashboard')->middleware(['auth', 'verified']);
    Route::get('chat/{id}', 'userChat')->name('chat');
});

// Route::view('dashboard', 'dashboard')
    
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
