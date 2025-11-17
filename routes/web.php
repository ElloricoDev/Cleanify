<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// User pages - accessible without authentication for HTML conversion testing
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

// Profile management routes (keep auth for actual functionality)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', ['activePage' => 'dashboard']);
    })->name('dashboard');

    Route::get('/users', function () {
        return view('admin.users', ['activePage' => 'users']);
    })->name('users');

    Route::get('/reports', function () {
        return view('admin.reports', ['activePage' => 'reports']);
    })->name('reports');

    Route::get('/schedule', function () {
        return view('admin.schedule', ['activePage' => 'schedule']);
    })->name('schedule');

    Route::get('/tracker', function () {
        return view('admin.tracker', ['activePage' => 'tracker']);
    })->name('tracker');

    Route::get('/settings', function () {
        return view('admin.settings', ['activePage' => 'settings']);
    })->name('settings');
});

require __DIR__.'/auth.php';
