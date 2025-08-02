<?php

namespace App\Http\Controllers;

use App\Actions\Tags\CreateTag;
use App\Models\Tag;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Workspace $workspace)
    {
        $tags = $workspace->tags;

        return Inertia::render('Tags/Index', [
            'workspace' => $workspace,
            'tags' => $tags,
        ]);
    }

    public function create(Workspace $workspace)
    {
        return Inertia::render('Tags/Create', [
            'workspace' => $workspace,
        ]);
    }

    public function store(Request $request, Workspace $workspace, CreateTag $createTag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $tag = $createTag->execute($validated, $workspace);

        return redirect()->route('tags.index', $workspace)
            ->with('success', 'Etiqueta creada con éxito.');
    }

    public function edit(Workspace $workspace, Tag $tag)
    {
        return Inertia::render('Tags/Edit', [
            'workspace' => $workspace,
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Workspace $workspace, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index', $workspace)
            ->with('success', 'Etiqueta actualizada con éxito.');
    }

    public function destroy(Workspace $workspace, Tag $tag)
    {
        // Desvincular la etiqueta de todas las entradas de tiempo
        $tag->timeEntries()->detach();

        $tag->delete();

        return redirect()->route('tags.index', $workspace)
            ->with('success', 'Etiqueta eliminada con éxito.');
    }
}
