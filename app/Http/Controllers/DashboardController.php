<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $workspaces = $user->workspaces;
        $recentTimeEntries = $user->timeEntries()->latest()->take(5)->get();

        return Inertia::render('Dashboard', [
            'workspaces' => $workspaces,
            'recentTimeEntries' => $recentTimeEntries,
        ]);
    }
}
