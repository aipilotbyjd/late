<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamMemberController extends Controller
{
    /**
     * Store a newly created team invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $team = Auth::user()->currentTeam;

        // For now, we'll assume only the owner can invite.
        if (! Auth::user()->ownsTeam($team)) {
            return back()->withErrors(['email' => 'You do not have permission to invite members to this team.']);
        }

        // Check if a user with this email is already on the team
        $user = User::where('email', $request->email)->first();
        if ($user && $team->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['email' => 'This user is already a member of the team.']);
        }

        // Check if an invitation has already been sent to this email
        if ($team->invitations()->where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'An invitation has already been sent to this email address.']);
        }

        // Create the invitation
        $team->invitations()->create([
            'email' => $request->email,
            'token' => Str::random(40),
        ]);

        return back()->with('status', 'invitation-sent');
    }

    /**
     * Update the given team member's role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $team = Auth::user()->currentTeam;

        if (! Auth::user()->ownsTeam($team)) {
            return back(403);
        }

        $request->validate([
            'role' => ['required', 'string', Rule::in(['admin', 'member'])],
        ]);

        $team->users()->updateExistingPivot($user->id, [
            'role' => $request->role,
        ]);

        return back()->with('status', 'team-member-role-updated');
    }

    /**
     * Remove the given user from the team.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $team = Auth::user()->currentTeam;

        if (! Auth::user()->ownsTeam($team)) {
            return back(403);
        }

        if (Auth::user()->id === $user->id) {
            return back()->with('error', 'You cannot remove yourself from the team.');
        }

        $team->users()->detach($user->id);

        return back()->with('status', 'team-member-removed');
    }
}
