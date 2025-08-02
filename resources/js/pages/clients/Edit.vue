<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="`Editar ${client.name}`" />

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Editar Cliente</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Actualiza la información del cliente
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium">Nombre</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 p-2.5 dark:border-gray-600 dark:bg-gray-700"
                        required
                    />
                    <div v-if="errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.name }}</div>
                </div>

                <div>
                    <label for="contact_info" class="mb-2 block text-sm font-medium">Información de Contacto</label>
                    <textarea
                        id="contact_info"
                        v-model="form.contact_info"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 p-2.5 dark:border-gray-600 dark:bg-gray-700"
                    ></textarea>
                    <div v-if="errors.contact_info" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.contact_info }}</div>
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-2 block text-sm font-medium">Dirección</label>
                    <textarea
                        id="address"
                        v-model="form.address"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 p-2.5 dark:border-gray-600 dark:bg-gray-700"
                    ></textarea>
                    <div v-if="errors.address" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ errors.address }}</div>
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <Link
            :href="route('clients.show', [workspace.id, client.id])"
            class="rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-600"
            >
            Cancelar
        </Link>

        <button
            type="submit"
            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
        :disabled="processing"
        >
        {{ processing ? 'Guardando...' : 'Guardar Cambios' }}
    </button>
</div>
</form>
</div>
</AppLayout>
</template>

<script setup lang="ts">
    import { reactive } from 'vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import type { Client } from '@/types/client';
    import type { Workspace } from '@/types/workspace';

    interface Props {
    workspace: Workspace;
    client: Client;
    errors: Record<string, string>;
}

    const props = defineProps<Props>();

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Clientes', href: route('clients.index', props.workspace.id) },
    { title: props.client.name, href: route('clients.show', [props.workspace.id, props.client.id]) },
    { title: 'Editar', href: route('clients.edit', [props.workspace.id, props.client.id]) },
    ];

    const form = useForm({
        name: props.client.name,
        address: props.client.address || '',
        contact_info: props.client.contact_info || ''
    });

    const processing = form.processing;

    const submit = () => {
        form.put(route('clients.update', [props.workspace.id, props.client.id]));
    };
</script>
