<?php

namespace App\Http\Controllers;

use App\Actions\Tasks\CreateTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Workspace $workspace, Project $project): Response
    {
      $tasks = Task::whereHas('project', function ($query) use ($project) {
          return $query->where('id', $project->id);
      })->paginate();


        return Inertia::render('tasks/Index', [
            'workspace' => $workspace,
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function create(Workspace $workspace, Project $project): Response
    {
        return Inertia::render('tasks/Create', [
            'workspace' => $workspace,
            'project' => $project,
        ]);
    }

    public function store(Request $request, Workspace $workspace, Project $project, CreateTask $createTask): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'estimate' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'is_billable' => 'boolean',
            'status' => 'required|string',
            'user_id' => 'nullable|integer',
        ]);


        $createTask->execute($validated, $project);

        return redirect()->route('projects.tasks.index', [$workspace, $project])
            ->with('success', 'Tarea creada con éxito.');
    }

    public function show(Task $task): Response
    {
        $project = $task->project;
        $workspace = $project->workspace;

        return Inertia::render('tasks/Show', [
            'workspace' => $workspace,
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function edit(Task $task): Response
    {
        $project = $task->project;
        $workspace = $project->workspace;

        return Inertia::render('tasks/Edit', [
            'workspace' => $workspace,
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
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

        return redirect()->route('projects.tasks.show', [
            'task' =>$task,
            'project' => $task->project_id,
            'workspace' => $task->project->workspace->id
            ])
            ->with('success', 'Tarea actualizada con éxito.');
    }

    public function destroy(Task $task): RedirectResponse
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
