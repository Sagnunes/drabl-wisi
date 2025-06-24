<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { imagePaths } from '@/constants/images_path';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img :src="imagePaths.logo.src" :alt="imagePaths.logo.alt">
</template>
