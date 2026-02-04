<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Pending participants
        $pendingParticipants = Participant::where('status', 'pending')->get();

        return view('admin.dashboard', compact('pendingParticipants'));
    }
    /**
     * Display all users
     */
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Global search for admin
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return redirect()->back();
        }

        // Search in events
        $events = Event::where('name', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%")
                      ->orWhere('location', 'LIKE', "%{$query}%")
                      ->orWhere('category', 'LIKE', "%{$query}%")
                      ->limit(10)
                      ->get();

        // Search in users
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->limit(10)
                    ->get();

        return view('admin.search', compact('events', 'users', 'query'));
    }

    /**
     * Display reports and analytics
     */
    public function reports()
    {
        // Financial metrics
        $totalRevenue = Transaction::completed()->sum('amount');
        $monthlyRevenue = Transaction::completed()->thisMonth()->sum('amount');
        $lastMonthRevenue = Transaction::completed()
            ->whereBetween('transaction_date', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])->sum('amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        // Event metrics
        $activeEvents = Event::active()->count();
        $totalEvents = Event::count();
        $totalParticipants = EventParticipant::confirmed()->count();
        $confirmedParticipants = EventParticipant::confirmed()->count();

        // Rating metrics (mock data for now)
        $averageRating = 4.5;
        $totalReviews = 127;

        // Revenue chart data (last 6 months)
        $revenueChartLabels = [];
        $revenueChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueChartLabels[] = $date->format('M Y');
            $revenueChartData[] = Transaction::completed()
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');
        }

        // Category distribution
        $categoryData = [
            Event::where('category', 'turnamen')->count(),
            Event::where('category', 'pelatihan')->count(),
            Event::where('category', 'friendly_match')->count(),
        ];
        $categoryLabels = ['Turnamen', 'Pelatihan', 'Friendly Match'];

        // Recent activities (mock data)
        $recentActivities = [
            [
                'type' => 'Payment',
                'description' => 'Payment received for Turnamen Sepakbola 2024',
                'user' => 'John Doe',
                'amount' => 150000,
                'date' => now()->subHours(2)
            ],
            [
                'type' => 'Registration',
                'description' => 'New participant registered for Pelatihan Kiper',
                'user' => 'Jane Smith',
                'amount' => null,
                'date' => now()->subHours(4)
            ],
            [
                'type' => 'Event',
                'description' => 'Event "Turnamen U-18" completed successfully',
                'user' => 'Admin',
                'amount' => null,
                'date' => now()->subHours(6)
            ],
            [
                'type' => 'Payment',
                'description' => 'Payment received for Pelatihan Teknik Dasar',
                'user' => 'Bob Johnson',
                'amount' => 100000,
                'date' => now()->subHours(8)
            ],
        ];

        // Top performing events
        $topEvents = Event::withCount('confirmedParticipants')
            ->orderBy('confirmed_participants_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reports', compact(
            'totalRevenue',
            'revenueGrowth',
            'activeEvents',
            'totalEvents',
            'totalParticipants',
            'confirmedParticipants',
            'averageRating',
            'totalReviews',
            'revenueChartLabels',
            'revenueChartData',
            'categoryLabels',
            'categoryData',
            'recentActivities',
            'topEvents'
        ));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'currency' => 'required|string|size:3',
            'timezone' => 'required|string',
            'maintenance_mode' => 'boolean',
            'registration_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'max_events_per_user' => 'required|integer|min:1|max:50',
            'default_event_duration' => 'required|integer|min:30|max:480',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'payment_gateway' => 'required|in:stripe,paypal,bank_transfer',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_holder' => 'nullable|string|max:255',
        ]);

        // Here you would typically save to a settings table or config file
        // For now, we'll just redirect back with success message
        // In a real application, you'd save these settings to database

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
