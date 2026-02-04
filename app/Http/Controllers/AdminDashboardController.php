<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Coach;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistics
        $totalUsers = User::count();
        $activeEvents = Event::active()->count();
        $totalCoaches = Coach::active()->count();
        $totalRevenue = Transaction::completed()->sum('amount');
        
        // Pending participants
        $pendingParticipants = EventParticipant::pending()->get();
        
        // Recent activities
        $recentEvents = Event::latest()->limit(5)->get();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeEvents',
            'totalCoaches',
            'pendingParticipants',
            'totalRevenue',
            'recentEvents',
            'recentUsers'
        ));
    }
}
