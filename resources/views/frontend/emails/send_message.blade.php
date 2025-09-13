<!DOCTYPE html>
<html>
<head>
    <title>Thank you for contacting us</title>
</head>
<body>
    <h1>Hello, {{ $data['name'] }}</h1>
    <p>Thank you for reaching out to us.</p>
    <p>Here is a copy of your message:</p>

    <p><strong>Subject:</strong> {{ $data['subject'] ?? 'No subject' }}</p>
    <p><strong>Message:</strong><br>{{ $data['message'] ?? 'No message content' }}</p>

    <p>We will get back to you shortly.</p>
    <br>
    <p>Best Regards,<br>XPLabs</p>
</body>
</html>
