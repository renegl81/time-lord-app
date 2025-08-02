<?php

namespace App\Http\Controllers;

use App\Actions\Tags\AssignTagsToTimeEntry;
use App\Actions\TimeEntries\CreateManualTimeEntry;
use App\Actions\TimeEntries\StartTimeEntry;
use App\Actions\TimeEntries\StopTimeEntry;
use App\Models\TimeEntry;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimeEntryController extends Controller
{
    public function index(Request $request, Workspace $workspace)
    {
        $timeEntries = TimeEntry::query()
            ->join('users', 'time_entries.user_id', '=', 'users.id')
            ->join('user_workspace', 'users.id', '=', 'user_workspace.user_id')
            ->where('user_workspace.workspace_id', $workspace->id)
            ->where('time_entries.user_id', $request->user()->id)
            ->orderBy('time_entries.date', 'desc')
            ->orderBy('time_entries.start_time', 'desc')
            ->with(['project', 'task', 'tags'])
            ->paginate(15);

        return Inertia::render('TimeEntries/Index', [
            'workspace' => $workspace,
            'timeEntries' => $timeEntries,
            'projects' => $workspace->projects,
            'activeTimeEntry' => $request->user()->timeEntries()->whereNull('end_time')->first(),
        ]);
    }

    public function create(Workspace $workspace)
    {
        return Inertia::render('TimeEntries/Create', [
            'workspace' => $workspace,
            'projects' => $workspace->projects->load('tasks'),
            'tags' => $workspace->tags,
        ]);
    }

    public function store(Request $request, Workspace $workspace, CreateManualTimeEntry $createTimeEntry)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'task_id' => 'nullable|exists:tasks,id',
            'description' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'is_billable' => 'boolean',
            'hourly_rate' => 'nullable|numeric|min:0',
            'tags' => 'nullable|array',
        ]);

        $timeEntry = $createTimeEntry->execute($request->user(), $validated);

        if (! empty($validated['tags'])) {
            $assignTags = app(AssignTagsToTimeEntry::class);
            $assignTags->execute($timeEntry, $validated['tags']);
        }

        return redirect()->route('time-entries.index', $workspace)
            ->with('success', 'Entrada de tiempo creada con éxito.');
    }

    public function start(Request $request, Workspace $workspace, StartTimeEntry $startTimeEntry)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'task_id' => 'nullable|exists:tasks,id',
            'description' => 'nullable|string|max:255',
            'is_billable' => 'boolean',
        ]);

        $timeEntry = $startTimeEntry->execute($request->user(), $validated);

        return back()->with('success', 'Tiempo iniciado con éxito.');
    }

    public function stop(Request $request, TimeEntry $timeEntry, StopTimeEntry $stopTimeEntry)
    {
        $this->authorize('update', $timeEntry);

        $stopTimeEntry->execute($timeEntry);

        return back()->with('success', 'Tiempo detenido con éxito.');
    }

    public function assignTags(Request $request, TimeEntry $timeEntry, AssignTagsToTimeEntry $assignTags)
    {
        $this->authorize('update', $timeEntry);

        $validated = $request->validate([
            'tags' => 'required|array|exists:tags,id',
        ]);

        $assignTags->execute($timeEntry, $validated['tags']);

        return back()->with('success', 'Tags asignados con éxito.');
    }
}
