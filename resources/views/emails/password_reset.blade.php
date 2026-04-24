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
            <h2 style="margin-top: 0;">Reset Your Password</h2>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>Click the button below to set a new password:</p>
            <a href="{{ url('password/reset/'.$token.'?email='.$email) }}" class="btn">Reset Password</a>
            <p style="margin-top: 30px;">This password reset link will expire in 60 minutes.</p>
            <p>If you did not request a password reset, no further action is required.</p>
            <p>Best regards,<br>The CoachingFlow Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CoachingFlow. All rights reserved.
        </div>
    </div>
</body>
</html>
