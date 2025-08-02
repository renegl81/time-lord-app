<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="`${translations.actions.edit} ${workspace.name}`" />

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Editar espacio de trabajo</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Modifica los detalles del espacio de trabajo
            </p>
        </div>

        <WorkspaceForm
        :data="data"
        :setData="setData"
        :errors="errors"
        :processing="processing"
        :onSubmit="handleSubmit"
        submitButtonText="Actualizar"
        :cancelHref="route('workspaces.show', workspace.id)"
        />
    </div>
</AppLayout>
</template>

<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import { usePage } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import WorkspaceForm from './components/WorkspaceForm.vue';

    interface Workspace {
    id: number;
    name: string;
    hourly_rate?: string | number;
    currency?: string;
    settings?: Record<string, any>;
}

    const props = defineProps<{
    workspace: Workspace;
    }>();

    const page = usePage();
    const translations = page.props.translations;

    const { data, setData, put, processing, errors } = useForm({
    name: props.workspace.name,
    hourly_rate: props.workspace.hourly_rate?.toString() || null,
    currency: props.workspace.currency || null,
    settings: props.workspace.settings || {},
});

    const handleSubmit = (e: Event) => {
    e.preventDefault();
    put(route('workspaces.update', props.workspace.id));
};

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Editar', href: route('workspaces.edit', props.workspace.id) },
    ];
</script>
