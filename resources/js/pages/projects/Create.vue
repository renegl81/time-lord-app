<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Crear Proyecto" />

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Crear nuevo proyecto</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Crea un nuevo proyecto para el espacio de trabajo {{ workspace.name }}
            </p>
        </div>

        <ProjectForm
        :data="form"
        :errors="form.errors"
        :processing="form.processing"
        :clients="clients"
        @submit="handleSubmit"
        submit-button-text="Crear Proyecto"
        :cancel-href="route('projects.index', workspace.id)"
        />
    </div>
</AppLayout>
</template>

<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type Client } from '@/types/client';
    import { type Workspace } from '@/types/workspace';
    import ProjectForm from './components/ProjectForm.vue';

    interface Props {
    workspace: Workspace;
    clients: Client[];
}

    const props = defineProps<Props>();

    const form = useForm({
        name: '',
        description: '',
        client_id: '',
        hourly_rate: '',
        estimate: '',
        budget: '',
        color: '#3B82F6',
        is_billable: true,
        is_public: false,
    });

    const handleSubmit = () => {
        form.post(route('projects.store', props.workspace.id));
    };

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Proyectos', href: route('projects.index', props.workspace.id) },
    { title: 'Crear', href: route('projects.create', props.workspace.id) },
    ];
</script>
