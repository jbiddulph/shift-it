<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" color="#ffffff" width="24" height="22"><path d="M19 3h-1a7.973 7.973 0 0 0-6 2.727A7.973 7.973 0 0 0 6 3H5V0L0 5.113 5 10V7h1a4 4 0 0 1 4 4v11h4V11a4 4 0 0 1 4-4h1v3l5-4.887L19 0z" fill="#c43965"/></svg>
</template>
