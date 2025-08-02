<?php

namespace App\Http\Controllers;

use App\Actions\Tasks\CreateTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Workspace $workspace, Project $project)
    {
        $tasks = $project->tasks;

        return Inertia::render('tasks/index', [
            'workspace' => $workspace,
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function create(Workspace $workspace, Project $project)
    {
        return Inertia::render('tasks/create', [
            'workspace' => $workspace,
            'project' => $project,
        ]);
    }

    public function store(Request $request, Workspace $workspace, Project $project, CreateTask $createTask)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'is_billable' => 'boolean',
        ]);

        $task = $createTask->execute($validated, $project);

        return redirect()->route('projects.tasks.index', [$workspace, $project])
            ->with('success', 'Tarea creada con éxito.');
    }

    public function show(Task $task)
    {
        $project = $task->project;
        $workspace = $project->workspace;

        return Inertia::render('tasks/show', [
            'workspace' => $workspace,
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function edit(Task $task)
    {
        $project = $task->project;
        $workspace = $project->workspace;

        return Inertia::render('tasks/edit', [
            'workspace' => $workspace,
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'is_billable' => 'boolean',
        ]);

        $task->update($validated);

        $project = $task->project;
        $workspace = $project->workspace;

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tarea actualizada con éxito.');
    }

    public function destroy(Task $task)
    {
        $project = $task->project;
        $workspace = $project->workspace;

        // Verificar que no tenga entradas de tiempo asociadas
        if ($task->timeEntries()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una tarea con entradas de tiempo.');
        }

        $task->delete();

        return redirect()->route('projects.tasks.index', [$workspace, $project])
            ->with('success', 'Tarea eliminada con éxito.');
    }
}
