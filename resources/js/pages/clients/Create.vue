<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Nuevo Cliente" />

        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Nuevo Cliente</h1>
                <p class="text-gray-500 dark:text-gray-400">
                    Crear un nuevo cliente para el espacio de trabajo {{ workspace.name }}
                </p>
            </div>

            <form @submit.prevent="handleSubmit" class="max-w-2xl">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nombre <span class="text-red-500">*</span>
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
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Dirección
                    </label>
                    <textarea
                        id="address"
                        v-model="form.address"
                        rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    ></textarea>
                    <div v-if="form.errors.address" class="mt-1 text-sm text-red-500">{{ form.errors.address }}</div>
                </div>

                <div class="mb-4">
                    <label for="contact_info" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Información de contacto
                    </label>
                    <textarea
                        id="contact_info"
                        v-model="form.contact_info"
                        rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    ></textarea>
                    <div v-if="form.errors.contact_info" class="mt-1 text-sm text-red-500">{{ form.errors.contact_info }}</div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        @click="() => window.history.back()"
                        class="rounded border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue.vue';
import { computed } from 'vue';
import type { Workspace } from '@/types/workspace';

const props = defineProps<{
    workspace: Workspace;
}>();

const form = useForm({
    name: '',
    address: '',
    contact_info: '',
});

const breadcrumbs = computed(() => [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Clientes', href: route('clients.index', props.workspace.id) },
    { title: 'Nuevo Cliente', href: route('clients.create', props.workspace.id) },
]);

function handleSubmit() {
    form.post(route('clients.store', props.workspace.id));
}
</script>
