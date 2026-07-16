<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim (simulasi) kode OTP ke email user.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email tidak ditemukan dalam sistem kami.');
        }

        // Generate OTP 4 digit (untuk demo; pada produksi kirim via email).
        $otp = random_int(1000, 9999);

        session([
            'otp' => (string) $otp,
            'otp_email' => $request->email,
            'otp_expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        return redirect()->route('verify.otp')
            ->with('success', 'Kode OTP telah dibuat. Untuk keperluan demo, kode OTP Anda adalah: ' . $otp);
    }
}
