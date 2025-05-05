<template>
    <AppLayout>
        <!-- Hero Section -->
        <section
            class="h-screen-90 relative flex items-center justify-center overflow-hidden bg-cover bg-center"
            style="
                background-image: url('https://img.freepik.com/free-photo/bride-holds-bottle-parfume-her-tender-arms_8353-7217.jpg?t=st=1746211598~exp=1746215198~hmac=1dce2d00b7725ff60906507c85511969826d008859851a2a0c3fba9fa2111fce&w=740');
            "
        >
            <!-- Dark overlay -->
            <div class="absolute inset-0 z-10 bg-black/30"></div>

            <!-- Content -->
            <div class="relative z-20 mx-auto max-w-4xl px-6 text-center">
                <h1 class="mb-6 font-serif text-4xl leading-tight font-light text-white md:text-6xl lg:text-7xl">
                    Arta <span class="font-bold">Aromei</span>
                </h1>
                <p class="mx-auto mb-10 max-w-2xl text-xl font-light text-white/90 md:text-2xl">
                    Descoperă colecția noastră exclusivă de parfumuri artizanale care spun povestea ta unică
                </p>
                <button
                    class="rounded-full border border-white/20 bg-white/10 px-10 py-4 text-lg font-medium text-white backdrop-blur-lg transition-all duration-300 hover:bg-white/20"
                >
                    Explorează Colecțiile
                </button>
            </div>
        </section>

        <section>
            <div v-for="parfume in props.parfumes" :key="parfume.id">
                {{ parfume.name }}
            </div>
        </section>

        <!-- Featured Collections -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 font-serif text-3xl font-light text-gray-900 md:text-4xl"><span class="font-bold">Colecțiile</span> noastre</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Parfumuri atent selecționate pentru fiecare ocazie și personalitate</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div v-if="!props.parfumes" v-for="collection in collections" :key="collection.id" class="group relative aspect-square overflow-hidden rounded-lg">
                        <img
                            :src="collection.image"
                            :alt="collection.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-black/20 to-transparent p-6">
                            <div>
                                <h3 class="mb-2 text-2xl font-medium text-white">{{ collection.name }}</h3>
                                <button class="flex items-center gap-2 text-sm font-medium text-white/90 transition-all hover:text-white">
                                    Descoperă
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-else v-for="collection in props.parfumes" :key="collection.id" class="group relative aspect-square overflow-hidden rounded-lg">
                        <img
                            :src="collection.image"
                            :alt="collection.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-black/20 to-transparent p-6">
                            <div>
                                <h3 class="mb-2 text-2xl font-medium text-white">{{ collection.name }}</h3>
                                <button class="flex items-center gap-2 text-sm font-medium text-white/90 transition-all hover:text-white">
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
        <section class="bg-gray-50 py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex flex-col items-center gap-12 md:flex-row">
                    <div class="md:w-1/2">
                        <img
                            src="https://img.freepik.com/premium-psd/logo-mockup-fragrance-parfum-bottle-cap_145275-388.jpg?w=996"
                            class="w-full rounded-lg shadow-xl"
                            alt="Parfumul semnătură"
                        />
                    </div>
                    <div class="md:w-1/2">
                        <span class="mb-2 block text-sm font-medium text-amber-600">SEMNĂTURA NOASTRĂ</span>
                        <h2 class="mb-6 font-serif text-3xl font-light text-gray-900 md:text-4xl">Élégance <span class="font-bold">Noir</span></h2>
                        <p class="mb-8 leading-relaxed text-gray-600">
                            Un amestec captivant de oud rar, trandafir catifelat și ambră caldă ce creează o prezență de neuitat. Parfumul nostru
                            semnătură întruchipează eleganța atemporală pentru cei care caută distincția.
                        </p>
                        <div class="flex items-center gap-4">
                            <button
                                class="rounded-full bg-gray-900 px-8 py-3 text-lg font-medium text-white transition-all duration-300 hover:bg-gray-800"
                            >
                                Descoperă acum
                            </button>
                            <button
                                class="flex items-center gap-2 text-lg font-medium text-gray-900 transition-all duration-300 hover:text-amber-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                    />
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
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-20 text-center">
                    <span class="mb-4 block text-sm font-medium tracking-widest text-amber-600">TESTIMONIALE</span>
                    <h2 class="mb-6 font-serif text-4xl font-light text-gray-900 md:text-5xl">Vocile <span class="font-bold">Distincției</span></h2>
                    <div class="mx-auto mb-6 h-px w-24 bg-amber-500"></div>
                    <p class="mx-auto max-w-2xl text-lg text-gray-600">
                        Descoperă ce spun clienții noștri cei mai exigenți despre creațiile noastre olfactive
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="testimonial in testimonials"
                        :key="testimonial.id"
                        class="group relative rounded-lg border border-gray-100 bg-white p-10 shadow-sm transition-all duration-300 hover:shadow-md"
                    >
                        <div class="absolute top-0 left-10 -translate-y-1/2 rounded-full border border-gray-100 bg-white px-4 py-2 shadow-sm">
                            <div class="flex text-amber-500">
                                <svg
                                    v-for="i in 5"
                                    :key="i"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path d="..." />
                                </svg>
                            </div>
                        </div>

                        <p class="mb-8 text-lg leading-relaxed font-light text-gray-600 italic">"{{ testimonial.text }}"</p>

                        <div class="flex items-center">
                            <img
                                :src="testimonial.avatar"
                                :alt="testimonial.name"
                                class="mr-4 h-12 w-12 rounded-full border-2 border-white object-cover shadow-sm"
                            />
                            <div>
                                <h4 class="font-medium text-gray-900">{{ testimonial.name }}</h4>
                                <p class="text-sm font-light text-gray-500">{{ testimonial.role }}</p>
                            </div>
                        </div>

                        <div class="absolute right-0 bottom-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-amber-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="..." />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <button class="group inline-flex items-center font-medium text-amber-600 transition-colors hover:text-amber-800">
                        Citește mai multe testimoniale
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="relative overflow-hidden bg-gray-900 py-28 text-white">
            <!-- Elemente decorative -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-1/4 left-1/4 h-64 w-64 rounded-full bg-amber-500 mix-blend-overlay blur-3xl filter"></div>
                <div class="absolute right-1/4 bottom-1/3 h-48 w-48 rounded-full bg-amber-400 mix-blend-overlay blur-3xl filter"></div>
            </div>

            <div class="relative z-10 mx-auto max-w-5xl px-6 text-center">
                <div class="mb-12">
                    <span class="mb-4 block text-sm font-medium tracking-widest text-amber-400">ACCES EXCLUSIV</span>
                    <h2 class="mb-6 font-serif text-4xl leading-tight font-light md:text-5xl">
                        Devino parte din <span class="font-bold">Cercul nostru de parfumuri</span>
                    </h2>
                    <div class="mx-auto mb-6 h-px w-24 bg-amber-500"></div>
                    <p class="mx-auto max-w-2xl text-lg leading-relaxed text-white/80">
                        Abonează-te pentru a primi invitații private, povești despre parfumuri artizanale și privilegii rezervate membrilor
                    </p>
                </div>

                <div class="mx-auto max-w-xl">
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <div class="relative flex-1">
                            <input
                                type="email"
                                placeholder="Adresa ta de email"
                                class="w-full rounded-full border border-white/10 bg-white/5 px-6 py-4 font-light text-white/90 placeholder-white/50 transition-all duration-300 hover:bg-white/10 focus:border-transparent focus:ring-2 focus:ring-amber-400 focus:outline-none"
                            />
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute top-1/2 right-5 h-5 w-5 -translate-y-1/2 transform text-white/50"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <button
                            class="flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-4 font-medium shadow-lg transition-all duration-300 hover:from-amber-600 hover:to-amber-700 hover:shadow-amber-500/20"
                        >
                            <span>Înscrie-te acum</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-center gap-6">
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4 text-amber-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-white/60">Previzualizări exclusive</span>
                    </div>
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4 text-amber-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs text-white/60">Evenimente private</span>
                    </div>
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="mr-2 h-4 w-4 text-amber-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
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

