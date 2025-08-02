<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WorkspaceAccess
{
    public function handle(Request $request, Closure $next)
    {
        $workspace = $request->route('workspace');

        if ($request->user() && $workspace && ! $workspace->users->contains($request->user())) {
            return redirect()->route('workspaces.index')
                ->with('error', 'No tienes acceso a este espacio de trabajo.');
        }

        return $next($request);
    }
}
