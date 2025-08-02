<template>
    <div class="space-y-6">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-2 text-lg font-medium">Proyectos</h3>
                <div class="text-3xl font-bold">{{ workspace.projects.length }}</div>
                <button
                    @click="$emit('tab-change', 'projects')"
                    class="mt-4 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                >
                    Ver todos los proyectos →
                </button>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-2 text-lg font-medium">Clientes</h3>
                <div class="text-3xl font-bold">{{ workspace.clients.length }}</div>
                <button
                    @click="$emit('tab-change', 'clients')"
                    class="mt-4 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                >
                    Ver todos los clientes →
                </button>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-2 text-lg font-medium">Usuarios</h3>
                <div class="text-3xl font-bold">{{ workspace.users.length }}</div>
                <button
                    @click="$emit('tab-change', 'users')"
                    class="mt-4 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400"
                >
                    Ver todos los usuarios →
                </button>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-medium">Actividad reciente</h3>
            <div v-if="activities.length === 0" class="py-4 text-center text-gray-500">
                No hay actividad reciente
            </div>
            <ul v-else class="space-y-4">
                <li v-for="(activity, index) in activities" :key="index" class="border-b border-gray-100 pb-4 last:border-0 dark:border-gray-700">
                    {{ activity.message }}
                    <div class="mt-1 text-sm text-gray-500">
                        {{ formatDate(activity.created_at) }}
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    workspace: {
        id: number;
        name: string;
        projects: any[];
        clients: any[];
        users: any[];
    };
}>();

defineEmits<{
    (e: 'tab-change', tab: string): void;
}>();

// Datos simulados para actividad reciente
const activities = computed(() => [
    { message: 'Proyecto "Landing Page" creado', created_at: '2023-06-15T10:30:00' },
    { message: 'Usuario "Juan Pérez" añadido', created_at: '2023-06-14T15:20:00' },
    { message: 'Cliente "Acme Inc" actualizado', created_at: '2023-06-12T09:45:00' }
]);

function formatDate(dateString: string): string {
    return new Date(dateString).toLocaleDateString('es-ES', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>
