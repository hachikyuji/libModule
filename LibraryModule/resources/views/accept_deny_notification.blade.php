<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLM Library - Request Status Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        h1 {
            color: #007bff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
    </style>
</head>
<body>
    <div class="header">
        <img src="https://imgur.com/A4JsCCo.png" alt="PLM Logo">
    </div>
    <div class="content">
        <h1>PLM Library - Request Status</h1>
        
        @if ($request_status === 'Approved')
            @if ($request_type === 'Check In')
                <p>Your check-in request for "{{ $title }}" has been accepted. You can proceed with your transaction.</p>
            @elseif ($request_type === 'Check Out')
                <p>Your check-out request for "{{ $title }}" has been accepted. You can proceed with your transaction.</p>
            @else
                <p>Your request for "{{ $title }}" has been accepted. You can proceed with your transaction.</p>
            @endif
        @elseif ($request_status === 'Denied')
            @if ($request_type === 'Check In')
                <p>Unfortunately, your check-in request for "{{ $title }}" has been denied.</p>
            @elseif ($request_type === 'Check Out')
                <p>Unfortunately, your check-out request for "{{ $title }}" has been denied.</p>
            @else
                <p>Unfortunately, your request for "{{ $title }}" has been denied.</p>
            @endif
        @else
            <p>Your request status for "{{ $title }}" is {{ $request_status }}.</p>
        @endif

        <p>Thank you for using PLM Library services.</p>
    </div>
</body>
</html>
