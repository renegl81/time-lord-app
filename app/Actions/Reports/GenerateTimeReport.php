<?php

namespace App\Actions\Reports;

class GenerateTimeReport
{
    public function execute(\App\Models\Workspace $workspace, array $filters)
    {
        $query = \App\Models\TimeEntry::query()
            ->join('users', 'time_entries.user_id', '=', 'users.id')
            ->join('user_workspace', 'users.id', '=', 'user_workspace.user_id')
            ->where('user_workspace.workspace_id', $workspace->id)
            ->whereNotNull('time_entries.end_time');

        // Aplicar filtros
        if (! empty($filters['start_date'])) {
            $query->where('time_entries.date', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->where('time_entries.date', '<=', $filters['end_date']);
        }

        if (! empty($filters['user_id'])) {
            $query->where('time_entries.user_id', $filters['user_id']);
        }

        if (! empty($filters['project_id'])) {
            $query->where('time_entries.project_id', $filters['project_id']);
        }

        if (! empty($filters['client_id'])) {
            $query->join('projects', 'time_entries.project_id', '=', 'projects.id')
                ->where('projects.client_id', $filters['client_id']);
        }

        return $query->get();
    }
}
