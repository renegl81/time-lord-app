<template>
    <div :class="className">
    <h2 class="text-lg font-medium">{{ title }}</h2>
    <Link
        v-if="buttonText && (buttonHref || buttonOnClick)"
    :href="buttonHref || '#'"
    @click="handleClick"
    :class="buttonClassName"
    >
    {{ buttonText }}
</Link>
</div>
</template>

<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';

    interface Props {
    title: string;
    buttonText?: string;
    buttonHref?: string;
    buttonOnClick?: () => void;
    className?: string;
    buttonClassName?: string;
}

    const props = withDefaults(defineProps<Props>(), {
    className: "mb-4 flex justify-between",
    buttonClassName: "rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700"
});

    const handleClick = (e: Event) => {
        if (!props.buttonHref) {
        e.preventDefault();
    }

        if (props.buttonOnClick) {
        props.buttonOnClick();
    }
    };
</script>
