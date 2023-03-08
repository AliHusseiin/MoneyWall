<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #444444;
        }
        h1 {
            font-size: 24px;
            margin-top: 0;
        }
        p {
            margin-bottom: 1em;
        }
        a {
            display: inline-block;
            background-color: #0066CC;
            color: #FFFFFF;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 1em;
        }
        a:hover {
            background-color: #004EAD;
        }
    </style>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>Dear {{ $userFirstName }} {{ $userLastName }},</p>
    <p>We received a request to reset your password for your account. If you didn't make this request, you can ignore
        this email.</p>
    <p>Link will expire in 60 minutes.</p>
    <p>To reset your password, click the button below:</p>
    <a href="{{ $URL }}">Reset Password</a>
    <p>If the button above doesn't work, you can copy and paste the URL below into your web browser:</p>
    <p>{{ $URL }}</p>
    <p>Thank you,</p>
    <p>MoneyWall Team</p>
</body>
</html
