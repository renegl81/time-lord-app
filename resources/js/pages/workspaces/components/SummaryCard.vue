<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h2 class="mb-4 text-lg font-medium">{{ title }}</h2>
        <p v-if="isEmpty" class="text-gray-500 dark:text-gray-400">{{ emptyMessage }}</p>
        <div v-else>
            <p class="mb-2">{{ countLabel }}: <span class="font-medium">{{ count }}</span></p>
            <Link
                href="#"
            @click.prevent="onViewAll"
            class="text-blue-600 hover:underline dark:text-blue-400"
            >
            {{ viewAllLabel }}
        </Link>
    </div>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    defineProps<{
    title: string;
    isEmpty: boolean;
    emptyMessage: string;
    count?: number;
    countLabel: string;
    onViewAll: () => void;
    viewAllLabel: string;
    }>();
</script>
