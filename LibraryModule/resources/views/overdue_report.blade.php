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
            background-color: #060270;;
            color: white; 
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .header {
            background-color: #fff176;
            color: #000;
            padding: 20px;
            text-align: center;
        }
        .header img {
            height: 100px; 
            width: auto;
            margin-right: 10px;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin: 0;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://imgur.com/A4JsCCo.png" alt="PLM Logo">
    </div>
        <h1>PLM Library - Overdue Report</h1>
    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Book Borrowed</th>
                <th>Borrowed Date</th>
                <th>Book Deadline</th>
                <th>College</th>
                <th>Course</th>
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
                    <td>{{ $history->college }}</td>
                    <td>{{ $history->course }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
