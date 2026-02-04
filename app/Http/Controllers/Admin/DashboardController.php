<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Product;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // User Statistics
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = User::where('role', 'user')->count();

        // Event Statistics
        $totalEvents = Event::count();
        $activeEvents = Event::where('status', 'active')->count();
        $totalParticipants = EventParticipant::count();

        // Ticket Statistics
        $totalTickets = Ticket::count();
        $availableTickets = Ticket::where('status', 'available')->count();
        $usedTickets = Ticket::where('status', 'used')->count();
        $ticketRevenue = Ticket::sum('price');

        // Product & Marketplace Statistics
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $completedTransactions = Transaction::where('status', 'completed')->sum('amount');
        $pendingTransactions = Transaction::where('status', 'pending')->sum('amount');

        // Recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_events = Event::latest()->take(5)->get();
        $recent_tickets = Ticket::with('user', 'event')->latest()->take(5)->get();
        $recent_transactions = Transaction::with('user')->latest()->take(5)->get();

        // Activity trends (last 7 days)
        $today = now();
        $sevenDaysAgo = now()->subDays(7);

        $daily_users = User::whereBetween('created_at', [$sevenDaysAgo, $today])
                          ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                          ->groupBy('date')
                          ->get();

        $daily_transactions = Transaction::whereBetween('transaction_date', [$sevenDaysAgo, $today])
                                        ->where('status', 'completed')
                                        ->selectRaw('DATE(transaction_date) as date, SUM(amount) as total')
                                        ->groupBy('date')
                                        ->get();

        $stats = [
            // Users
            'total_users' => $totalUsers,
            'total_admins' => $totalAdmins,
            'total_regular_users' => $totalRegularUsers,

            // Events
            'total_events' => $totalEvents,
            'active_events' => $activeEvents,
            'total_participants' => $totalParticipants,

            // Tickets
            'total_tickets' => $totalTickets,
            'available_tickets' => $availableTickets,
            'used_tickets' => $usedTickets,
            'ticket_revenue' => $ticketRevenue,

            // Marketplace
            'total_products' => $totalProducts,
            'total_transactions' => $totalTransactions,
            'completed_sales' => $completedTransactions,
            'pending_sales' => $pendingTransactions,
        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'recent_users',
            'recent_events',
            'recent_tickets',
            'recent_transactions',
            'daily_users',
            'daily_transactions'
        ));
    }
}
