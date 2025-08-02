<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Clientes" />

        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Clientes</h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Gestiona los clientes de {{ workspace.name }}
                    </p>
                </div>
                <Link
                    :href="route('clients.create', workspace.id)"
                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Nuevo Cliente
                </Link>
            </div>

            <div v-if="clients.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
                <p class="text-gray-500 dark:text-gray-400">No hay clientes en este espacio de trabajo.</p>
                <Link
                    :href="route('clients.create', workspace.id)"
                    class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
                >
                    Crear Primer Cliente
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
                            Proyectos
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Acciones
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="client in clients" :key="client.id">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            {{ client.name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            {{ client.projects ? client.projects.length : 0 }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                            <Link
                                :href="route('clients.show', [workspace.id, client.id])"
                                class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
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
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { computed } from 'vue';
import type { Workspace } from '@/types/workspace';
import type { Client } from '@/types/client';

const props = defineProps<{
    workspace: Workspace;
    clients: Client[];
}>();

const breadcrumbs = computed(() => [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Clientes', href: route('clients.index', props.workspace.id) },
]);
</script>
