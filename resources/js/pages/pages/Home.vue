<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative h-screen-90 flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-black/30 z-10"></div>
            <video
                autoplay
                loop
                muted
                playsinline
                class="absolute inset-0 w-full h-full object-cover object-center"
            >
                <source src="https://videocdn.cdnpk.net/videos/20d03e61-9675-4de9-b77b-45e83a2f1e96/horizontal/previews/clear/large.mp4?token=exp=1746215298~hmac=5114e00434dba2d514bc1b8685f5904800093f19f08f82f949379e5817cccd24" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="relative z-20 text-center px-6 max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif font-light text-white mb-6 leading-tight">
                    Arta <span class="font-bold">Aromei</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-10 font-light max-w-2xl mx-auto">
                    Descoperă colecția noastră exclusivă de parfumuri artizanale care spun povestea ta unică
                </p>
                <button class="bg-white/10 backdrop-blur-lg border border-white/20 text-white px-10 py-4 rounded-full hover:bg-white/20 transition-all duration-300 text-lg font-medium">
                    Explorează Colecțiile
                </button>
            </div>
        </section>

        <!-- Featured Collections -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-serif font-light text-gray-900 mb-4">
                        <span class="font-bold">Colecțiile</span> noastre
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Parfumuri atent selecționate pentru fiecare ocazie și personalitate
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        v-for="collection in collections"
                        :key="collection.id"
                        class="group relative overflow-hidden rounded-lg aspect-square"
                    >
                        <img
                            :src="collection.image"
                            :alt="collection.name"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent flex items-end p-6">
                            <div>
                                <h3 class="text-2xl font-medium text-white mb-2">{{ collection.name }}</h3>
                                <button class="text-white/90 hover:text-white text-sm font-medium flex items-center gap-2 transition-all">
                                    Descoperă
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Signature Scent -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="md:w-1/2">
                        <img
                            src="https://img.freepik.com/premium-psd/logo-mockup-fragrance-parfum-bottle-cap_145275-388.jpg?w=996"
                            class="rounded-lg shadow-xl w-full"
                            alt="Parfumul semnătură"
                        >
                    </div>
                    <div class="md:w-1/2">
                        <span class="text-sm font-medium text-amber-600 mb-2 block">SEMNĂTURA NOASTRĂ</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-light text-gray-900 mb-6">
                            Élégance <span class="font-bold">Noir</span>
                        </h2>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Un amestec captivant de oud rar, trandafir catifelat și ambră caldă ce creează o prezență de neuitat.
                            Parfumul nostru semnătură întruchipează eleganța atemporală pentru cei care caută distincția.
                        </p>
                        <div class="flex items-center gap-4">
                            <button class="bg-gray-900 text-white px-8 py-3 rounded-full hover:bg-gray-800 transition-all duration-300 text-lg font-medium">
                                Descoperă acum
                            </button>
                            <button class="text-gray-900 hover:text-amber-600 transition-all duration-300 text-lg font-medium flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Povestea
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Testimonials -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-20">
                    <span class="text-sm font-medium text-amber-600 tracking-widest mb-4 block">TESTIMONIALE</span>
                    <h2 class="text-4xl md:text-5xl font-serif font-light text-gray-900 mb-6">
                        Vocile <span class="font-bold">Distincției</span>
                    </h2>
                    <div class="w-24 h-px bg-amber-500 mx-auto mb-6"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                        Descoperă ce spun clienții noștri cei mai exigenți despre creațiile noastre olfactive
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div
                        v-for="testimonial in testimonials"
                        :key="testimonial.id"
                        class="relative bg-white p-10 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group"
                    >
                        <div class="absolute top-0 left-10 -translate-y-1/2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                            <div class="text-amber-500 flex">
                                <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="..." />
                                </svg>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-8 italic text-lg leading-relaxed font-light">
                            "{{ testimonial.text }}"
                        </p>

                        <div class="flex items-center">
                            <img :src="testimonial.avatar" :alt="testimonial.name" class="w-12 h-12 rounded-full mr-4 object-cover border-2 border-white shadow-sm">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ testimonial.name }}</h4>
                                <p class="text-sm text-gray-500 font-light">{{ testimonial.role }}</p>
                            </div>
                        </div>

                        <div class="absolute bottom-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-amber-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="..." />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-16">
                    <button class="inline-flex items-center text-amber-600 hover:text-amber-800 font-medium group transition-colors">
                        Citește mai multe testimoniale
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="py-28 bg-gray-900 text-white relative overflow-hidden">
            <!-- Elemente decorative -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-amber-500 mix-blend-overlay filter blur-3xl"></div>
                <div class="absolute bottom-1/3 right-1/4 w-48 h-48 rounded-full bg-amber-400 mix-blend-overlay filter blur-3xl"></div>
            </div>

            <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
                <div class="mb-12">
                    <span class="text-sm font-medium text-amber-400 tracking-widest mb-4 block">ACCES EXCLUSIV</span>
                    <h2 class="text-4xl md:text-5xl font-serif font-light mb-6 leading-tight">
                        Devino parte din <span class="font-bold">Cercul nostru de parfumuri</span>
                    </h2>
                    <div class="w-24 h-px bg-amber-500 mx-auto mb-6"></div>
                    <p class="text-lg text-white/80 max-w-2xl mx-auto leading-relaxed">
                        Abonează-te pentru a primi invitații private, povești despre parfumuri artizanale și privilegii rezervate membrilor
                    </p>
                </div>

                <div class="max-w-xl mx-auto">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input
                                type="email"
                                placeholder="Adresa ta de email"
                                class="w-full bg-white/5 border border-white/10 rounded-full px-6 py-4 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent placeholder-white/50 text-white/90 font-light transition-all duration-300 hover:bg-white/10"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/50 absolute right-5 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <button class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 px-8 py-4 rounded-full transition-all duration-300 font-medium shadow-lg hover:shadow-amber-500/20 flex items-center justify-center gap-2">
                            <span>Înscrie-te acum</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-center gap-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-white/60">Previzualizări exclusive</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-white/60">Evenimente private</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-white/60">Fără spam</span>
                    </div>
                </div>
            </div>
        </section>

    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

