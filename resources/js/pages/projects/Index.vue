<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="`Proyectos - ${workspace.name}`" />
    <div class="flex flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Proyectos</h1>
            <Link
            :href="route('projects.create', workspace.id)"
            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
            Crear Proyecto
        </Link>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 md:flex-row md:items-center">
        <div class="flex-grow">
            <input
                type="text"
                placeholder="Buscar proyectos..."
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                v-model="searchTerm"
            />
        </div>

        <div class="flex flex-col gap-4 sm:flex-row">
            <select
                class="rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                v-model="clientFilter"
            >
                <option :value="null">Todos los clientes</option>
            <option v-for="client in clients" :key="client.id" :value="client.id">
            {{ client.name }}
        </option>
    </select>

    <select
        class="rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        v-model="statusFilter"
    >
        <option :value="null">Todos los estados</option>
    <option value="active">Activo</option>
    <option value="completed">Completado</option>
    <option value="pending">Pendiente</option>
</select>
</div>
</div>

<!-- Lista de proyectos -->
<div v-if="filteredProjects.length === 0" class="flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 p-12 text-center dark:border-gray-700 dark:bg-gray-800">
    <div class="mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-700">
        <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
        </svg>
    </div>
    <template v-if="projects.length === 0">
        <h2 class="mb-2 text-xl font-medium">No hay proyectos</h2>
        <p class="mb-4 text-gray-500 dark:text-gray-400">Crea tu primer proyecto para comenzar a trabajar.</p>
    </template>
    <template v-else>
        <h2 class="mb-2 text-xl font-medium">No se encontraron resultados</h2>
        <p class="mb-4 text-gray-500 dark:text-gray-400">Intenta ajustar los filtros de búsqueda.</p>
    </template>
    <Link
    :href="`/workspaces/${workspace.id}/projects/create`"
    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
    >
    Crear Proyecto
</Link>
</div>
<div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Cliente</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tareas</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Usuarios</th>
            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Acciones</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
        <tr v-for="project in filteredProjects" :key="project.id">
        <td class="whitespace-nowrap px-6 py-4">
            <div class="flex items-center">
                <div
                    v-if="project.color"
                    class="mr-2 h-3 w-3 rounded-full"
                :style="{ backgroundColor: project.color }"
                ></div>
            <Link :href="`/projects/${project.id}`" class="font-medium hover:underline">
            {{ project.name }}
        </Link>
</div>
</td>
<td class="whitespace-nowrap px-6 py-4">
    {{ project.client ? project.client.name : '—' }}
</td>
<td class="whitespace-nowrap px-6 py-4">
    <span :class="`inline-block rounded px-2 py-1 text-xs font-semibold ${
    project.status === 'active'
        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
        : project.status === 'completed'
            ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
}`">
    {{ project.status === 'active' ? 'Activo' :
            project.status === 'completed' ? 'Completado' : 'Pendiente' }}
</span>
</td>
<td class="whitespace-nowrap px-6 py-4">
    {{ project.tasks.length }}
</td>
<td class="px-6 py-4">
    <div class="flex -space-x-2 overflow-hidden">
        <template v-if="project.users.length > 0">
            <div
                v-for="user in project.users.slice(0, 3)"
            :key="user.id"
            class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-200 text-xs font-medium ring-2 ring-white dark:bg-gray-700 dark:ring-gray-800"
            :title="user.name"
            >
            {{ user.name.charAt(0) }}
    </div>
    <div
        v-if="project.users.length > 3"
        class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-200 text-xs font-medium ring-2 ring-white dark:bg-gray-700 dark:ring-gray-800"
    >
        +{{ project.users.length - 3 }}
    </div>
</template>
<span v-else class="text-gray-500 dark:text-gray-400">—</span>
</div>
</td>
<td class="whitespace-nowrap px-6 py-4 text-right">
    <Link
    :href="route('projects.show', {workspace: project.workspace.id, project: project.id})"
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
</AppLayout>
</template>

<script setup lang="ts">
    import { ref, computed } from 'vue';
    import { Head, Link } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type Workspace } from "@/types/workspace";
    import { type Project } from "@/types/project";
    import { type Client } from "@/types/client";

    interface Props {
    workspace: Workspace;
    projects: Project[];
    clients: Client[];
}

    const props = defineProps<Props>();

    const searchTerm = ref('');
    const clientFilter = ref<number | null>(null);
    const statusFilter = ref<string | null>(null);

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Proyectos', href: route('projects.index', props.workspace.id) },
    ];

    const filteredProjects = computed(() => {
        return props.projects.filter((project) => {
        // Filtro por término de búsqueda
        if (searchTerm.value && !project.name.toLowerCase().includes(searchTerm.value.toLowerCase())) {
        return false;
    }

        // Filtro por cliente
        if (clientFilter.value && project.client_id !== clientFilter.value) {
        return false;
    }

        // Filtro por estado
        if (statusFilter.value && project.status !== statusFilter.value) {
        return false;
    }

        return true;
    });
    });
</script>
