<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Report - PunkFootball</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { color: #333; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PunkFootball - Events Report</h1>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>Total Events: {{ $events->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Location</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->category ?? 'General' }}</td>
                <td>{{ $event->date ? $event->date->format('M j, Y') : 'TBD' }}</td>
                <td>{{ $event->location ?? 'TBD' }}</td>
                <td>{{ $event->status ?? 'Active' }}</td>
                <td>{{ $event->created_at->format('M j, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by PunkFootball Admin System</p>
    </div>
</body>
</html>