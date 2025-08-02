<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Gestión de Usuarios" />
    <div class="flex flex-col gap-6 p-6">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
            <button
            @click="addingNew = true"
            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
            Agregar Usuario
        </button>
    </div>

    <UserForm
        v-if="addingNew"
        mode="create"
    :onCancel="() => addingNew = false"
    />

    <div class="rounded-lg border border-gray-200 shadow-sm dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Nombre
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Email
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Rol
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Fecha creación
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    Acciones
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
            <tr v-for="user in users.data" :key="user.id">
            <td class="whitespace-nowrap px-6 py-4">{{ user.name }}</td>
            <td class="whitespace-nowrap px-6 py-4">{{ user.email }}</td>
            <td class="whitespace-nowrap px-6 py-4">
                <span
                :class="`inline-block rounded px-2 py-1 text-xs font-semibold ${
                user.role === 'admin'
                    ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                    : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
            }`"
                >
                {{ user.role === 'admin' ? 'Administrador' : 'Usuario' }}
            </span>
            </td>
            <td class="whitespace-nowrap px-6 py-4">
                {{ new Date(user.created_at).toLocaleDateString() }}
            </td>
            <td class="whitespace-nowrap px-6 py-4 text-right">
                <button
                @click="editing = user"
                class="mr-2 rounded bg-gray-100 px-3 py-1 text-sm hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600"
                >
                Editar
            </button>
            <button
            @click="deleteUser(user)"
            class="rounded bg-red-100 px-3 py-1 text-sm text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800"
            >
            Eliminar
        </button>
    </td>
</tr>
</tbody>
</table>
</div>

<div v-if="users.last_page > 1" class="py-2">
    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
        <div>
            Mostrando {{ users.from }} a {{ users.to }} de {{ users.total }} resultados
        </div>
    </div>
    <Pagination :links="users.links" />
</div>
</div>

<div
    v-if="editing"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
>
    <div class="w-full max-w-md">
        <UserForm
        :user="editing"
        mode="edit"
        :onCancel="() => editing = null"
        className="bg-white dark:bg-gray-800"
        />
    </div>
</div>
</AppLayout>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { Head, router } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import UserForm from '@/components/admin/users/UserForm.vue';
    import Pagination from '@/components/common/pagination.vue';

    interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
}

    interface LaravelPagination {
    current_page: number;
    data: User[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Array<{
    url: string | null;
    label: string;
    active: boolean;
}>;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

    const props = defineProps<{
    users: LaravelPagination;
    }>();

    const editing = ref<User | null>(null);
    const addingNew = ref(false);

    const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Gestión de Usuarios', href: '/admin/users' },
    ];

    const deleteUser = (user: User) => {
    if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
    router.delete(`/admin/users/${user.id}`);
}
};
</script>
