<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TeamInvitationController extends Controller
{
    /**
     * Display the invitation acceptance page.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Inertia\Response
     */
    public function show(Invitation $invitation)
    {
        return Inertia::render('Invitations/Show', [
            'invitation' => $invitation->load('team'),
        ]);
    }

    /**
     * Accept a team invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Invitation $invitation)
    {
        $user = Auth::user();

        if (! $user) {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ])->validate();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
        }

        $team = $invitation->team;

        // Add the user to the team with a default role (e.g., 'member')
        $team->users()->attach($user->id, ['role' => 'member']);

        // Set the user's current team if they don't have one
        if (is_null($user->current_team_id)) {
            $user->forceFill(['current_team_id' => $team->id])->save();
        }

        // Delete the invitation
        $invitation->delete();

        return redirect()->route('dashboard')->with('status', 'invitation-accepted');
    }

    /**
     * Cancel a pending team invitation.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invitation $invitation)
    {
        if (! Auth::user()->ownsTeam($invitation->team)) {
            return back(403);
        }

        $invitation->delete();

        return back()->with('status', 'invitation-cancelled');
    }
}
