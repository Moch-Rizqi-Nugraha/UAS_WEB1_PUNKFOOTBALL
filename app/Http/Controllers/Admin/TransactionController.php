<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'event'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        // Calculate statistics
        $totalRevenue = Transaction::where('status', 'completed')->sum('amount');
        $monthlyRevenue = Transaction::completed()->thisMonth()->sum('amount');
        $pendingTransactions = Transaction::where('status', 'pending')->count();

        return view('admin.transactions.index', compact(
            'transactions',
            'totalRevenue',
            'monthlyRevenue',
            'pendingTransactions'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'event']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,cancelled,refunded'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }
}
