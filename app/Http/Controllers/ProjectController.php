<?php

namespace App\Http\Controllers;

use App\Actions\Projects\AssignUsersToProject;
use App\Actions\Projects\CreateProject;
use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function index(Workspace $workspace)
    {
        $projects = $workspace->projects()
            ->with(['client', 'tasks', 'users'])
            ->get();

        return Inertia::render('projects/Index', [
            'workspace' => $workspace,
            'projects' => $projects,
            'clients' => $workspace->clients,
        ]);
    }

    public function create(Workspace $workspace)
    {
        return Inertia::render('projects/Create', [
            'workspace' => $workspace,
            'clients' => $workspace->clients,
        ]);
    }

    public function store(Request $request, Workspace $workspace, CreateProject $createProject): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'hourly_rate' => 'nullable|numeric|min:0',
            'estimate' => 'nullable|numeric|min:0',
            'budget' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:7',
            'is_billable' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $project = $createProject->execute($validated, $workspace);

        return redirect()->route('projects.index', $workspace)
            ->with('success', 'Proyecto creado con éxito.');
    }

    public function show(Workspace $workspace, Project $project): Response
    {
        return Inertia::render('projects/Show', [
            'workspace' => $workspace,
            'project' => $project->load(['client', 'tasks', 'users', 'workspace']),
        ]);
    }

    public function edit(Workspace $workspace, Project $project): Response
    {
        return Inertia::render('projects/Edit', [
            'workspace' => $workspace,
            'project' => $project,
            'clients' => $workspace->clients,
        ]);
    }

    public function update(Request $request, Workspace $workspace, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
            'hourly_rate' => 'nullable|numeric|min:0',
            'estimate' => 'nullable|numeric|min:0',
            'budget' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:7',
            'is_billable' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', [$workspace, $project])
            ->with('success', 'Proyecto actualizado con éxito.');
    }

    public function destroy(Workspace $workspace, Project $project): RedirectResponse
    {
        // Verificar que no tenga tareas o entradas de tiempo asociadas
        if ($project->tasks()->count() > 0 || $project->timeEntries()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un proyecto con tareas o entradas de tiempo.');
        }

        $project->delete();

        return redirect()->route('projects.index', $workspace)
            ->with('success', 'Proyecto eliminado con éxito.');
    }

    public function assignUsers(Request $request,
                                Workspace $workspace,
                                Project $project,
                                AssignUsersToProject $assignUsers
    ): RedirectResponse
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|exists:users,id',
        ]);

        $assignUsers->execute($project, $validated['user_ids']);

        return back()->with('success', 'Usuarios asignados con éxito.');
    }
}
