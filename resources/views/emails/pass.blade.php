<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Password</title>
</head>
<body>
    <div class="container">
        <h1>{{ $emailData['title'] }}</h1>
        <p>Dear {{ $emailData['name'] }},</p>
        <p>Thank you for register to our website. We're excited to share valuable information, updates, and special offers with you.</p>
        <p>{{ $emailData['body'] }}</p>
    </div>
</body>
</html>
