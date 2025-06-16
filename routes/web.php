<?php

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/login', function () {
    return Inertia::render('auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('auth/Register');
})->name('register');

Route::get('/forgot-password', function () {
    return Inertia::render('auth/ForgotPassword');
})->middleware('guest')->name('password.request');


Route::get('/reset-password/{token}', function (Request $request, $token) {
    return Inertia::render('ResetPassword', [
        'token' => $token,
        'email' => $request->email,
    ]);
})->middleware('guest')->name('password.reset');

Route::get('/email/verify', function () {
    return Inertia::render('VerifyEmail');
})->middleware(['auth'])->name('verification.notice');

Route::get('/two-factor-challenge', function () {
    return Inertia::render('TwoFactorChallenge');
})->middleware(['guest'])->name('two-factor.login');


