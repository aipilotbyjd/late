<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => Inertia::render('auth/Login'))->name('login');
    Route::get('/register', fn() => Inertia::render('auth/Register'))->name('register');
    Route::get('/forgot-password', fn() => Inertia::render('auth/ForgotPassword'))->name('password.request');
    Route::get('/reset-password/{token}', fn($token, Request $request) => Inertia::render('auth/ResetPassword', [
        'token' => $token,
        'email' => $request->email,
    ]))->name('password.reset');
    Route::get('/two-factor-challenge', fn() => Inertia::render('auth/TwoFactorChallenge'))->name('two-factor.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => Inertia::render('auth/VerifyEmail'))->name('verification.notice');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
