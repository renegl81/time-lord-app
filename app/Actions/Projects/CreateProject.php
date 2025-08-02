<?php

namespace App\Actions\Projects;

class CreateProject
{
    public function execute(array $data, \App\Models\Workspace $workspace)
    {
        return $workspace->projects()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'client_id' => $data['client_id'] ?? null,
            'hourly_rate' => $data['hourly_rate'] ?? null,
            'estimate' => $data['estimate'] ?? null,
            'budget' => $data['budget'] ?? null,
            'color' => $data['color'] ?? null,
            'is_billable' => $data['is_billable'] ?? true,
            'is_public' => $data['is_public'] ?? true,
        ]);
    }
}
