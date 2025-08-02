<?php

namespace App\Actions\TimeEntries;

use Carbon\Carbon;

class StartTimeEntry
{
    public function execute(\App\Models\User $user, array $data)
    {
        // Verificar si hay una entrada activa
        $activeEntry = $user->timeEntries()->whereNull('end_time')->first();
        if ($activeEntry) {
            throw new \Exception('Ya tienes una entrada de tiempo activa');
        }

        return $user->timeEntries()->create([
            'project_id' => $data['project_id'] ?? null,
            'task_id' => $data['task_id'] ?? null,
            'description' => $data['description'] ?? null,
            'start_time' => now(),
            'date' => Carbon::today(),
            'is_billable' => $data['is_billable'] ?? true,
        ]);
    }
}
