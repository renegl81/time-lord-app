<template>
    <div>
        <div class="mb-4 flex justify-between">
            <h2 class="text-lg font-medium">Registro de Tiempo</h2>
            <Link
            :href="`/projects/${project.id}/time/create`"
            class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
            >
            Registrar Tiempo
        </Link>
    </div>

    <div v-if="project.time_entries?.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
        <p class="text-gray-500 dark:text-gray-400">No hay registros de tiempo para este proyecto.</p>
        <div class="mt-2 flex justify-center gap-2">
            <Link
            :href="`/projects/${project.id}/time/create`"
            class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
            >
            Registrar Tiempo
        </Link>
        <Link
        :href="`/projects/${project.id}/timer`"
        class="rounded border border-blue-600 bg-white px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 dark:border-blue-500 dark:bg-gray-800 dark:text-blue-500 dark:hover:bg-gray-700"
        >
        Iniciar Temporizador
    </Link>
</div>
</div>
<div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Descripción</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Usuario</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Fecha</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Duración</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
        <tr v-for="entry in project.time_entries" :key="entry.id">
        <td class="px-6 py-4">
            {{ entry.description }}
        </td>
        <td class="whitespace-nowrap px-6 py-4">
            {{ entry.user.name }}
        </td>
        <td class="whitespace-nowrap px-6 py-4">
            {{ new Date(entry.started_at).toLocaleDateString() }}
        </td>
        <td class="whitespace-nowrap px-6 py-4">
            {{ Math.floor(entry.duration / 60) }}h {{ entry.duration % 60 }}m
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
