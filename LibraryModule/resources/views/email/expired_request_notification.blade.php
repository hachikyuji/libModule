<!DOCTYPE html>
<html>
<head>
    <title>Expired Requests Notification</title>
</head>
<body>
    <p>Hello,</p>

    <p>The following requests are expiring soon:</p>

    <ul>
        @foreach ($expiredRequests as $expiredRequest)
            <li>{{ $expiredRequest->book_request }} - Expiration Time: {{ $expiredRequest->expiration_time }}</li>
        @endforeach
    </ul>

    <p>Thank you!</p>
</body>
</html>