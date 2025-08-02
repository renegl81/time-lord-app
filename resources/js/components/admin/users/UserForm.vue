<template>
    <div :class="`rounded-lg border border-gray-200 p-6 shadow-sm dark:border-gray-700 ${className}`">
    <h2 class="mb-4 text-xl font-semibold">
        {{ isEdit ? 'Editar Usuario' : 'Nuevo Usuario' }}
    </h2>
    <form @submit.prevent="handleSubmit">
    <div :class="`mb-4 grid gap-4 ${isEdit ? '' : 'md:grid-cols-2'}`">
    <div>
        <label class="mb-1 block">Nombre</label>
        <input
            type="text"
            v-model="data.name"
            class="w-full rounded border p-2 dark:bg-gray-700"
        />
        <div v-if="errors.name" class="text-sm text-red-500">{{ errors.name }}</div>
    </div>
    <div>
        <label class="mb-1 block">Email</label>
        <input
            type="email"
            v-model="data.email"
            class="w-full rounded border p-2 dark:bg-gray-700"
        />
        <div v-if="errors.email" class="text-sm text-red-500">{{ errors.email }}</div>
    </div>
    <div>
        <label class="mb-1 block">
            {{ isEdit ? 'Contraseña (dejar en blanco para mantener)' : 'Contraseña' }}
        </label>
        <input
            type="password"
            v-model="data.password"
            class="w-full rounded border p-2 dark:bg-gray-700"
        :required="!isEdit"
        />
        <div v-if="errors.password" class="text-sm text-red-500">{{ errors.password }}</div>
    </div>
    <div>
        <label class="mb-1 block">Rol</label>
        <select
            v-model="data.role"
            class="w-full rounded border p-2 dark:bg-gray-700"
        >
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select>
    </div>
</div>
<div class="flex justify-end gap-2">
    <button
        type="button"
    @click="onCancel"
    class="rounded border px-4 py-2 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
    >
    Cancelar
</button>
<button
    type="submit"
          :disabled="processing"
class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
    >
    {{ isEdit ? 'Actualizar' : 'Guardar' }}
</button>
</div>
</form>
</div>
</template>

<script setup lang="ts">
    import { useForm } from '@inertiajs/vue3';
    import { computed, watch } from 'vue';

    interface User {
    id?: number;
    name: string;
    email: string;
    role: string;
}

    interface Props {
    user?: User;
    mode: 'create' | 'edit';
    onCancel: () => void;
    className?: string;
}

    const props = withDefaults(defineProps<Props>(), {
    className: ''
});

    const isEdit = computed(() => props.mode === 'edit');

    const { data, setData, post, put, processing, errors, reset } = useForm({
        name: props.user?.name || '',
        email: props.user?.email || '',
        password: '',
        role: props.user?.role || 'user',
    });

    // Restablecer formulario cuando cambia el usuario en modo edición
    watch(() => props.user, (newUser) => {
        if (isEdit.value && newUser) {
        setData({
        name: newUser.name,
        email: newUser.email,
        password: '',
        role: newUser.role,
    });
    }
    }, { deep: true });

    const handleSubmit = () => {
        if (isEdit.value && props.user?.id) {
        put(`/admin/users/${props.user.id}`, {
        onSuccess: () => {
        props.onCancel();
    },
    });
    } else {
        post('/admin/users', {
        onSuccess: () => {
        reset();
        props.onCancel();
    },
    });
    }
    };
</script>
