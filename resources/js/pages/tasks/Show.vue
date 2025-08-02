<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="task.name" />

        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ task.name }}</h1>
                    <div class="mt-1 flex items-center gap-2">
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
                        <span class="text-gray-500 dark:text-gray-400">
              Proyecto: <Link :href="route('projects.show', task.project_id)" class="hover:underline">{{ task.project.name }}</Link>
            </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Link
                        :href="route('tasks.edit', task.id)"
                        class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"
                    >
                        Editar
                    </Link>
                    <button
                        @click="isDeleteModalOpen = true"
                        class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                    >
                        Eliminar
                    </button>
                </div>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-medium">Detalles de la Tarea</h2>

                    <div v-if="task.description" class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción:</h3>
                        <p class="mt-1 whitespace-pre-line text-gray-900 dark:text-white">{{ task.description }}</p>
                    </div>

                    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado:</h3>
                            <div class="mt-1 flex items-center gap-2">
                                <select
                                    v-model="taskStatus"
                                    @change="updateTaskStatus"
                                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="pending">Pendiente</option>
                                    <option value="in_progress">En progreso</option>
                                    <option value="completed">Completado</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Asignado a:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ task.user ? task.user.name : 'No asignado' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha límite:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'No establecida' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tiempo estimado:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ task.estimate_hours ? `${task.estimate_hours} horas` : 'No estimado' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Facturable:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ task.is_billable ? 'Sí' : 'No' }}
                            </p>
                        </div>
                        <div v-if="task.is_billable">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tarifa por hora:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ task.hourly_rate ? `$${task.hourly_rate}` : (task.project.hourly_rate ? `$${task.project.hourly_rate} (proyecto)` : 'No establecida') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Creada el:</h3>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ new Date(task.created_at).toLocaleDateString() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="mb-4 text-lg font-medium">Tiempo Registrado</h2>

                    <div v-if="task.time_entries?.length === 0" class="text-center text-gray-500 dark:text-gray-400">
                        <p>No hay registros de tiempo para esta tarea.</p>
                        <div class="mt-2">
                            <Link
                                :href="route('tasks.time.create', task.id)"
                                class="inline-block rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                            >
                                Registrar Tiempo
                            </Link>
                        </div>
                    </div>
                    <div v-else class="mt-2 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Fecha</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Usuario</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Duración</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="entry in task.time_entries" :key="entry.id">
                                <td class="whitespace-nowrap px-4 py-2 text-sm">
                                    {{ new Date(entry.started_at).toLocaleDateString() }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-sm">
                                    {{ entry.user.name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-sm">
                                    {{ Math.floor(entry.duration / 60) }}h {{ entry.duration % 60 }}m
                                </td>
                            </tr>
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <td colspan="2" class="whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Total:
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ totalHours }}h {{ totalMinutes }}m
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4">
                        <Link
                            :href="route('tasks.time.create', task.id)"
                            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                        >
                            Registrar Tiempo
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Comentarios (placeholder para funcionalidad futura) -->
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-medium">Comentarios</h2>
                <div class="text-center text-gray-500 dark:text-gray-400">
                    <p>No hay comentarios para esta tarea.</p>
                </div>
            </div>

            <!-- Modal de confirmación de eliminación -->
            <div v-if="isDeleteModalOpen" class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
                    <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                        <div class="bg-white px-4 pb-4 pt-5 dark:bg-gray-800 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                        Eliminar tarea
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            ¿Estás seguro de que deseas eliminar esta tarea? Esta acción no se puede deshacer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                            <button
                                type="button"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="handleDelete"
                            >
                                Eliminar
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm"
                                @click="isDeleteModalOpen = false"
                            >
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Task } from '@/types/task';
import type { TimeEntry } from '@/types/time-entry';

interface Props {
    task: Task & {
        time_entries?: TimeEntry[];
    };
}

const props = defineProps<Props>();
const isDeleteModalOpen = ref(false);
const taskStatus = ref(props.task.status);

const breadcrumbs = [
    { title: 'Tareas', href: route('tasks.index') },
    { title: props.task.name, href: route('tasks.show', props.task.id) },
];

const totalTime = computed(() => {
    if (!props.task.time_entries || props.task.time_entries.length === 0) return 0;
    return props.task.time_entries.reduce((sum, entry) => sum + entry.duration, 0);
});

const totalHours = computed(() => Math.floor(totalTime.value / 60));
const totalMinutes = computed(() => totalTime.value % 60);

const handleDelete = () => {
    router.delete(route('tasks.destroy', props.task.id), {
        onSuccess: () => isDeleteModalOpen.value = false
    });
};

const updateTaskStatus = () => {
    router.put(route('tasks.update.status', props.task.id), {
        status: taskStatus.value
    });
};
</script>
