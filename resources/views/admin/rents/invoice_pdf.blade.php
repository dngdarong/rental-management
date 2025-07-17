<!DOCTYPE html>
<html>
<head>
    <title>Rent Invoice - {{ $rent->id }}</title>
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Use Inter font if available, or a generic sans-serif */
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #4f46e5; /* Indigo color */
        }
        .header p {
            font-size: 14px;
            margin: 5px 0 0;
            color: #666;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .invoice-details div {
            width: 48%;
            vertical-align: top;
        }
        .invoice-details p {
            margin: 0;
        }
        .invoice-details strong {
            font-weight: bold;
        }
        .table-container {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
            font-weight: bold;
            color: #555;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-section p {
            font-size: 16px;
            margin: 5px 0;
        }
        .total-section strong {
            font-size: 18px;
            color: #4f46e5;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #888;
        }
    </style>
    <!-- Include Inter font from Google Fonts for PDF rendering if possible -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rent Invoice</h1>
            <p>{{ $app_name }}</p>
            <p>Date: {{ $current_date }}</p>
        </div>

        <div class="invoice-details">
            <div>
                <p><strong>Invoice ID:</strong> #INV-{{ $rent->id }}</p>
                <p><strong>Rent Month:</strong> {{ $rent->month->format('F Y') }}</p>
                <p><strong>Due Date:</strong> {{ $rent->due_date->format('M d, Y') }}</p>
                <p><strong>Status:</strong> {{ $rent->status }}</p>
            </div>
            <div>
                <p><strong>Tenant Name:</strong> {{ $rent->tenant->full_name }}</p>
                <p><strong>Tenant Phone:</strong> {{ $rent->tenant->phone }}</p>
                <p><strong>Tenant Email:</strong> {{ $rent->tenant->email ?? 'N/A' }}</p>
                <p><strong>Room Number:</strong> {{ $rent->room->room_number }}</p>
                <p><strong>Room Type:</strong> {{ $rent->room->roomType->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monthly Rent for Room {{ $rent->room->room_number }} ({{ $rent->month->format('F Y') }})</td>
                        <td>${{ number_format($rent->amount, 2) }}</td>
                    </tr>
                    @if($rent->status == 'Partial')
                        <tr>
                            <td>Amount Paid (so far)</td>
                            <td>${{ number_format($rent->payments->sum('amount'), 2) }}</td>
                        </tr>
                        <tr>
                            <td>Remaining Due</td>
                            <td>${{ number_format($rent->amount - $rent->payments->sum('amount'), 2) }}</td>
                        </tr>
                    @endif
                    @if($rent->paid_at)
                        <tr>
                            <td>Paid On</td>
                            <td>{{ $rent->paid_at->format('M d, Y H:i A') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <p><strong>Total Due: ${{ number_format($rent->amount, 2) }}</strong></p>
        </div>

        <div class="footer">
            <p>Thank you for your payment.</p>
            <p>&copy; {{ date('Y') }} {{ $app_name }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
