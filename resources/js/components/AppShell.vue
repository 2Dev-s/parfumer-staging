<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { SharedData } from '@/types';

interface Props {
    variant?: 'header' | 'sidebar';
}

defineProps<Props>();

</script>

<template>
    <div class="">
        <slot />
    </div>
</template>
