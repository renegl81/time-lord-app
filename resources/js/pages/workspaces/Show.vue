<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`${workspace.name} - Espacio de Trabajo`" />

        <div class="flex flex-col gap-6 p-6">
            <div class="flex justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ workspace.name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ workspace.hourly_rate && workspace.currency
                        ? `Tarifa: ${workspace.hourly_rate} ${workspace.currency}/h`
                        : 'Sin tarifa definida' }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <Link
                        :href="`/workspaces/${workspace.id}/edit`"
                        class="rounded border border-gray-300 px-3 py-1 text-sm hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
                    >
                        Editar
                    </Link>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex">
                    <button
                        @click="activeTab = 'overview'"
                        :class="[
              'mr-2 border-b-2 px-4 py-2 text-sm font-medium',
              activeTab === 'overview'
                ? 'border-blue-500 text-blue-600 dark:text-blue-400'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
            ]"
                    >
                        Resumen
                    </button>
                    <button
                        @click="activeTab = 'projects'"
                        :class="[
              'mr-2 border-b-2 px-4 py-2 text-sm font-medium',
              activeTab === 'projects'
                ? 'border-blue-500 text-blue-600 dark:text-blue-400'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
            ]"
                    >
                        Proyectos ({{ workspace.projects.length }})
                    </button>
                    <button
                        @click="activeTab = 'clients'"
                        :class="[
              'mr-2 border-b-2 px-4 py-2 text-sm font-medium',
              activeTab === 'clients'
                ? 'border-blue-500 text-blue-600 dark:text-blue-400'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
            ]"
                    >
                        Clientes ({{ workspace.clients.length }})
                    </button>
                    <button
                        @click="activeTab = 'users'"
                        :class="[
              'mr-2 border-b-2 px-4 py-2 text-sm font-medium',
              activeTab === 'users'
                ? 'border-blue-500 text-blue-600 dark:text-blue-400'
                : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
            ]"
                    >
                        Usuarios ({{ workspace.users.length }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="mt-4">
                <WorkspaceOverview
                    v-if="activeTab === 'overview'"
                    :workspace="workspace"
                    @tab-change="activeTab = $event"
                />

                <WorkspaceProjects
                    v-if="activeTab === 'projects'"
                    :workspace="workspace"
                />

                <WorkspaceClients
                    v-if="activeTab === 'clients'"
                    :workspace="workspace"
                />

                <WorkspaceUsers
                    v-if="activeTab === 'users'"
                    :workspace="workspace"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import WorkspaceUsers from '@/pages/workspaces/components/WorkspaceUsers.vue';
import WorkspaceClients from '@/pages/workspaces/components/WorkspaceClients.vue';
import WorkspaceProjects from '@/pages/workspaces/components/WorkspaceProjects.vue';
import WorkspaceOverview from '@/pages/workspaces/components/WorkspaceOverview.vue';

interface User {
    id: number;
    name: string;
    email: string;
    role?: string;
    pivot?: {
        role: string;
    };
}

interface Client {
    id: number;
    name: string;
    email: string;
    phone?: string;
}

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
    hourly_rate: number | null;
    currency: string | null;
    users: User[];
    clients: Client[];
    projects: Project[];
}

const props = defineProps<{
    workspace: Workspace;
}>();

const activeTab = ref('overview');

const breadcrumbs = computed(() => [
    { title: 'Espacios de Trabajo', href: '/workspaces' },
    { title: props.workspace.name, href: `/workspaces/${props.workspace.id}` },
]);
</script>