const props = defineProps({
    parfumes: {
        type: Array,
        default: () => []
    }
});

console.log(props.parfumes)

const collections = [
    {
        id: 1,
        name: 'Floral Elegance',
        image: 'https://img.freepik.com/premium-psd/fruit-perfume-bottle-mockup_23-2151411650.jpg?w=740',
    },
    {
        id: 2,
        name: 'Woody Mystique',
        image: 'https://img.freepik.com/premium-psd/logo-mockup-luxury-perfume-bottle_206274-276.jpg?w=740',
    },
    {
        id: 3,
        name: 'Citrus Fresh',
        image: 'https://img.freepik.com/premium-psd/perfume-bottle-sand_23-2148961294.jpg?w=740',
    },
];

const testimonials = [
    {
        id: 1,
        text: 'The sophistication of Élégance Noir is unmatched. I receive compliments every time I wear it.',
        name: 'Sophie Laurent',
        role: 'Fashion Editor',
        avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
    },
    {
        id: 2,
        text: "As a perfumer, I'm extremely selective. Their craftsmanship is truly exceptional.",
        name: 'Marc Dubois',
        role: 'Master Perfumer',
        avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
    },
    {
        id: 3,
        text: 'The longevity of these fragrances is remarkable. Worth every penny for the quality.',
        name: 'Isabella Rossi',
        role: 'Luxury Buyer',
        avatar: 'https://randomuser.me/api/portraits/women/68.jpg',
    },
];
</script>

<style scoped>
html {
    scroll-behavior: smooth;
    overflow: auto;
}

.h-screen-90 {
    height: 100vh;
}

/* Smooth transitions for hover effects */
button,
.group-hover\:scale-105 {
    transition: all 0.3s ease;
}
</style>
