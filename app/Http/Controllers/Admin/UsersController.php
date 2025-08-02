<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $this->authorize('manage-system');

        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('name')
            ->paginate(10); // 10 usuarios por página

        return Inertia::render('admin/users/index', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('manage-system');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return back()->with('message', 'Usuario creado correctamente');
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('manage-system');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return back()->with('message', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $this->authorize('manage-system');

        $user->delete();

        return back()->with('message', 'Usuario eliminado correctamente');
    }
}
