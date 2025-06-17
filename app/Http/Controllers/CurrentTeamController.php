<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrentTeamController extends Controller
{
    /**
     * Update the user's current team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
        ]);

        $team = Team::findOrFail($request->team_id);

        if (! Auth::user()->belongsToTeam($team)) {
            return back()->withErrors(['team_id' => 'You do not belong to this team.']);
        }

        $user = Auth::user();
        $user->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        return back()->with('status', 'team-switched');
    }
}
