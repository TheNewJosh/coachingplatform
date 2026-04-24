<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => \Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send Email (Customizing this for our premium feel)
        try {
            Mail::send('emails.password_reset', ['token' => $token, 'email' => $request->email], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Your Password - CoachingFlow');
            });
        } catch (\Exception $e) {
            \Log::error('Password reset mail failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send reset link. Please try again later.']);
        }

        return back()->with('status', 'We have e-mailed your password reset link!');
    }
}
