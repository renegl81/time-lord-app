<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Tareas" />

        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Tareas</h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Gestiona las tareas de tus proyectos
                    </p>
                </div>
                <div class="flex gap-2">
                 <!--   <Link
                        :href="route('projects.tasks.create')"
                        class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Nueva Tarea
                    </Link> -->
                </div>
            </div>

            <!-- Filtros -->
            <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="status-filter" class="mb-1 block text-sm font-medium">Estado</label>
                        <select
                            id="status-filter"
                            v-model="filters.status"
                            class="w-full rounded-lg border border-gray-300 p-2 dark:border-gray-600 dark:bg-gray-700"
                            @change="filterTasks"
                        >
                            <option value="">Todos</option>
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En progreso</option>
                            <option value="completed">Completado</option>
                        </select>
                    </div>
                    <div>
                        <label for="project-filter" class="mb-1 block text-sm font-medium">Proyecto</label>
                        <select
                            id="project-filter"
                            v-model="filters.projectId"
                            class="w-full rounded-lg border border-gray-300 p-2 dark:border-gray-600 dark:bg-gray-700"
                            @change="filterTasks"
                        >
                            <option value="">Todos los proyectos</option>
                            <option v-for="project in projects" :key="project.id" :value="project.id">
                                {{ project.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="mb-1 block text-sm font-medium">Buscar</label>
                        <input
                            id="search"
                            v-model="filters.search"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 p-2 dark:border-gray-600 dark:bg-gray-700"
                            placeholder="Buscar tareas..."
                            @input="debounceSearch"
                        />
                    </div>
                </div>
            </div>

            <!-- Lista de tareas -->
            <div v-if="tasks.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
                <p class="text-gray-500 dark:text-gray-400">No hay tareas disponibles.</p>
              <!--  <Link
                    :href="route('projects.tasks.create')"
                    class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
                >
                    Crear Primera Tarea
                </Link> -->
            </div>
            <div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Tarea
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Proyecto
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Asignado a
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Fecha límite
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="task in tasks" :key="task.id">
                      <!--  <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            <Link :href="route('projects.tasks.show', {task: task.id, project: task.project_id, workspace: task.project.workspace_id})" class="hover:underline">
                                {{ task.name }}
                            </Link>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            <Link :href="route('projects.show', task.project_id)" class="hover:underline">
                                {{ task.project ? task.project.name : '—' }}
                            </Link>
                        </td>-->
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
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
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            {{ task.user ? task.user.name : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : '—' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <div class="flex justify-end space-x-2">
                              <!--  <Link
                                    :href="route('projects.tasks.show', {task: task.id, project: task.project_id, workspace: task.project.workspace_id})"
                                    class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
                                >
                                    Ver
                                </Link>
                                <Link
                                    :href="route('tasks.edit', task.id)"
                                    class="rounded bg-gray-600 px-3 py-1 text-white hover:bg-gray-700"
                                >
                                    Editar
                                </Link> -->
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div v-if="pagination?.links && pagination?.links?.length > 3" class="border-t border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-800 sm:px-6">
                    <div class="flex flex-1 items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Mostrando
                                <span class="font-medium">{{ pagination.from }}</span>
                                a
                                <span class="font-medium">{{ pagination.to }}</span>
                                de
                                <span class="font-medium">{{ pagination.total }}</span>
                                tareas
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <Link
                                    v-for="(link, index) in pagination.links"
                                    :key="index"
                                    :href="link.url"
                                    :class="[
                    'relative inline-flex items-center px-4 py-2 text-sm font-medium',
                    link.active
                      ? 'bg-blue-600 text-white focus:z-20'
                      : 'bg-white text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700',
                    index === 0 ? 'rounded-l-md' : '',
                    index === pagination.links.length - 1 ? 'rounded-r-md' : '',
                  ]"
                                    v-html="link.label"
                                ></Link>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Task } from '@/types/task';
import type { Project } from '@/types/project';

interface Props {
    tasks: Task[];
    projects: Project[];
    filters: {
        status: string;
        projectId: string;
        search: string;
    };
    pagination: {
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        from: number;
        to: number;
        total: number;
    };
}

const props = defineProps<Props>();

const tasks = ref<Task[]>(props.tasks);
const filters = reactive({
    status: props.filters?.status || '',
    projectId: props.filters?.projectId || '',
    search: props.filters?.search || '',
});

const breadcrumbs = [
    { title: 'Tareas' },
];

let searchTimeout: number | null = null;

const debounceSearch = () => {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    searchTimeout = setTimeout(() => {
        filterTasks();
    }, 300);
};

const filterTasks = () => {
    router.get(
        route('projects.tasks.index'),
        {
            status: filters.status,
            project_id: filters.projectId,
            search: filters.search,
            workspace: 1
        },
        {
            preserveState: true,
            replace: true,
            only: ['tasks', 'pagination']
        }
    );
};
</script>
