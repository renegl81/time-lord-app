<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkspacePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user, Workspace $workspace): bool
    {
        return $user->belongsToWorkspace($workspace);
    }

    public function create(User $user): true
    {
        return true; // Todos pueden crear workspaces
    }

    public function update(User $user, Workspace $workspace): bool
    {
        return $user->isWorkspaceAdmin($workspace);
    }

    public function delete(User $user, Workspace $workspace): bool
    {
        return $user->isWorkspaceAdmin($workspace);
    }

    public function invite(User $user, Workspace $workspace): bool
    {
        return $user->isWorkspaceAdmin($workspace);
    }

    public function manageUsers(User $user, Workspace $workspace): bool
    {
        return $user->isWorkspaceAdmin($workspace);
    }
}
