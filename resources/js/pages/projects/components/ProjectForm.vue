<template>
    <div class="mx-auto w-full max-w-3xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <form @submit.prevent="$emit('submit')">
        <div class="mb-6">
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nombre del Proyecto *
            </label>
            <input
                type="text"
                id="name"
                v-model="data.name"
                class="w-full rounded-md border"
            :class="errors.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
            placeholder="Nombre del proyecto"
            required
            />
            <p v-if="errors.name" class="mt-1 text-xs text-red-500">{{ errors.name }}</p>
        </div>

        <div class="mb-6">
            <label for="description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Descripción (opcional)
            </label>
            <textarea
                id="description"
                v-model="data.description"
                class="w-full rounded-md border"
            :class="errors.description ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
            placeholder="Descripción del proyecto"
            rows="3"
            ></textarea>
        <p v-if="errors.description" class="mt-1 text-xs text-red-500">{{ errors.description }}</p>
    </div>

    <div class="mb-6">
        <label for="client_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Cliente (opcional)
        </label>
        <select
            id="client_id"
            v-model="data.client_id"
            class="w-full rounded-md border"
        :class="errors.client_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
        >
        <option value="">Sin cliente</option>
        <option v-for="client in clients" :key="client.id" :value="client.id">
        {{ client.name }}
    </option>
</select>
<p v-if="errors.client_id" class="mt-1 text-xs text-red-500">{{ errors.client_id }}</p>
</div>

<div class="mb-6 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    <div>
        <label for="hourly_rate" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Tarifa por Hora (opcional)
        </label>
        <input
            type="number"
            min="0"
            step="0.01"
            id="hourly_rate"
            v-model="data.hourly_rate"
            class="w-full rounded-md border"
        :class="errors.hourly_rate ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
        placeholder="0.00"
        />
        <p v-if="errors.hourly_rate" class="mt-1 text-xs text-red-500">{{ errors.hourly_rate }}</p>
    </div>

    <div>
        <label for="estimate" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Estimación de horas (opcional)
        </label>
        <input
            type="number"
            min="0"
            step="0.01"
            id="estimate"
            v-model="data.estimate"
            class="w-full rounded-md border"
        :class="errors.estimate ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
        placeholder="0.00"
        />
        <p v-if="errors.estimate" class="mt-1 text-xs text-red-500">{{ errors.estimate }}</p>
    </div>

    <div>
        <label for="budget" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
            Presupuesto (opcional)
        </label>
        <input
            type="number"
            min="0"
            step="0.01"
            id="budget"
            v-model="data.budget"
            class="w-full rounded-md border"
        :class="errors.budget ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
        placeholder="0.00"
        />
        <p v-if="errors.budget" class="mt-1 text-xs text-red-500">{{ errors.budget }}</p>
    </div>
</div>

<div class="mb-6">
    <label for="color" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
        Color (opcional)
    </label>
    <div class="flex items-center gap-2">
        <input
            type="color"
            id="color"
            v-model="data.color"
            class="h-10 w-10 rounded border border-gray-300 p-1 dark:border-gray-600"
        />
        <input
            type="text"
            v-model="data.color"
            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        />
    </div>
    <p v-if="errors.color" class="mt-1 text-xs text-red-500">{{ errors.color }}</p>
</div>

<div class="mb-6 flex flex-wrap gap-6">
    <div class="flex items-center">
        <input
            type="checkbox"
            id="is_billable"
            v-model="data.is_billable"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
        />
        <label for="is_billable" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
            Facturable
        </label>
    </div>

    <div class="flex items-center">
        <input
            type="checkbox"
            id="is_public"
            v-model="data.is_public"
            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
        />
        <label for="is_public" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
            Público
        </label>
    </div>
</div>

<div class="flex justify-end gap-2 pt-4">
    <Link
    :href="cancelHref"
    class="rounded border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
    >
    Cancelar
</Link>
<button
    type="submit"
          :disabled="processing"
class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-75"
    >
    {{ processing ? 'Procesando...' : submitButtonText }}
</button>
</div>
</form>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { type Client } from '@/types/client';

    interface ProjectFormProps {
    data: {
    name: string;
    description: string;
    client_id: string;
    hourly_rate: string;
    estimate: string;
    budget: string;
    color: string;
    is_billable: boolean;
    is_public: boolean;
    [key: string]: any;
};
    errors: Record<string, string>;
    processing: boolean;
    clients: Client[];
    submitButtonText: string;
    cancelHref: string;
}

    defineProps<ProjectFormProps>();
    defineEmits<{
    (e: 'submit'): void;
    }>();
</script>
