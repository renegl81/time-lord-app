<template>
    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-4 text-lg font-medium">Detalles del Proyecto</h2>

            <div v-if="project.description" class="mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</h3>
                <p class="mt-1">{{ project.description }}</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente</h3>
                    <p class="mt-1">{{ project.client ? project.client.name : 'No asignado' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Creado el</h3>
                    <p class="mt-1">{{ new Date(project.created_at).toLocaleDateString() }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tarifa por hora</h3>
                    <p class="mt-1">{{ project.hourly_rate ? `${project.hourly_rate}€/h` : 'No definida' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Presupuesto</h3>
                    <p class="mt-1">{{ project.budget ? `${project.budget}€` : 'No definido' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Facturación</h3>
                    <p class="mt-1">{{ project.is_billable ? 'Facturable' : 'No facturable' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Visibilidad</h3>
                    <p class="mt-1">{{ project.is_public ? 'Público' : 'Privado' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-6 text-lg font-medium">Progreso del Proyecto</h2>

            <div class="mb-6">
                <div class="mb-1 flex justify-between">
                    <h3 class="text-sm font-medium">Tareas completadas</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ completedTasks }} de {{ project.tasks.length }}</span>
                </div>
                <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div
                        class="h-2 rounded-full bg-green-600"
                    :style="{ width: `${taskProgress}%` }"
                    ></div>
            </div>
            <button
            @click="$emit('tab-change', 'tasks')"
            class="mt-2 text-sm text-blue-600 hover:underline dark:text-blue-400"
            >
            Ver todas las tareas
        </button>
    </div>

    <div v-if="project.budget && project.budget > 0" class="mb-6">
        <div class="mb-1 flex justify-between">
            <h3 class="text-sm font-medium">Presupuesto utilizado</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">
            {{ budgetUsed.toFixed(2) }}€ de {{ project.budget }}€
          </span>
        </div>
        <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
            <div
            :class="`h-2 rounded-full ${budgetPercentage > 90 ? 'bg-red-600' : 'bg-blue-600'}`"
            :style="{ width: `${budgetPercentage}%` }"
            ></div>
    </div>
</div>

<div>
    <h3 class="mb-2 text-sm font-medium">Tiempo registrado</h3>
    <p class="text-2xl font-bold">{{ hoursSpent }}h {{ minutesSpent }}m</p>
    <p v-if="project.estimate" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        de {{ project.estimate }} horas estimadas ({{ Math.round((totalTimeSpent/60) / project.estimate * 100) }}%)
    </p>
    <button
    @click="$emit('tab-change', 'time')"
    class="mt-2 text-sm text-blue-600 hover:underline dark:text-blue-400"
    >
    Ver registro de tiempo
</button>
</div>
</div>
</div>
</template>

<script setup lang="ts">
    import { computed } from 'vue';
    import type { Project } from "@/types/project";
    import type { TimeEntry } from "@/types/timeEntry";

    interface Props {
    project: Project;
}

    const props = defineProps<Props>();

    defineEmits<{
    (e: 'tab-change', tab: string): void;
    }>();

    // Cálculo de estadísticas
    const totalTimeSpent = computed(() =>
    props.project.time_entries?.length
    ? props.project.time_entries.reduce((total: number, entry: TimeEntry) => total + entry.duration, 0)
    : 0
    );

    const hoursSpent = computed(() => Math.floor(totalTimeSpent.value / 60));
    const minutesSpent = computed(() => totalTimeSpent.value % 60);

    const completedTasks = computed(() =>
    props.project.tasks.filter(task => task.status === 'completed').length
    );

    const taskProgress = computed(() =>
    props.project.tasks.length > 0
    ? Math.round((completedTasks.value / props.project.tasks.length) * 100)
    : 0
    );

    const budgetUsed = computed(() =>
    props.project.hourly_rate
    ? (totalTimeSpent.value / 60) * props.project.hourly_rate
    : 0
    );

    const budgetPercentage = computed(() =>
    props.project.budget && props.project.budget > 0
    ? Math.min(Math.round((budgetUsed.value / props.project.budget) * 100), 100)
    : 0
    );
</script>
