<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function requestOTP(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^[0-9]{10,11}$/',
        ]);

        // Generate a 6-digit OTP
        $otp = sprintf('%06d', mt_rand(100000, 999999));
        
        // Save OTP to session
        session(['otp' => $otp, 'phone_number' => $request->phone_number]);
        
        // In a real app, you would send this via SMS
        // For now, we'll just return it for testing
        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
            'debug_otp' => $otp, // Remove in production
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|size:6',
        ]);

        $sessionOtp = session('otp');
        $phoneNumber = session('phone_number');

        if (!$sessionOtp || $request->otp != $sessionOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 422);
        }

        // Check if user exists
        $user = User::where('phone_number', $phoneNumber)->first();

        if (!$user) {
            // Create new user
            $user = User::create([
                'phone_number' => $phoneNumber,
                'name' => 'User ' . substr($phoneNumber, -4),
                'referral_code' => strtoupper(Str::random(6)),
                'password' => Hash::make(Str::random(16)),
            ]);
        }

        // Login user
        Auth::login($user, true);
        
        // Clear OTP from session
        session()->forget(['otp', 'phone_number']);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'redirect' => route('dashboard'),
        ]);
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }
}








