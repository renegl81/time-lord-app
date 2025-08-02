<?php

namespace App\Http\Controllers;

use App\Actions\Reports\GenerateTimeReport;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(Workspace $workspace)
    {
        return Inertia::render('Reports/Index', [
            'workspace' => $workspace,
        ]);
    }

    public function time(Request $request, Workspace $workspace, GenerateTimeReport $reportGenerator)
    {
        $filters = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'client_id' => 'nullable|exists:clients,id',
        ]);

        $report = $reportGenerator->execute($workspace, $filters);

        return Inertia::render('Reports/Time', [
            'workspace' => $workspace,
            'report' => $report,
            'filters' => $filters,
            'projects' => $workspace->projects,
            'clients' => $workspace->clients,
            'users' => $workspace->users,
        ]);
    }
}
