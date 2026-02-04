<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use App\Exports\EventsExport;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function exportUsersExcel()
    {
        return Excel::download(new UsersExport, 'users-report.xlsx');
    }

    public function exportEventsExcel()
    {
        return Excel::download(new EventsExport, 'events-report.xlsx');
    }

    public function exportTransactionsExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions-report.xlsx');
    }

    public function exportUsersPdf()
    {
        $users = \App\Models\User::select('id', 'name', 'email', 'role', 'created_at')->get();
        $pdf = Pdf::loadView('admin.reports.users-pdf', compact('users'));
        return $pdf->download('users-report.pdf');
    }

    public function exportEventsPdf()
    {
        $events = \App\Models\Event::select('id', 'name', 'description', 'event_date', 'location', 'category', 'status', 'price', 'max_participants', 'created_at')->get();
        $pdf = Pdf::loadView('admin.reports.events-pdf', compact('events'));
        return $pdf->download('events-report.pdf');
    }

    public function exportTransactionsPdf()
    {
        $transactions = \App\Models\Transaction::select('id', 'user_id', 'amount', 'status', 'transaction_date', 'created_at')->get();
        $pdf = Pdf::loadView('admin.reports.transactions-pdf', compact('transactions'));
        return $pdf->download('transactions-report.pdf');
    }
}
