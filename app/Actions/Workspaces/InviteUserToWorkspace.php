<?php

namespace App\Actions\Workspaces;

class InviteUserToWorkspace
{
    public function execute(\App\Models\Workspace $workspace, string $email, string $role = 'member')
    {
        $user = \App\Models\User::where('email', $email)->first();

        if (! $user) {
            // Lógica para invitar a un usuario no registrado
            // Implementar según necesidad
            return null;
        }

        $workspace->users()->attach($user->id, ['role' => $role]);

        return $user;
    }
}
