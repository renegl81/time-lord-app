<?php

namespace App\Actions\TimeEntries;

use Carbon\Carbon;

class StopTimeEntry
{
    public function execute(\App\Models\TimeEntry $timeEntry)
    {
        $now = now();
        $timeEntry->update([
            'end_time' => $now,
            'duration' => Carbon::parse($timeEntry->start_time)->diffInSeconds($now),
        ]);

        return $timeEntry;
    }
}
