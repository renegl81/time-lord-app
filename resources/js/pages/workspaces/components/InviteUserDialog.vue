<template>
    <Dialog v-model="isOpen">
        <DialogTrigger>
            <slot>
                <button class="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700">
                    Invitar Usuario
                </button>
            </slot>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Invitar usuario</DialogTitle>
                <DialogDescription>
                    Introduce el email del usuario que deseas invitar a este espacio de trabajo.
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="handleSubmit">
            <div class="my-4 space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium">
                        Email del usuario
                    </label>
                    <input
                        type="email"
                        id="email"
                        v-model="form.email"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        required
                    />
                    <div v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium">
                        Rol
                    </label>
                    <select
                        id="role"
                        v-model="form.role"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="member">Miembro</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            </div>

            <DialogFooter>
                <button
                    type="button"
                @click="isOpen = false"
                class="rounded border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                Cancelar
            </button>
            <button
                type="submit"
            :disabled="form.processing"
            class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
            >
            Invitar
        </button>
    </DialogFooter>
</form>
</DialogContent>
</Dialog>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import {
    Dialog,
    DialogTrigger,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from "@/components/ui/dialog";

    const props = defineProps<{
    workspaceId: number;
    onSuccess?: () => void;
    }>();

    const isOpen = ref(false);

    const form = useForm({
    email: '',
    role: 'member',
});

    const handleSubmit = () => {
    form.post(route('workspaces.invite', props.workspaceId), {
        onSuccess: () => {
            isOpen.value = false;
            form.reset();
            if (props.onSuccess) {
                props.onSuccess();
            }
        },
    });
};
</script>
