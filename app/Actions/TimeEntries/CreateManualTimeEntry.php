<?php

namespace App\Actions\TimeEntries;

class CreateManualTimeEntry
{
    public function execute(\App\Models\User $user, array $data)
    {
        $startTime = Carbon::parse($data['start_time']);
        $endTime = Carbon::parse($data['end_time']);

        return $user->timeEntries()->create([
            'project_id' => $data['project_id'] ?? null,
            'task_id' => $data['task_id'] ?? null,
            'description' => $data['description'] ?? null,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => $startTime->diffInSeconds($endTime),
            'date' => $startTime->toDateString(),
            'is_billable' => $data['is_billable'] ?? true,
            'hourly_rate' => $data['hourly_rate'] ?? null,
        ]);
    }
}
