<?php

namespace App\Actions\Tasks;

class CreateTask
{
    public function execute(array $data, \App\Models\Project $project)
    {
        return $project->tasks()->create([
            'name' => $data['name'],
            'estimate' => $data['estimate'] ?? null,
            'hourly_rate' => $data['hourly_rate'] ?? null,
            'is_billable' => $data['is_billable'] ?? true,
        ]);
    }
}
