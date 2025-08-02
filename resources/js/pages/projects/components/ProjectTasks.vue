<template>
    <div>
        <div class="mb-4 flex justify-between">
            <h2 class="text-lg font-medium">Tareas</h2>
            <Link
            :href="route('projects.tasks.create', [project.workspace.id, project.id])"
            class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
            >
            Nueva Tarea
        </Link>
    </div>

    <div v-if="project.tasks.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
        <p class="text-gray-500 dark:text-gray-400">No hay tareas en este proyecto.</p>
        <Link
        :href="route('projects.tasks.create', [project.workspace.id, project.id])"
        class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
        >
        Crear Primera Tarea
    </Link>
</div>
<div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tarea</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Asignado a</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Fecha límite</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tiempo</th>
            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Acciones</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
        <tr v-for="task in project.tasks" :key="task.id">
        <td class="whitespace-nowrap px-6 py-4">
            <Link :href="`/tasks/${task.id}`" class="font-medium hover:underline">
            {{ task.name }}
        </Link>
        </td>
        <td class="whitespace-nowrap px-6 py-4">
              <span
            :class="`inline-block rounded px-2 py-1 text-xs font-semibold ${
            task.status === 'completed'
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                : task.status === 'in_progress'
                    ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                    : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
        }`"
            >
            {{ task.status === 'completed' ? 'Completado' :
                    task.status === 'in_progress' ? 'En progreso' : 'Pendiente' }}
        </span>
    </td>
    <td class="whitespace-nowrap px-6 py-4">
        {{ task.user ? task.user.name : '—' }}
    </td>
    <td class="whitespace-nowrap px-6 py-4">
        {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '—' }}
    </td>
    <td class="whitespace-nowrap px-6 py-4">
        {{ task.estimate_hours ? `${task.estimate_hours}h est.` : '—' }}
        {{ task.actual_hours ? ` / ${task.actual_hours}h real` : '' }}
    </td>
    <td class="whitespace-nowrap px-6 py-4 text-right">
        <Link
        :href="route('projects.tasks.create', [project.workspace.id, project.id])"
        class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
        >
        Ver
    </Link>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { type Project } from "@/types/project";

    interface Props {
    project: Project;
}

    defineProps<Props>();
</script>
