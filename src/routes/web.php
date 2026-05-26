<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login');

Route::view('/index', 'home.index');

Route::post('/login', function () {

    $credentials = request()->validate([

        'email' => [
            'required',
            'email',
            'ends_with:@student.uns.ac.id'
        ],

        'password' => [
            'required'
        ]

    ], [

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.ends_with' => 'Gunakan email SSO UNS.',

        'password.required' => 'Password wajib diisi.'

    ]);

    if (Auth::attempt($credentials)) {

        request()->session()->regenerate();

        return redirect('/index');
    }

    return back()->withErrors([
        'login' => 'Email atau password salah.'
    ]);

})->name('login.process');