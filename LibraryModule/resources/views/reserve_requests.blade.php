<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Reservation Notification</title>
    <style>
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
    </style>
</head>
<body>
    <div class="header">
        <img src="https://imgur.com/A4JsCCo.png" alt="PLM Logo">
    </div>
    <div class="content">
        <p>Hello,</p>
        <p>You have a day for your reservation of the book: "<span id="title">{{$title}}</span>" before it expires.</p>
        <p>Thank you!</p>
    </div>
</body>
</html>
