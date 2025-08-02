<template>
    <div>
        <SectionHeader
            title="Clientes"
            buttonText="Nuevo Cliente"
        :buttonHref="route('clients.create', {workspace: workspace.id})"
        />

        <div v-if="workspace.clients.length === 0"
             class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
            <p class="text-gray-500 dark:text-gray-400">No hay clientes en este espacio de trabajo.</p>
            <Link
            :href="route('clients.create', {workspace: workspace.id})"
            class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
            >
            Crear Primer Cliente
        </Link>
    </div>
    <div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <ClientCard
            v-for="client in workspace.clients"
        :key="client.id"
        :client="client"
        />
    </div>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import ClientCard from './ClientCard.vue';
    import SectionHeader from '@/components/admin/SectionHeader.vue';

    interface Client {
    id: number;
    name: string;
    email: string;
    phone?: string;
}

    interface Workspace {
    id: number;
    name: string;
    clients: Client[];
}

    defineProps<{
    workspace: Workspace;
    }>();
</script>
