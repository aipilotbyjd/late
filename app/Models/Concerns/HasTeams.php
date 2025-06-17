<?php

namespace App\Models\Concerns;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 */
trait HasTeams
{
    /**
     * Get the user's current team.
     */
    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    /**
     * The teams that the user belongs to.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->withPivot('role')->withTimestamps();
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsTeam(Team $team): bool
    {
        return $this->id === $team->created_by;
    }

    /**
     * Determine if the user has the given role on the given team.
     */
    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teams()->where('team_id', $team->id)->where('role', $role)->exists();
    }

    /**
     * Determine if the user is on the given team.
     */
    public function isCurrentTeam(Team $team): bool
    {
        return $this->current_team_id === $team->id;
    }

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToTeam(Team $team): bool
    {
        return $this->teams()->where('team_id', $team->id)->exists();
    }
}
