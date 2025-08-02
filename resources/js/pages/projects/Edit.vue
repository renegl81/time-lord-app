<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="`Editar ${project.name}`" />

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Editar proyecto</h1>
            <p class="text-gray-500 dark:text-gray-400">
                Modifica los detalles del proyecto {{ project.name }}
            </p>
        </div>

        <ProjectForm
        :data="form"
        :errors="form.errors"
        :processing="form.processing"
        :clients="clients"
        @submit="handleSubmit"
        submit-button-text="Actualizar Proyecto"
        :cancel-href="route('projects.show', { workspace: workspace.id, project: project.id })"
        />
    </div>
</AppLayout>
</template>

<script setup lang="ts">
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type Project } from '@/types/project';
    import { type Workspace } from '@/types/workspace';
    import { type Client } from '@/types/client';
    import ProjectForm from './components/ProjectForm.vue';

    interface Props {
    workspace: Workspace;
    clients: Client[];
    project: Project;
}

    const props = defineProps<Props>();

    const form = useForm({
        name: props.project.name,
        description: props.project.description || '',
        client_id: props.project.client_id ? props.project.client_id.toString() : '',
        hourly_rate: props.project.hourly_rate?.toString() || '',
        estimate: props.project.estimate?.toString() || '',
        budget: props.project.budget?.toString() || '',
        color: props.project.color || '#3B82F6',
        is_billable: props.project.is_billable,
        is_public: props.project.is_public,
    });

    const handleSubmit = () => {
        form.put(route('projects.update', { workspace: props.workspace.id, project: props.project.id }));
    };

    const breadcrumbs = [
    { title: 'Espacios de Trabajo', href: route('workspaces.index') },
    { title: props.workspace.name, href: route('workspaces.show', props.workspace.id) },
    { title: 'Proyectos', href: route('projects.index', props.workspace.id) },
    { title: props.project.name, href: route('projects.show', { workspace: props.workspace.id, project: props.project.id }) },
    { title: 'Editar', href: route('projects.edit', { workspace: props.workspace.id, project: props.project.id }) },
    ];
</script>
