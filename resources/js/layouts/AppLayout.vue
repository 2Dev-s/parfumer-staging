<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
</script>

<template>
    <main class="min-h-screen flex flex-col">
        <Navbar />

        <section class="flex-1">
            <div class="mx-auto w-full">
                <slot />
            </div>
        </section>
    </main>
</template>
