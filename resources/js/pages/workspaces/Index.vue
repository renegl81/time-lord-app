<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="translations.workspaces.plural" />
        <div class="flex flex-col gap-6 p-6">
            <div class="flex justify-between">
                <h1 class="text-2xl font-bold">{{ translations.workspaces.plural }}</h1>
                <Link
                    :href="route('workspaces.create')"
                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    {{ translations.actions.create }} {{ translations.workspaces.single }}
                </Link>
            </div>

            <div
                v-if="workspaces.length === 0"
                class="flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 p-12 text-center dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-700">
                    <svg class="h-6 w-6 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h2 class="mb-2 text-xl font-medium">No tienes espacios de trabajo</h2>
                <p class="mb-4 text-gray-500 dark:text-gray-400">Crea tu primer espacio de trabajo para comenzar a organizar tus proyectos y tareas.</p>
                <Link
                    :href="route('workspaces.create')"
                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Crear Espacio de Trabajo
                </Link>
            </div>
            <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="workspace in workspaces"
                    :key="workspace.id"
                    class="flex flex-col rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="mb-2 flex items-center justify-between">
                        <h3 class="text-lg font-medium">{{ workspace.name }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
              {{ workspace.hourly_rate && workspace.currency
                            ? `${workspace.hourly_rate} ${workspace.currency}/h`
                            : 'Sin tarifa definida' }}
            </span>
                    </div>
                    <div class="mt-auto flex justify-end gap-2 pt-4">
                        <Link
                            :href="route('workspaces.edit', workspace.id)"
                            class="rounded border border-gray-300 px-3 py-1 text-sm hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
                        >
                            Editar
                        </Link>
                        <Link
                            :href="route('workspaces.show', workspace.id)"
                            class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
                        >
                            Ver detalles
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { computed } from 'vue';

interface Workspace {
    id: number;
    name: string;
    hourly_rate: number | null;
    currency: string | null;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    workspaces: Workspace[];
}>();

const page = usePage();
// @ts-ignore
const { translations } = page.props as any;

const breadcrumbs = computed(() => [
    { title: translations.workspaces.plural, href: route('workspaces.index') },
]);
</script>
