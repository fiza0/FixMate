<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FixMate</title>
    <style>
        /* General Reset */
        body, html { margin: 0; padding: 0; width: 100%; background-color: #f4f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
        a { color: #007bff; text-decoration: none; }
        p { margin: 0 0 15px; }

        /* Container */
        .container { max-width: 600px; margin: 30px auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

        /* Header */
        h1 { color: #333; font-size: 24px; margin-bottom: 20px; }

        /* Button */
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        .footer { margin-top: 30px; font-size: 12px; color: #999; text-align: center; line-height: 1.4; }

        /* Responsive */
        @media (max-width: 640px) {
            .container { padding: 20px; margin: 20px; }
            h1 { font-size: 20px; }
            .button { width: 100%; padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to FixMate, {{ $user->name }}!</h1>

        <p>Thank you for registering with FixMate. We're thrilled to have you join our community of homeowners and skilled handymen.</p>

        <p>Before you can start using your account, please verify your email address by clicking the button below:</p>

        <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>

        <p>If the button doesn't work, copy and paste this link into your browser:</p>
        <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>

        <p>With FixMate, you can easily find and book reliable handymen for all your home repair and maintenance needs.</p>

        <p>Get started by exploring available services and booking your first appointment.</p>

        <p>If you have any questions, feel free to contact our support team anytime.</p>

        <div class="footer">
            <p>Best regards,<br>
            The FixMate Team</p>
        </div>
    </div>
</body>
</html>
