<!-- resources/views/MailView.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email View</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 , th {
            color: #07680eb9;
        }

    </style>
</head>
<body>
    <div class="order-details">
        <h1>Hello</h1>
        <p> Your request proceed successfully : {{ $data['code'] }}</p>
        <p>Thanks for your message!</p>
    </div>
</body>
</html>
