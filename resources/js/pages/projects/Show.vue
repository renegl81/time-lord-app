<template>
    <AppLayout :breadcrumbs="breadcrumbs">
    <Head :title="`${project.name} - Proyecto`" />

    <div class="flex flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="h-6 w-6 rounded-full"
                :style="{ backgroundColor: project.color }"
                />
                <div>
                    <h1 class="text-2xl font-bold">{{ project.name }}</h1>
                    <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <span :class="`inline-block rounded px-2 py-0.5 text-xs font-semibold ${
                        project.status === 'active'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                            : project.status === 'completed'
                                ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                    }`">
                        {{ project.status === 'active' ? 'Activo' :
                                project.status === 'completed' ? 'Completado' : 'Pendiente' }}
                    </span>
                    <span v-if="project.client">
                Cliente: <Link :href="route('clients.show', { id: project.client.id })" class="hover:underline">{{ project.client.name }}</Link>
                </span>
            </div>
        </div>
    </div>

    <div class="flex gap-2">
        <Link
        :href="route('projects.edit', {workspace: project.workspace.id, project: project.id })"
        class="rounded border border-gray-300 px-3 py-1 text-sm hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700"
        >
        Editar
    </Link>
</div>
</div>

<!-- Tabs -->
<div class="border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex">
        <button
        @click="activeTab = 'overview'"
        :class="`mr-2 border-b-2 px-4 py-2 text-sm font-medium ${
        activeTab === 'overview'
            ? 'border-blue-500 text-blue-600 dark:text-blue-400'
            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
    }`"
        >
        Resumen
    </button>
    <button
    @click="activeTab = 'tasks'"
    :class="`mr-2 border-b-2 px-4 py-2 text-sm font-medium ${
    activeTab === 'tasks'
        ? 'border-blue-500 text-blue-600 dark:text-blue-400'
        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
}`"
    >
    Tareas ({{ project.tasks.length }})
</button>
<button
            @click="activeTab = 'time'"
:class="`mr-2 border-b-2 px-4 py-2 text-sm font-medium ${
activeTab === 'time'
    ? 'border-blue-500 text-blue-600 dark:text-blue-400'
    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
}`"
          >
            Tiempo
          </button>
          <button
            @click="activeTab = 'members'"
            :class="`mr-2 border-b-2 px-4 py-2 text-sm font-medium ${
    activeTab === 'members'
        ? 'border-blue-500 text-blue-600 dark:text-blue-400'
        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300'
}`"
          >
            Miembros ({{ project.users.length }})
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="mt-4">
        <ProjectOverview
          v-if="activeTab === 'overview'"
          :project="project"
          @tab-change="setActiveTab"
        />
        <ProjectTasks
          v-if="activeTab === 'tasks'"
          :project="project"
        />
        <ProjectTime
          v-if="activeTab === 'time'"
          :project="project"
        />
        <ProjectMembers
          v-if="activeTab === 'members'"
          :project="project"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import ProjectOverview from './components/ProjectOverview.vue';
import ProjectTasks from './components/ProjectTasks.vue';
import ProjectTime from './components/ProjectTime.vue';
import ProjectMembers from './components/ProjectMembers.vue';
import { type Project } from "@/types/project";

interface Props {
  project: Project;
}

const props = defineProps<Props>();
const activeTab = ref('overview');

const breadcrumbs = [
  { title: 'Espacios de Trabajo', href: route('workspaces.index') },
  { title: props.project.workspace.name, href: route('workspaces.show', props.project.workspace.id) },
  { title: 'Proyectos', href: route('projects.index', { workspace: props.project.workspace.id }) },
  { title: props.project.name, href: route('projects.show', { workspace: props.project.workspace.id, project: props.project.id }) },
];

const setActiveTab = (tab: string) => {
  activeTab.value = tab;
};
</script>
