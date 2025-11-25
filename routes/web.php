<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// User pages - protected: requires authentication and user must NOT be admin
Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/garbage-schedule', [App\Http\Controllers\Client\ScheduleController::class, 'index'])->name('garbage-schedule');
    Route::post('/garbage-schedule/service-area', [App\Http\Controllers\Client\ScheduleController::class, 'updateServiceArea'])->name('garbage-schedule.service-area');
    Route::post('/garbage-schedule/notifications', [App\Http\Controllers\Client\ScheduleController::class, 'updateNotifications'])->name('garbage-schedule.notifications');

    Route::get('/tracker', [App\Http\Controllers\Client\TrackerController::class, 'index'])->name('tracker');
    Route::get('/tracker/data', [App\Http\Controllers\Client\TrackerController::class, 'getData'])->name('tracker.data.client');
    Route::get('/tracker/{truck}/route-history', [App\Http\Controllers\Client\TrackerController::class, 'routeHistory'])->name('tracker.route-history.client');

    Route::get('/notifications', [App\Http\Controllers\Client\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Client\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/preferences', [App\Http\Controllers\Client\NotificationController::class, 'updatePreferences'])->name('notifications.preferences');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\Client\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\Client\NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/community-reports', [App\Http\Controllers\Client\CommunityReportController::class, 'index'])->name('community-reports');

    Route::get('/settings', function () {
        return view('settings', ['activePage' => 'settings']);
    })->name('settings');

    Route::get('/profile', function () {
        return view('profile', ['activePage' => 'profile']);
    })->name('profile');

    // Report feed interactions
    Route::post('/reports', [App\Http\Controllers\Client\ReportFeedController::class, 'store'])->name('reports.store');
    Route::post('/reports/{report}/like', [App\Http\Controllers\Client\ReportFeedController::class, 'toggleLike'])->name('reports.like');
    Route::post('/reports/{report}/comment', [App\Http\Controllers\Client\ReportFeedController::class, 'storeComment'])->name('reports.comment');
    Route::get('/reports/{report}', [App\Http\Controllers\Client\CommunityReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/follow', [App\Http\Controllers\Client\ReportFeedController::class, 'toggleFollow'])->name('reports.follow');
});

// Profile management routes - only for regular users (not admins)
Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin pages - protected: requires authentication and user MUST be admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users');
    Route::put('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('users.destroy');

    // Reports Management
    Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports');
    Route::post('/reports/{id}/resolve', [App\Http\Controllers\Admin\ReportsController::class, 'resolve'])->name('reports.resolve');
    Route::post('/reports/{id}/reject', [App\Http\Controllers\Admin\ReportsController::class, 'reject'])->name('reports.reject');

    // Schedule Management
    Route::get('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedule.destroy');

    // Tracker / Truck Management
    Route::get('/tracker', [App\Http\Controllers\Admin\TrackerController::class, 'index'])->name('tracker');
    Route::post('/tracker', [App\Http\Controllers\Admin\TrackerController::class, 'store'])->name('tracker.store');
    Route::put('/tracker/{id}', [App\Http\Controllers\Admin\TrackerController::class, 'update'])->name('tracker.update');
    Route::delete('/tracker/{id}', [App\Http\Controllers\Admin\TrackerController::class, 'destroy'])->name('tracker.destroy');
    Route::post('/tracker/{id}/location', [App\Http\Controllers\Admin\TrackerController::class, 'updateLocation'])->name('tracker.update-location');
    Route::get('/tracker/data', [App\Http\Controllers\Admin\TrackerController::class, 'getData'])->name('tracker.data');
    Route::get('/tracker/{id}/route-history', [App\Http\Controllers\Admin\TrackerController::class, 'getRouteHistory'])->name('tracker.route-history');

    // Settings Management
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/password', [App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/notifications', [App\Http\Controllers\Admin\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
});

require __DIR__.'/auth.php';
