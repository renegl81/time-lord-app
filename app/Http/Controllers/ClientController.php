<?php

namespace App\Http\Controllers;

use App\Actions\Clients\CreateClient;
use App\Actions\Clients\UpdateClient;
use App\Models\Client;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    public function index(Workspace $workspace): Response
    {
        $clients = $workspace->clients()->with('projects')->get();

        return Inertia::render('clients/Index', [
            'workspace' => $workspace,
            'clients' => $clients,
        ]);
    }

    public function create(Workspace $workspace): Response
    {
        return Inertia::render('clients/Create', [
            'workspace' => $workspace,
        ]);
    }

    public function store(Request $request, Workspace $workspace, CreateClient $createClient): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'contact_info' => 'nullable|string',
        ]);

        $client = $createClient->execute($validated, $workspace);

        return redirect()->route('clients.index', $workspace)
            ->with('success', 'Cliente creado con éxito.');
    }

    public function show(Workspace $workspace, Client $client): Response
    {
        return Inertia::render('clients/Show', [
            'workspace' => $workspace,
            'client' => $client->load('projects'),
        ]);
    }

    public function edit(Workspace $workspace, Client $client): Response
    {
        return Inertia::render('clients/Edit', [
            'workspace' => $workspace,
            'client' => $client,
        ]);
    }

    public function update(Request $request, Workspace $workspace, Client $client, UpdateClient $updateClient): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'contact_info' => 'nullable|string',
        ]);

        $updateClient->execute($client, $validated);

        return redirect()->route('clients.show', [$workspace, $client])
            ->with('success', 'Cliente actualizado con éxito.');
    }

    public function destroy(Workspace $workspace, Client $client): RedirectResponse
    {
        // Verificar que no tenga proyectos asociados o manejar la eliminación en cascada
        if ($client->projects()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un cliente con proyectos.');
        }

        $client->delete();

        return redirect()->route('clients.index', $workspace)
            ->with('success', 'Cliente eliminado con éxito.');
    }
}
