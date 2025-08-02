<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Nueva Tarea" />

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Nueva Tarea</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Crear una nueva tarea para el proyecto {{ project.name }}
            </p>
        </div>

        <form @submit.prevent="submit" class="max-w-2xl">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nombre de la tarea <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                v-model="form.name"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                required
            />
            <div v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</div>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Descripción
            </label>
            <textarea
                id="description"
                v-model="form.description"
                rows="4"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            ></textarea>
            <div v-if="form.errors.description" class="mt-1 text-sm text-red-500">{{ form.errors.description }}</div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Estado
            </label>
            <select
                id="status"
                v-model="form.status"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
                <option value="pending">Pendiente</option>
                <option value="in_progress">En progreso</option>
                <option value="completed">Completado</option>
            </select>
            <div v-if="form.errors.status" class="mt-1 text-sm text-red-500">{{ form.errors.status }}</div>
        </div>

        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Fecha límite
            </label>
            <input
                type="date"
                id="due_date"
                v-model="form.due_date"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
            <div v-if="form.errors.due_date" class="mt-1 text-sm text-red-500">{{ form.errors.due_date }}</div>
        </div>

        <div class="mb-4">
            <label for="estimate_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Horas estimadas
            </label>
            <input
                type="number"
                step="0.5"
                min="0"
                id="estimate_hours"
                v-model="form.estimate_hours"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
            <div v-if="form.errors.estimate_hours" class="mt-1 text-sm text-red-500">{{ form.errors.estimate_hours }}</div>
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Asignar a
            </label>
            <select
                id="user_id"
                v-model="form.user_id"
                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
                <option value="">Sin asignar</option>
                <option v-for="user in project.users" :key="user.id" :value="user.id">
                {{ user.name }}
            </option>
        </select>
        <div v-if="form.errors.user_id" class="mt-1 text-sm text-red-500">{{ form.errors.user_id }}</div>
    </div>

    <div class="mb-4">
        <div class="flex items-center">
            <input
                type="checkbox"
                id="is_billable"
                v-model="form.is_billable"
                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            />
            <label for="is_billable" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                Facturable
            </label>
        </div>
        <div v-if="form.errors.is_billable" class="mt-1 text-sm text-red-500">{{ form.errors.is_billable }}</div>
    </div>

    <div v-if="form.is_billable" class="mb-4">
        <label for="hourly_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Tarifa por hora
        </label>
        <input
            type="number"
            step="0.01"
            min="0"
            id="hourly_rate"
            v-model="form.hourly_rate"
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        :placeholder="project.hourly_rate ? `Predeterminado: ${project.hourly_rate}` : ''"
        />
        <div v-if="form.errors.hourly_rate" class="mt-1 text-sm text-red-500">{{ form.errors.hourly_rate }}</div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-3">
        <button
            type="button"
        @click="goBack"
        class="rounded border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
        >
        Cancelar
    </button>
    <button
        type="submit"
    :disabled="form.processing"
    class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
    >
    Guardar Tarea
</button>
</div>
</form>
</div>
</AppLayout>
</template>

<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import type { Project } from "@/types/project";
    import type { Workspace } from "@/types/workspace";

    interface Props {
    project: Project;
    workspace: Workspace;
}

    const props = defineProps<Props>();

    const form = useForm({
        name: '',
        description: '',
        status: 'pending',
        due_date: '',
        estimate_hours: '',
        is_billable: props.project.is_billable,
        hourly_rate: props.project.hourly_rate || '',
        user_id: '',
    });

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Proyectos', href: route('projects.index', props.workspace.id) },
    { title: 'Nueva Tarea', href: route('projects.tasks.create', [props.workspace.id, props.project.id]) },
    ];

    const submit = () => {
        form.post(route('projects.tasks.store', [props.workspace.id, props.project.id]));
    };

    const goBack = () => {
        window.history.back();
    };
</script>
