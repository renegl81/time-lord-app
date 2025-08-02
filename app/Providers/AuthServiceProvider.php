<?php

namespace App\Providers;

use App\Models\Workspace;
use App\Policies\WorkspacePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Registrar políticas manualmente
        Gate::policy(Workspace::class, WorkspacePolicy::class);

        // Definir Gate global para administradores
        Gate::define('manage-system', fn ($user) => $user->isAdmin());
    }
}
