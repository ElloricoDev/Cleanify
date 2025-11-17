<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['activePage' => 'home']);
    })->name('dashboard');
    
    Route::get('/garbage-schedule', function () {
        return view('garbage-schedule', ['activePage' => 'schedule']);
    })->name('garbage-schedule');
    
    Route::get('/tracker', function () {
        return view('tracker', ['activePage' => 'tracker']);
    })->name('tracker');
    
    Route::get('/notifications', function () {
        return view('notifications', ['activePage' => 'notifications']);
    })->name('notifications');
    
    Route::get('/community-reports', function () {
        return view('community-reports', ['activePage' => 'reports']);
    })->name('community-reports');
    
    Route::get('/settings', function () {
        return view('settings', ['activePage' => 'settings']);
    })->name('settings');
    
    Route::get('/profile', function () {
        return view('profile', ['activePage' => 'profile']);
    })->name('profile');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
