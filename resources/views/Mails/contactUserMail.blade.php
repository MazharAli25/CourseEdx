<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <p>Hi {{ $data['name'] }},</p>

    <p>Thank you for contacting us. We’ve received your message and will get back to you shortly.</p>

    <p><strong>Your Message:</strong></p>
    <p>{{ $data['message'] }}</p>

    <p>Best regards,<br>Your CourseEdx Team</p>

</body>

</html>
