<template>
    <nav :class="`flex items-center justify-center mt-6 ${className}`">
    <ul class="flex flex-wrap">
        <li v-for="(link, index) in links" :key="index" class="mx-1">
        <!-- Enlace desactivado -->
        <span
            v-if="link.url === null"
            class="px-3 py-2 text-sm rounded bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500"
            v-html="link.label"
        ></span>

        <!-- Enlace activo -->
        <Link
            v-else
        :href="link.url"
        :class="`px-3 py-2 text-sm rounded ${
        link.active
            ? 'bg-blue-600 text-white'
            : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
    }`"
        v-html="link.label"
        />
    </li>
</ul>
</nav>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

    interface Props {
    links: PaginationLink[];
    className?: string;
}

    withDefaults(defineProps<Props>(), {
    className: ''
});
</script>
