<?php

namespace App\Actions\Workspaces;

use App\Models\Workspace;

class CreateWorkspace
{
    public function execute(array $data, \App\Models\User $user)
    {
        $workspace = Workspace::create([
            'name' => $data['name'],
            'hourly_rate' => $data['hourly_rate'] ?? null,
            'currency' => $data['currency'] ?? 'EUR',
        ]);

        // Asigna al creador como administrador
        $workspace->users()->attach($user->id, ['role' => 'admin']);

        return $workspace;
    }
}
