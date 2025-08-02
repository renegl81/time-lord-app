<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Rutas autenticadas
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workspaces/{workspace}/users', [WorkspaceController::class, 'manageUsers'])
        ->name('workspaces.users');
    Route::put('/workspaces/{workspace}/users/{user}', [WorkspaceController::class, 'updateUserRole'])
        ->name('workspaces.users.update-role');

    // Workspaces
    Route::resource('workspaces', WorkspaceController::class);
    Route::post('/workspaces/{workspace}/invite', [WorkspaceController::class, 'inviteUser'])
        ->name('workspaces.invite');

    // Contexto de Workspace
    Route::prefix('workspaces/{workspace}')
        ->middleware('workspace.access')->group(function () {
            // Clientes
            Route::resource('clients', ClientController::class);

            // Proyectos
            Route::resource('projects', ProjectController::class);
            Route::post('/projects/{project}/users', [ProjectController::class, 'assignUsers'])
                ->name('projects.users.assign');

            // Tareas
            Route::resource('projects.tasks', TaskController::class)->shallow();

            Route::prefix('projects/{project}/tasks')->name('projects.tasks.')->group(function () {
                // Cambiar estado de tarea
                Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])
                    ->name('update-status');

                // Asignar usuario a tarea
                Route::patch('/{task}/assign', [TaskController::class, 'assignUser'])
                    ->name('assign');

                // Priorizar tareas
                Route::patch('/{task}/prioritize', [TaskController::class, 'updatePriority'])
                    ->name('prioritize');

                // Duplicar tarea
                Route::post('/{task}/duplicate', [TaskController::class, 'duplicate'])
                    ->name('duplicate');

                // Añadir comentario a tarea
                Route::post('/{task}/comments', [TaskController::class, 'addComment'])
                    ->name('comments.add');

                // Gestión de subtareas
             //   Route::resource('/{task}/subtasks', 'SubtaskController')->shallow();
        });
        // Time Entries
        Route::resource('time-entries', TimeEntryController::class);
        Route::post('/time-entries/start', [TimeEntryController::class, 'start'])
            ->name('time-entries.start');
        Route::post('/time-entries/{timeEntry}/stop', [TimeEntryController::class, 'stop'])
            ->name('time-entries.stop');
        Route::post('/time-entries/{timeEntry}/tags', [TimeEntryController::class, 'assignTags'])
            ->name('time-entries.tags.assign');

        // Tags
        Route::resource('tags', TagController::class);

        // Reportes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/time', [ReportController::class, 'time'])->name('reports.time');
        Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
});


Route::prefix('admin')->middleware(['auth', 'can:manage-system'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.users.index');
    Route::get('/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [App\Http\Controllers\Admin\UsersController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
