<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative h-[50vh] overflow-hidden bg-gray-900">
            <div class="absolute inset-0 z-10 bg-black/40"></div>
            <img
                :src="parfum.main_image_url"
                :alt="parfum.name"
                class="h-full w-full object-cover object-center transition-opacity duration-500"
                loading="lazy"
            />
        </section>

        <!-- Perfume Details -->
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid gap-16 lg:grid-cols-2 lg:items-start lg:gap-24">
                    <!-- Image Gallery -->
                    <div class="top-20 h-min">
                        <!-- Main Image -->
                        <div class="relative aspect-square overflow-hidden rounded-3xl shadow-xl">
                            <img
                                :src="parfum.main_image_url"
                                :alt="parfum.name"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-105"
                            />
                        </div>

                        <!-- Thumbnails -->
                        <div v-if="parfum.gallery_images.length > 0" class="mt-6 grid grid-cols-4 gap-4">
                            <div
                                v-for="(image, index) in parfum.gallery_images"
                                :key="index"
                                class="aspect-square cursor-pointer overflow-hidden rounded-xl border-2 border-transparent transition-all hover:border-amber-500"
                                @click="currentImage = image.url"
                            >
                                <img
                                    :src="image.thumb"
                                    class="h-full w-full object-cover"
                                    :class="{ 'opacity-50': currentImage !== image.url }"
                                    loading="lazy"
                                    @error="image.thumb = '/images/default-thumb.jpg'"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div>
                        <!-- Breadcrumb -->
                        <nav class="mb-6 flex text-sm" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2 text-gray-500">
                                <li>
                                    <Link :href="route('parfumes')" class="hover:text-amber-600"> Colecție</Link>
                                </li>
                                <li class="text-gray-300">/</li>
                                <li>
                                    <Link :href="route('parfumes', { sex: parfum.sex })" class="hover:text-amber-600">
                                        {{ genderLabel(parfum.sex) }}
                                    </Link>
                                </li>
                                <li class="text-gray-300">/</li>
                                <li class="text-amber-600">{{ parfum.name }}</li>
                            </ol>
                        </nav>

                        <!-- Title -->
                        <h1 class="mb-4 font-serif text-4xl font-light tracking-tight text-gray-900">
                            {{ parfum.name }}
                            <span class="block text-2xl text-gray-600">{{ parfum.brand.name }}</span>
                        </h1>

                        <!-- Price -->
                        <div class="mb-8 flex items-center space-x-4">
                            <span class="text-3xl font-bold text-gray-900">{{ parfum.price }} RON</span>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-800">
                                În stoc ({{ parfum.stock }} buc.)
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="mb-8 flex items-center space-x-4">
                            <button
                                @click="addToCart(parfum.id)"
                                class="flex-1 rounded-full bg-gray-900 px-8 py-4 text-lg font-medium text-white transition-all hover:bg-gray-800 flex items-center justify-center"
                                :disabled="isAddingToCart === parfum.id"
                            >
                                <span v-if="isAddingToCart !== parfum.id">Adaugă în coș</span>
                                <svg
                                    v-else
                                    class="h-6 w-6 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                @click="toggleFavorite(parfum.id)"
                                class="flex h-12 w-12 items-center justify-center rounded-full border-2 border-gray-200 transition-all hover:border-amber-500 hover:bg-amber-50"
                                :disabled="isTogglingFavorite === parfum.id"
                            >
                                <svg
                                    v-if="isTogglingFavorite !== parfum.id"
                                    class="h-6 w-6"
                                    :class="parfum.is_favorite ? 'fill-current text-amber-500' : 'text-gray-400'"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    class="h-6 w-6 animate-spin text-amber-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Description -->
                        <div class="prose mb-12 max-w-none border-b border-gray-200 pb-12">
                            <h2 class="font-serif text-2xl font-light text-gray-900">Descriere parfum</h2>
                            <p class="text-gray-600">{{ parfum.description }}</p>
                        </div>

                        <!-- Details -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="rounded-lg bg-gray-50 p-6">
                                <h3 class="mb-2 text-sm font-medium text-gray-500">Note de parfum</h3>
                                <p class="text-gray-900">Florale, Citrice, Lemnoase</p>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-6">
                                <h3 class="mb-2 text-sm font-medium text-gray-500">Concentrație</h3>
                                <p class="text-gray-900">Eau de Parfum</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        <section class="bg-gray-50 py-20">
            <div class="mx-auto max-w-7xl px-6">
                <h2 class="mb-12 font-serif text-3xl font-light text-gray-900">Parfumuri similare</h2>
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <ParfumeCard :relatedParfumes="relatedParfumes" class="bg-white" />
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="bg-gray-900 py-20 text-white">
            <div class="mx-auto max-w-5xl px-6 text-center">
                <div class="mb-12">
                    <span class="mb-4 block text-sm font-medium tracking-widest text-amber-400">EXPERIENȚĂ PREMIUM</span>
                    <h2 class="mb-6 font-serif text-4xl leading-tight font-light">Descoperă <span class="font-bold">Secretul Aromei</span></h2>
                    <p class="mx-auto max-w-2xl text-lg leading-relaxed text-white/80">
                        Abonează-te pentru a primi acces exclusiv la lansări noi, masterclass-uri de parfumuri și oferte private
                    </p>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import ParfumeCard from '@/components/ParfumeCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    parfum: Object,
    relatedParfumes: Array,
});

const isAddingToCart = ref(null);
const isTogglingFavorite = ref(null);
const cartCount = ref(0);
const cartItems = ref([]);

const currentImage = ref(props.parfum.main_image_url);

const genderLabel = (sex) => {
    return {
        male: 'Pentru El',
        female: 'Pentru Ea',
        unisex: 'Unisex',
    }[sex];
};

const fetchCart = async () => {
    try {
        const response = await axios.get(route('cart.index'));
        if (response.data && response.data.cart) {
            cartCount.value = response.data.cart.count;
            cartItems.value = response.data.cart.items;
        }
    } catch (error) {
        console.error('Error fetching cart:', error);
    }
};


// Adaugă metodele existente din pagina principală
const addToCart = async (productId) => {
    isAddingToCart.value = productId;
    try {
        const response = await axios.post(route('cart.add', { product: productId }), {
            quantity: 1
        });

        // Update local cart state with the response data
        if (response.data && response.data.cart) {
            cartCount.value = response.data.cart.count;
            cartItems.value = response.data.cart.items;
        }

    } catch (error) {
        console.error('Error adding to cart:', error);
    } finally {
        isAddingToCart.value = null;
    }
};

const toggleFavorite = async (productId) => {
    isTogglingFavorite.value = productId; // Set the product ID that's being toggled
    try {
        await axios.post(route('favorites.toggle', { product: productId }));

        // Update local state to reflect the change
        const productIndex = props.parfumes.findIndex(p => p.id === productId);
        if (productIndex !== -1) {
            props.parfumes[productIndex].is_favorite = !props.parfumes[productIndex].is_favorite;
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    } finally {
        isTogglingFavorite.value = null; // Reset when done
    }
};

</script>

<style scoped>
.prose {
    line-height: 1.75;
}

.sticky {
    position: sticky;
    transition: top 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}
</style>
