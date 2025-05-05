<template>
    <div class="h-screen flex flex-col lg:flex-row">
        <div
            class="relative flex-1 overflow-hidden"
            data-aos="fade-right"
            data-aos-delay="300"
        >
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent z-10"></div>
            <img
                src="https://img.freepik.com/free-photo/bride-holds-bottle-parfume-her-tender-arms_8353-7217.jpg?t=st=1746211598~exp=1746215198~hmac=1dce2d00b7725ff60906507c85511969826d008859851a2a0c3fba9fa2111fce&w=740"
                class="w-full h-full object-cover object-center transform transition-transform duration-500"
                alt="Luxury women's perfume"
            />
<!--            <div class="absolute bottom-8 left-8 right-8 z-20 space-y-6">-->
        <div class="absolute bottom-8 left-8 right-8 z-20 space-y-6 lg:bottom-[25%]">
                <h2 class="text-5xl font-bold text-white tracking-tighter leading-none">
                    Esența<br>Feminității
                </h2>
                <p class="text-lg text-white/80 font-light max-w-md">
                    Descoperă parfumuri care dansează între florale delicate și intensitate captivantă
                </p>
                <a href="/parfumuri?sex=female" class="bg-white/10 backdrop-blur-lg px-8 py-4 rounded-full text-white font-semibold hover:bg-white/20 transition-all">
                    Explorează Colecția →
                </a>
            </div>
        </div>

        <div
            class="relative flex-1 overflow-hidden group"
            data-aos="fade-left"
            data-aos-delay="300"
        >
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent z-10"></div>
            <img
                src="https://img.freepik.com/premium-photo/sexy-guy-perfume_160204-613.jpg?w=740"
                class="w-full h-full object-cover object-center transform transition-transform duration-500"
                alt="Premium men's perfume"
            />
<!--            <div class="absolute bottom-8 right-8 text-right z-20 space-y-6 max-w-md ml-auto">-->
        <div class="absolute bottom-8 right-8 text-right z-20 space-y-6 max-w-md ml-auto lg:bottom-[25%]">

                <h2 class="text-5xl font-bold text-white tracking-tighter leading-none">
                    Personaj<br>Îndrăzneț
                </h2>
                <p class="text-lg text-white/80 font-light">
                    Parfumuri care întruchipează puterea și rafinamentul într-o armonie perfectă
                </p>
                <div class="flex justify-end">
                    <a href="/parfumuri?sex=male" class="bg-white/10 backdrop-blur-lg px-8 py-4 rounded-full text-white font-semibold hover:bg-white/20 transition-all">
                        Descoperă Parfumurile →
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>

<style>
/* Add custom scroll behavior for smooth hover effect */
html {
    scroll-behavior: smooth;
    overflow: hidden;
}

/* Custom gradient overlay */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}
</style>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
