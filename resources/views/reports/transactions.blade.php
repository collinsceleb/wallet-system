<!DOCTYPE html>
<html>

<head>
    <title>Weekly Transactions Report</title>
    <style>
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
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Weekly Transactions Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->user_id }}</td>
                <td>{{ $transaction->type }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
