<template>
    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="text-lg font-medium">{{ client.name }}</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ client.email }}</p>
        <p v-if="client.phone" class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ client.phone }}</p>
        <div class="mt-4 flex justify-end">
            <Link
                :href="`/clients/${client.id}`"
                class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
            >
                Ver detalles
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Client {
    id: number;
    name: string;
    email: string;
    phone?: string;
}

defineProps<{
    client: Client;
}>();
</script>
