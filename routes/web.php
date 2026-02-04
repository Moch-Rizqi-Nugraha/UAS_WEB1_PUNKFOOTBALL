<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Google OAuth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public Event Routes
Route::get('/events', [\App\Http\Controllers\EventController::class, 'publicIndex'])->name('events.index');
Route::get('/events/{id}/register', [\App\Http\Controllers\EventController::class, 'register'])->name('events.register');

// Public Marketplace Routes
Route::get('/marketplace', [\App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/{id}', [\App\Http\Controllers\MarketplaceController::class, 'show'])->name('marketplace.show');
Route::post('/marketplace/{id}/buy', [\App\Http\Controllers\MarketplaceController::class, 'buy'])->middleware('auth')->name('marketplace.buy');

// Public Gallery Routes
Route::get('/galleries', [\App\Http\Controllers\GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galleries/category/{category}', [\App\Http\Controllers\GalleryController::class, 'byCategory'])->name('galleries.category');
Route::get('/galleries/{gallery}', [\App\Http\Controllers\GalleryController::class, 'show'])->name('galleries.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
                                Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
                            Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
                        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
                    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
                    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
                Route::resource('tickets', \App\Http\Controllers\Admin\TicketController::class);
            Route::get('roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
            Route::get('roles/{user}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit');
            Route::patch('roles/{user}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        // User activity tracking routes
        Route::get('users/{user}/events', [\App\Http\Controllers\Admin\UserController::class, 'viewEvents'])->name('users.events');
        Route::get('users/{user}/tickets', [\App\Http\Controllers\Admin\UserController::class, 'viewTickets'])->name('users.tickets');
        Route::get('users/{user}/transactions', [\App\Http\Controllers\Admin\UserController::class, 'viewTransactions'])->name('users.transactions');
        Route::patch('users/{user}/event-participation/{participation}', [\App\Http\Controllers\Admin\UserController::class, 'updateEventStatus'])->name('users.event-status');
        Route::delete('users/{user}/event-participation/{participation}', [\App\Http\Controllers\Admin\UserController::class, 'removeFromEvent'])->name('users.remove-event');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/users/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportUsersExcel'])->name('reports.users.excel');
    Route::get('/reports/events/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportEventsExcel'])->name('reports.events.excel');
    Route::get('/reports/transactions/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportTransactionsExcel'])->name('reports.transactions.excel');
    Route::get('/reports/users/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportUsersPdf'])->name('reports.users.pdf');
    Route::get('/reports/events/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportEventsPdf'])->name('reports.events.pdf');
    Route::get('/reports/transactions/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportTransactionsPdf'])->name('reports.transactions.pdf');
    Route::get('/search', [AdminController::class, 'search'])->name('search');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Event Management Routes
    Route::resource('events', EventController::class);
    Route::patch('events/{event}/toggle-status', [EventController::class, 'toggleStatus'])->name('events.toggle-status');
    Route::patch('events/{event}/participants/{participant}/status', [EventController::class, 'updateParticipantStatus'])->name('events.participants.update-status');
    
    // Admin Marketplace Management
    Route::get('marketplace', [\App\Http\Controllers\Admin\MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('marketplace/create', [\App\Http\Controllers\Admin\MarketplaceController::class, 'create'])->name('marketplace.create');
    Route::post('marketplace', [\App\Http\Controllers\Admin\MarketplaceController::class, 'store'])->name('marketplace.store');
    Route::get('marketplace/{id}', [\App\Http\Controllers\Admin\MarketplaceController::class, 'show'])->name('marketplace.show');
    Route::put('marketplace/{id}', [\App\Http\Controllers\Admin\MarketplaceController::class, 'update'])->name('marketplace.update');
});

// User Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/welcome', [UserController::class, 'welcome'])->name('welcome');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/events', [UserController::class, 'events'])->name('events');
    Route::post('/events/{event}/join', [UserController::class, 'joinEvent'])->name('events.join');
    Route::post('/events/{event}/leave', [UserController::class, 'leaveEvent'])->name('events.leave');
    Route::post('/events/{event}/buy-ticket', [UserController::class, 'buyTicket'])->name('events.buy-ticket');
    Route::get('/tickets', [UserController::class, 'tickets'])->name('tickets');
    Route::get('/marketplace', [UserController::class, 'marketplace'])->name('marketplace');
    Route::post('/marketplace/{product}/buy', [UserController::class, 'buyProduct'])->name('marketplace.buy');
});

require __DIR__.'/auth.php';
