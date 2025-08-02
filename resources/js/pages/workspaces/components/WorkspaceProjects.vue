<template>
    <div>
        <SectionHeader
            title="Proyectos"
            buttonText="Nuevo Proyecto"
        :buttonHref="route('projects.create', {workspace: workspace.id})"
        />

        <div v-if="workspace.projects.length === 0"
             class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
            <p class="text-gray-500 dark:text-gray-400">No hay proyectos en este espacio de trabajo.</p>
            <Link
            :href="`/workspaces/${workspace.id}/projects/create`"
            class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
            >
            Crear Primer Proyecto
        </Link>
    </div>
    <div v-else class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Fecha creación</th>
                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
            <tr v-for="project in workspace.projects" :key="project.id">
            <td class="whitespace-nowrap px-6 py-4">{{ project.name }}</td>
            <td class="whitespace-nowrap px-6 py-4">
              <span
                :class="`inline-block rounded px-2 py-1 text-xs font-semibold ${
                project.status === 'active'
                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                    : project.status === 'completed'
                        ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
            }`"
                >
                {{ project.status === 'active' ? 'Activo' :
                        project.status === 'completed' ? 'Completado' : 'Pendiente' }}
            </span>
            </td>
            <td class="whitespace-nowrap px-6 py-4">{{ new Date(project.created_at).toLocaleDateString() }}</td>
            <td class="whitespace-nowrap px-6 py-4 text-right">
                <Link
                :href="`/workspaces/${workspace.id}/projects/${project.id}`"
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
    import SectionHeader from "@/components/admin/SectionHeader.vue";

    interface Project {
    id: number;
    name: string;
    status: string;
    client_id?: number;
    created_at: string;
}

    interface Workspace {
    id: number;
    name: string;
    projects: Project[];
}

    defineProps<{
    workspace: Workspace;
    }>();
</script>
