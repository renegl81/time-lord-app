<template>
    <div class="mx-auto max-w-2xl rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
        <form @submit.prevent="onSubmit">
        <div class="mb-4">
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nombre <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                v-model="data.name"
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                required
            />
            <div v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name }}</div>
        </div>

        <div class="mb-4">
            <label for="hourly_rate" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Tarifa por hora
            </label>
            <input
                type="number"
                id="hourly_rate"
                v-model="data.hourly_rate"
                min="0"
                step="0.01"
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
            <div v-if="errors.hourly_rate" class="mt-1 text-sm text-red-500">{{ errors.hourly_rate }}</div>
        </div>

        <div class="mb-4">
            <label for="currency" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Moneda
            </label>
            <select
                id="currency"
                v-model="data.currency"
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            >
                <option value="">Seleccionar moneda</option>
                <option value="USD">USD - Dólar estadounidense</option>
                <option value="EUR">EUR - Euro</option>
                <option value="MXN">MXN - Peso mexicano</option>
                <option value="COP">COP - Peso colombiano</option>
                <option value="ARS">ARS - Peso argentino</option>
            </select>
            <div v-if="errors.currency" class="mt-1 text-sm text-red-500">{{ errors.currency }}</div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a
            :href="cancelHref"
            class="rounded border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
            >
            Cancelar
        </a>
        <button
            type="submit"
        :disabled="processing"
        class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
        >
        {{ submitButtonText }}
    </button>
</div>
</form>
</div>
</template>

<script setup lang="ts">
    interface FormData {
    name: string;
    hourly_rate: string | null;
    currency: string | null;
    settings?: Record<string, any>;
}

    defineProps<{
    data: FormData;
    setData: (key: string, value: any) => void;
    errors: Record<string, string>;
    processing: boolean;
    onSubmit: (e: Event) => void;
    submitButtonText: string;
    cancelHref: string;
    }>();
</script>
