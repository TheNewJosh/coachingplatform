<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Outfit', sans-serif; color: #1e293b; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px; background: #f8fafc; border-radius: 20px; }
        .header { text-align: center; margin-bottom: 40px; }
        .content { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 12px 30px; background: #6366f1; color: white !important; text-decoration: none; border-radius: 10px; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; color: #64748b; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #6366f1; margin: 0;">CoachingFlow</h1>
        </div>
        <div class="content">
            <h2 style="margin-top: 0;">Hello, {{ $user->name }}!</h2>
            <p>Welcome to <strong>CoachingFlow</strong>! We're thrilled to have you join our community of growth-minded individuals.</p>
            <p>Your account has been successfully created. You can now explore our courses and start your learning journey at your own pace.</p>
            <a href="{{ url('/login') }}" class="btn">Login to Your Dashboard</a>
            <p style="margin-top: 30px;">If you have any questions, just reply to this email. We're here to help!</p>
            <p>Best regards,<br>The CoachingFlow Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CoachingFlow. All rights reserved.
        </div>
    </div>
</body>
</html>
