<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #001f3f;
            color: white; 
        }
    </style>
</head>
<body>
    <h1>PLM Library - Overdue Report</h1>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Book Borrowed</th>
                <th>Borrowed Date</th>
                <th>Book Deadline</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overdueHistories as $history)
                <tr>
                    <td>{{ $history->email }}</td>
                    <td>{{ $history->user_name }}</td>
                    <td>{{ $history->books_borrowed }}</td>
                    <td>{{ $history->borrowed_date }}</td>
                    <td>{{ $history->book_deadline }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
