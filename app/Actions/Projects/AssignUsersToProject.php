<?php

namespace App\Actions\Projects;

class AssignUsersToProject
{
    public function execute(\App\Models\Project $project, array $userIds)
    {
        $project->users()->sync($userIds, false);

        return $project->users;
    }
}
