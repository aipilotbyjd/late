<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeamController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Teams/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        $team = $user->ownedTeams()->create([
            'name' => $request->name,
        ]);

        // Attach user to the team with 'owner' role
        $user->teams()->attach($team->id, ['role' => 'owner']);

        // Switch to the new team
        $user->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        return back()->with('status', 'team-created');
    }
}
