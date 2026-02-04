<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transactions Report - PunkFootball</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { color: #333; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        .summary { margin-bottom: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 5px; }
        .summary-item { display: inline-block; margin-right: 20px; }
        .summary-label { font-weight: bold; color: #333; }
        .summary-value { color: #007bff; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PunkFootball - Transactions Report</h1>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>Total Transactions: {{ $transactions->count() }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Revenue: </span>
            <span class="summary-value">${{ number_format($transactions->sum('amount'), 2) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Average Transaction: </span>
            <span class="summary-value">${{ $transactions->count() > 0 ? number_format($transactions->avg('amount'), 2) : '0.00' }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Produk</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                <td>{{ $transaction->product->name ?? '-' }}</td>
                <td>{{ $transaction->transaction_data['quantity'] ?? 1 }}</td>
                <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                <td>{{ $transaction->transaction_type ?? 'Purchase' }}</td>
                <td>{{ $transaction->status ?? 'Completed' }}</td>
                <td>{{ $transaction->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by PunkFootball Admin System</p>
    </div>
</body>
</html>