<template>
    <div>
        <div class="mb-4 flex justify-between">
            <h2 class="text-lg font-medium">Miembros del Proyecto</h2>
            <Link
            :href="`/projects/${project.id}/members/add`"
            class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
            >
            Añadir Miembros
        </Link>
    </div>

    <div v-if="project.users.length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800">
        <p class="text-gray-500 dark:text-gray-400">No hay usuarios asignados a este proyecto.</p>
        <Link
        :href="`/projects/${project.id}/members/add`"
        class="mt-2 inline-block rounded bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
        >
        Añadir Miembros
    </Link>
</div>
<div v-else class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    <div
        v-for="user in project.users"
    :key="user.id"
    class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800"
    >
    <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-200">
            {{ getInitials(user.name) }}
        </div>
        <div>
            <h3 class="font-medium">{{ user.name }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</p>
        </div>
    </div>
    <div class="mt-2 flex justify-end">
        <button
        @click="removeUser(user)"
        class="text-sm text-red-600 hover:underline dark:text-red-400"
        >
        Eliminar
    </button>
</div>
</div>
</div>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
    import { type Project } from "@/types/project";

    interface Props {
    project: Project;
}

    const props = defineProps<Props>();

    const getInitials = (name: string) => {
        return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase();
    };

    const removeUser = (user: any) => {
        // Implementar la lógica para eliminar usuario
        console.log('Eliminar usuario:', user);
    };
</script>
