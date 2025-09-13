<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Invoice / Payment Receipt</h2>
    </div>

    <div class="details">
        <p><strong>Payment ID:</strong> {{ $payment->payment_id }}</p>
        <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
        <p><strong>Amount:</strong> Rs {{ $payment->token_amount / 100 }}</p>
        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        <p><strong>Student:</strong> {{ $payment->student->user->name ?? 'N/A' }}</p>
        <p><strong>Course:</strong> {{ $payment->course->name ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount (Rs)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Course Token</td>
                <td>Rs {{ $payment->token_amount / 100 }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;">Thank you for your payment!</p>
</body>

</html>
