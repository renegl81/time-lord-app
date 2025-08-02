<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Crear Espacio de Trabajo" />
    <div class="flex flex-col gap-6 p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Crear Espacio de Trabajo</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Crea un nuevo espacio para gestionar tus proyectos y tareas
            </p>
        </div>

        <div class="mx-auto w-full max-w-2xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form @submit.prevent="handleSubmit">
            <div class="mb-6">
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nombre del Espacio de Trabajo *
                </label>
                <input
                    type="text"
                    id="name"
                    v-model="data.name"
                    class="w-full rounded-md border px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:bg-gray-700 dark:text-white"
                :class="errors.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                placeholder="Mi Espacio de Trabajo"
                required
                />
                <p v-if="errors.name" class="mt-1 text-xs text-red-500">{{ errors.name }}</p>
            </div>

            <div class="mb-6 grid gap-4 md:grid-cols-2">
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
                        class="w-full rounded-md border px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:bg-gray-700 dark:text-white"
                    :class="errors.hourly_rate ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    placeholder="0.00"
                    />
                    <p v-if="errors.hourly_rate" class="mt-1 text-xs text-red-500">{{ errors.hourly_rate }}</p>
                </div>

                <div>
                    <label for="currency" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Moneda (opcional)
                    </label>
                    <select
                        id="currency"
                        v-model="data.currency"
                        class="w-full rounded-md border px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 dark:bg-gray-700 dark:text-white"
                    :class="errors.currency ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    >
                    <option v-for="currency in currencies" :key="currency.code" :value="currency.code">
                    {{ currency.name }}
                </option>
            </select>
            <p v-if="errors.currency" class="mt-1 text-xs text-red-500">{{ errors.currency }}</p>
        </div>
    </div>

    <div class="flex justify-end gap-2 pt-4">
        <a
            href="/workspaces"
            class="rounded border border-gray-300 px-4 py-2 text-sm hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
        >
            Cancelar
        </a>
        <button
            type="submit"
        :disabled="processing"
        class="rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 disabled:opacity-75"
        >
        {{ processing ? 'Creando...' : 'Crear Espacio de Trabajo' }}
    </button>
</div>
</form>
</div>
</div>
</AppLayout>
</template>

<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: '/workspaces' },
    { title: 'Crear', href: '/workspaces/create' },
    ];

    const currencies = [
    { code: '', name: 'Seleccionar moneda' },
    { code: 'USD', name: 'USD - Dólar estadounidense' },
    { code: 'EUR', name: 'EUR - Euro' },
    { code: 'MXN', name: 'MXN - Peso mexicano' },
    { code: 'COP', name: 'COP - Peso colombiano' },
    { code: 'ARS', name: 'ARS - Peso argentino' },
    { code: 'CLP', name: 'CLP - Peso chileno' },
    ];

    const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    hourly_rate: '',
    currency: '',
});

    const handleSubmit = () => {
    post('/workspaces', {
        onSuccess: () => reset(),
    });
};
</script>