const collections = [
    {
        id: 1,
        name: "Floral Elegance",
        image: "https://img.freepik.com/premium-psd/fruit-perfume-bottle-mockup_23-2151411650.jpg?w=740"
    },
    {
        id: 2,
        name: "Woody Mystique",
        image: "https://img.freepik.com/premium-psd/logo-mockup-luxury-perfume-bottle_206274-276.jpg?w=740"
    },
    {
        id: 3,
        name: "Citrus Fresh",
        image: "https://img.freepik.com/premium-psd/perfume-bottle-sand_23-2148961294.jpg?w=740"
    }
];

const testimonials = [
    {
        id: 1,
        text: "The sophistication of Élégance Noir is unmatched. I receive compliments every time I wear it.",
        name: "Sophie Laurent",
        role: "Fashion Editor",
        avatar: "https://randomuser.me/api/portraits/women/44.jpg"
    },
    {
        id: 2,
        text: "As a perfumer, I'm extremely selective. Their craftsmanship is truly exceptional.",
        name: "Marc Dubois",
        role: "Master Perfumer",
        avatar: "https://randomuser.me/api/portraits/men/32.jpg"
    },
    {
        id: 3,
        text: "The longevity of these fragrances is remarkable. Worth every penny for the quality.",
        name: "Isabella Rossi",
        role: "Luxury Buyer",
        avatar: "https://randomuser.me/api/portraits/women/68.jpg"
    }
];
</script>

<style scoped>
.h-screen-90 {
    height: 90vh;
}

/* Smooth transitions for hover effects */
button, .group-hover\:scale-105 {
    transition: all 0.3s ease;
}
</style>
