<?php

namespace App\Http\Controllers;

use App\Actions\Workspaces\CreateWorkspace;
use App\Actions\Workspaces\InviteUserToWorkspace;
use App\Models\Workspace;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class WorkspaceController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request): Response
    {
        $workspaces = $request->user()->workspaces;

        return Inertia::render('workspaces/Index', [
            'workspaces' => $workspaces,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('workspaces/Create');
    }

    public function store(Request $request, CreateWorkspace $createWorkspace): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ]);

        $workspace = $createWorkspace->execute($validated, $request->user());

        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Espacio de trabajo creado con éxito.');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Workspace $workspace): Response
    {
        $this->authorize('view', $workspace);

        return Inertia::render('workspaces/Show', [
            'workspace' => $workspace->load(['users', 'clients', 'projects']),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Workspace $workspace): Response
    {
        $this->authorize('update', $workspace);

        return Inertia::render('workspaces/Edit', [
            'workspace' => $workspace,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorize('update', $workspace);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'settings' => 'nullable|array',
        ]);

        $workspace->update($validated);

        return redirect()->route('workspaces.show', $workspace)
            ->with('success', 'Espacio de trabajo actualizado con éxito.');
    }

    /**
     * @throws AuthorizationException
     */
    public function inviteUser(Request $request, Workspace $workspace, InviteUserToWorkspace $inviteUser): RedirectResponse
    {
        $this->authorize('invite', $workspace);

        $validated = $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,member',
        ]);

        $inviteUser->execute($workspace, $validated['email'], $validated['role']);

        return back()->with('success', 'Usuario invitado con éxito.');
    }

    /**
     * @throws AuthorizationException
     */
    public function manageUsers(Workspace $workspace): Response
    {
        $this->authorize('manageUsers', $workspace);

        return Inertia::render('Workspaces/ManageUsers', [
            'workspace' => $workspace,
            'users' => $workspace->users()->withPivot('role')->get(),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateUserRole(Request $request, Workspace $workspace, $userId): RedirectResponse
    {
        $this->authorize('manageUsers', $workspace);

        $validated = $request->validate([
            'role' => 'required|in:admin,member',
        ]);

        $workspace->users()->updateExistingPivot($userId, ['role' => $validated['role']]);

        return back()->with('success', 'Rol de usuario actualizado.');
    }
}
