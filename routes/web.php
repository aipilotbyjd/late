<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\CurrentTeamController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TeamInvitationController;
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
    Route::get('/dashboard', function () {
    $user = Auth::user();
    $currentTeam = $user->currentTeam;
    $isOwner = false;

    if ($currentTeam) {
        $currentTeam->load('users', 'invitations');
        $isOwner = $user->ownsTeam($currentTeam);
    }

    return Inertia::render('Dashboard', [
        'teams' => $user->teams,
        'currentTeam' => $currentTeam,
        'isOwner' => $isOwner,
    ]);
})->name('dashboard');
    Route::get('/email/verify', fn() => Inertia::render('auth/VerifyEmail'))->name('verification.notice');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::resource('workflows', WorkflowController::class);
Route::resource('teams', TeamController::class)->only(['create', 'store']);
Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
Route::post('/team-members', [TeamMemberController::class, 'store'])->name('team-members.store');
Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy'])->name('team-invitations.destroy');
Route::put('/team-members/{user}', [TeamMemberController::class, 'update'])->name('team-members.update');
Route::delete('/team-members/{user}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');

Route::get('/team-invitations/{invitation:token}', [TeamInvitationController::class, 'show'])->middleware('guest')->name('team-invitations.show');
Route::post('/team-invitations/{invitation:token}', [TeamInvitationController::class, 'store'])->name('team-invitations.store');

