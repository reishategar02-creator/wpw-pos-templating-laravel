<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EmailController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Contoh pembuatan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Kirim email selamat datang
        Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json(['message' => 'Email dikirim!']);
    }

    public function test()
    {
        // Route untuk mempermudah testing kirim email langsung via browser
        $user = auth()->user() ?? User::first() ?? (object)[
            'name' => 'Pengguna Uji Coba',
            'email' => 'test@example.com',
        ];

        Mail::to($user->email)->send(new WelcomeMail($user));

        return response()->json([
            'message' => 'Email dikirim!',
            'recipient' => $user->email,
            'info' => 'Email telah dicatat pada file log (MAIL_MAILER=log). Silakan cek file storage/logs/laravel.log'
        ]);
    }
}
