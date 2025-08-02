<?php

namespace App\Actions\Tags;

class AssignTagsToTimeEntry
{
    public function execute(\App\Models\TimeEntry $timeEntry, array $tagIds)
    {
        $timeEntry->tags()->sync($tagIds, false);

        return $timeEntry->tags;
    }
}
