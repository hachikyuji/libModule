<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLM Library - Request Status Notification</title>
</head>
<body>
    <div>
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
