<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="client.name" />

    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ client.name }}</h1>
                <p class="text-gray-500 dark:text-gray-400">
                    Detalles del cliente
                </p>
            </div>
            <div class="flex space-x-2">
                <Link
                :href="route('clients.edit', [workspace.id, client.id])"
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
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
        <h2 class="mb-4 text-lg font-medium">Información del Cliente</h2>

        <div v-if="client.address" class="mb-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección:</h3>
            <p class="whitespace-pre-line text-gray-900 dark:text-white">{{ client.address }}</p>
        </div>

        <div v-if="client.contact_info">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Información de Contacto:</h3>
            <p class="whitespace-pre-line text-gray-900 dark:text-white">{{ client.contact_info }}</p>
        </div>
    </div>
</div>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-medium">Proyectos</h2>
    <Link
    :href="route('projects.create', workspace.id)"
    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
    >
    Nuevo Proyecto
</Link>
</div>

<div v-if="client.projects.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
    <p class="text-gray-500 dark:text-gray-400">Este cliente no tiene proyectos.</p>
    <Link
    :href="route('projects.create', workspace.id)"
    class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
    >
    Crear Primer Proyecto
</Link>
</div>
<div v-else class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                Nombre
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                Estado
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                Acciones
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
        <tr v-for="project in client.projects" :key="project.id">
        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
            {{ project.name }}
        </td>
        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                <span v-if="project.status === 'active'" class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-800 dark:text-green-100">
                  Activo
                </span>
            <span v-else class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800 dark:bg-red-800 dark:text-red-100">
                  Inactivo
                </span>
        </td>
        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
            <Link
            :href="route('projects.show', project.id)"
            class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
            >
            Ver
        </Link>
        </td>
    </tr>
</tbody>
</table>
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
                            Eliminar cliente
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                ¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.
                                <span v-if="client.projects.length > 0" class="mt-2 block font-medium text-red-600">
                        Advertencia: Este cliente tiene proyectos asociados. No podrá ser eliminado hasta que elimines los proyectos primero.
                      </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                <button
                    type="button"
                :class="`inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm ${
                client.projects.length > 0 ?
                    'cursor-not-allowed bg-red-300 hover:bg-red-300' :
                    'bg-red-600 hover:bg-red-700'
            }`"
                @click="handleDelete"
                :disabled="client.projects.length > 0"
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
    import { ref } from 'vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import type { Client } from '@/types/client';
    import type { Project } from '@/types/project';
    import type { Workspace } from '@/types/workspace';

    interface Props {
    workspace: Workspace;
    client: Client & { projects: Project[] };
}

    const props = defineProps<Props>();
    const isDeleteModalOpen = ref(false);

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Clientes', href: route('clients.index', props.workspace.id) },
    { title: props.client.name, href: route('clients.show', [props.workspace.id, props.client.id]) },
    ];

    const handleDelete = () => {
        router.delete(route('clients.destroy', [props.workspace.id, props.client.id]), {
            onSuccess: () => isDeleteModalOpen.value = false
        });
    };
</script>
