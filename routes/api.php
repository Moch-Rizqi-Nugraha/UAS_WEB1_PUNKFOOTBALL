<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User API Routes
Route::middleware('auth:sanctum')->prefix('user')->name('api.user.')->group(function () {
    // User Dashboard Data
    Route::get('/dashboard', [UserController::class, 'dashboardApi'])->name('dashboard');
    Route::get('/events', [UserController::class, 'eventsApi'])->name('events');
    Route::get('/tickets', [UserController::class, 'ticketsApi'])->name('tickets');
    Route::get('/marketplace', [UserController::class, 'marketplaceApi'])->name('marketplace');
    
    // Join/Leave Event
    Route::post('/events/{event}/join', [UserController::class, 'joinEvent'])->name('events.join');
    Route::post('/events/{event}/leave', [UserController::class, 'leaveEvent'])->name('events.leave');
    Route::post('/events/{event}/buy-ticket', [UserController::class, 'buyTicket'])->name('events.buy-ticket');
});

// Admin API Routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->name('api.admin.')->group(function () {
    // User Management
    Route::get('/users', [AdminUserController::class, 'indexApi'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'showApi'])->name('users.show');
    Route::get('/users/{user}/activities', [AdminUserController::class, 'userActivitiesApi'])->name('users.activities');
    
    // Event Management
    Route::get('/events', [AdminEventController::class, 'indexApi'])->name('events.index');
    Route::get('/events/{event}', [AdminEventController::class, 'showApi'])->name('events.show');
    Route::get('/events/{event}/participants', [AdminEventController::class, 'participantsApi'])->name('events.participants');
    Route::patch('/events/{event}/participants/{participant}/status', [AdminEventController::class, 'updateParticipantStatusApi'])->name('events.participant.status');
});

