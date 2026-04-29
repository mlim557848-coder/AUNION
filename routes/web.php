<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AlumniDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminAlumniController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Alumni\AlumniEventController;
use App\Http\Controllers\Alumni\AlumniDonationController;

// ======================== TEMP MIGRATION ROUTE — DELETE AFTER USE ========================
Route::get('/run-setup-xyz999', function () {
    if (app()->environment('production')) {
        \Artisan::call('migrate', ['--force' => true]);
        return '<pre>' . \Artisan::output() . '</pre>';
    }
    return 'Not production';
});

// ======================== ROOT REDIRECT ========================
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('alumni.dashboard');
    }
    return redirect()->route('login');
})->name('welcome');

// ======================== AUTH ROUTES ========================
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',    [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/register',  [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/lookup-alumni', [RegisteredUserController::class, 'lookupAlumni'])->name('lookup.alumni');
});

Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ======================== ALUMNI ROUTES ========================
Route::middleware(['auth', 'alumni.approved'])->prefix('alumni')->name('alumni.')->group(function () {

    Route::get('/dashboard', [AlumniDashboardController::class, 'index'])->name('dashboard');

    // Profile — own profile
    Route::get('/profile',      [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',      [ProfileController::class, 'update'])->name('profile.update');

    // Profile — view another alumni's profile (from network page)
    Route::get('/profile/{user}', [ProfileController::class, 'showOther'])->name('profile.show');

    // Network
    Route::get('/network',                            [NetworkController::class, 'index'])->name('network');
    Route::post('/network/{user}/connect',            [NetworkController::class, 'connect'])->name('network.connect');
    Route::post('/network/{connection}/accept',       [NetworkController::class, 'accept'])->name('network.accept');
    Route::post('/network/{connection}/reject',       [NetworkController::class, 'reject'])->name('network.reject');
    Route::delete('/network/{connection}/disconnect', [NetworkController::class, 'disconnect'])->name('network.disconnect');

    // Events
    Route::get('/events',                 [AlumniEventController::class, 'index'])->name('events');
    Route::post('/events/{event}/rsvp',   [AlumniEventController::class, 'rsvp'])->name('events.rsvp');
    Route::delete('/events/{event}/rsvp', [AlumniEventController::class, 'cancelRsvp'])->name('events.cancel-rsvp');
    Route::post('/events/{event}/donate', [AlumniEventController::class, 'donate'])->name('events.donate');

    // Donations (general)
    Route::get('/donations',  [AlumniDonationController::class, 'index'])->name('donations');
    Route::post('/donations', [AlumniDonationController::class, 'store'])->name('donations.store');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
});

// ======================== ADMIN ROUTES ========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users',                  [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/approve',  [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject',   [AdminUserController::class, 'reject'])->name('users.reject');
    Route::post('/users/{user}/archive',  [AdminUserController::class, 'archive'])->name('users.archive');
    Route::post('/users/{user}/restore',  [AdminUserController::class, 'restore'])->name('users.restore');
    Route::get('/users/{user}/edit',      [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',           [AdminUserController::class, 'update'])->name('users.update');

    // Alumni Records
    Route::get('/alumni-records',                   [AdminAlumniController::class, 'index'])->name('alumni-records.index');
    Route::get('/alumni-records/report',            [AdminAlumniController::class, 'report'])->name('alumni-records.report');
    Route::get('/alumni-records/export-pdf',        [AdminAlumniController::class, 'exportPdf'])->name('alumni-records.export-pdf');
    Route::get('/alumni-records/{user}',            [AdminAlumniController::class, 'show'])->name('alumni-records.show');
    Route::get('/alumni-records/{user}/export-pdf', [AdminAlumniController::class, 'exportSinglePdf'])->name('alumni-records.export-single-pdf');

    // Events
    Route::resource('events', AdminEventController::class);
    Route::get('events/{event}/attendees', [AdminEventController::class, 'attendees'])->name('events.attendees');
    Route::get('events/{event}/budget',    [AdminEventController::class, 'budget'])->name('events.budget');
    Route::post('events/{event}/budget',   [AdminEventController::class, 'setBudget'])->name('events.budget.set');

    // Donations
    Route::get('/donations',                     [AdminDonationController::class, 'index'])->name('donations.index');
    Route::post('/donations/{donation}/approve', [AdminDonationController::class, 'approve'])->name('donations.approve');
    Route::post('/donations/{donation}/reject',  [AdminDonationController::class, 'reject'])->name('donations.reject');
    Route::post('/donations/allocate',           [AdminDonationController::class, 'allocate'])->name('donations.allocate');

    // Announcements
    Route::resource('announcements', AdminAnnouncementController::class);
});