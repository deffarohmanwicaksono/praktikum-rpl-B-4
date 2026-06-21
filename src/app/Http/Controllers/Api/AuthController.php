<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user dan kembalikan token Sanctum.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|ends_with:@student.uns.ac.id',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.ends_with'   => 'Gunakan email SSO UNS (@student.uns.ac.id).',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = Auth::user();

        // Hanya buyer yang bisa login di aplikasi mobile (bukan admin)
        if ($user->isAdmin()) {
            return response()->json([
                'message' => 'Akun admin tidak dapat menggunakan aplikasi mobile.',
            ], 403);
        }

        // Hapus token lama agar tidak menumpuk
        $user->tokens()->delete();

        $token = $user->createToken('android-app')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token'   => $token,
            'user'    => [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'phone_number' => $user->phone_number,
                'status'       => $user->status,
                'roles'        => $user->roles ?? [],
                'created_at'   => $user->created_at?->toDateString(),
            ],
        ]);
    }

    /**
     * Logout — hapus token saat ini.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Ambil profil user yang sedang login.
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id'           => $user->id,
            'name'         => $user->name,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
            'status'       => $user->status,
            'roles'        => $user->roles ?? [],
            'created_at'   => $user->created_at?->toDateString(),
        ]);
    }
}
