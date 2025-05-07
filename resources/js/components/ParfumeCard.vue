<template>
    <template v-for="parfum in relatedParfumes" :key="parfum.id">
        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-lg">
            <!-- Image Container -->
            <div class="relative aspect-[3/4] w-full overflow-hidden">
                <!-- Main Image -->
                <Link :href="route('parfums.show', parfum.slug)">
                    <img
                        :src="parfum.main_image_url || '/images/default-parfum.jpg'"
                        :alt="parfum.name"
                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    />
                </Link>

                <!-- Top Badges - Always visible -->
                <div class="absolute top-0 right-0 left-0 flex justify-between p-3">
                    <!-- Gender Badge -->
                    <span class="rounded-full bg-black/70 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm">
                        {{ getGenderLabel(parfum.sex) }}
                    </span>

                    <!-- New Arrival Badge (if applicable) -->
                    <span
                        v-if="parfum.is_new"
                        class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-black backdrop-blur-sm"
                    >
                        Nou
                    </span>
                </div>
            </div>

            <!-- Product Info - Always visible -->
            <div class="p-4">
                <div class="mb-2 flex items-start justify-between">
                    <div>
                        <h3 class="line-clamp-1 text-lg font-medium text-gray-900">{{ parfum.name }}</h3>
                        <p class="text-sm text-gray-500">{{ parfum.brand?.name }}</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900">€{{ parfum.price }}</span>
                </div>

                <p class="mb-3 text-xs text-gray-500">{{ parfum.size }}ml</p>

                <!-- Action Buttons - Always visible -->
                <div class="flex items-center justify-between">
                    <!-- Favorite Button -->
                    <button
                        @click.stop="toggleFavorite(parfum.id)"
                        class="flex items-center justify-center rounded-full p-2 transition-colors"
                        :class="parfum.is_favorite ? 'text-rose-500' : 'text-gray-400 hover:text-rose-500'"
                    >
                        <svg
                            v-if="isTogglingFavorite !== parfum.id"
                            class="h-5 w-5"
                            :fill="parfum.is_favorite ? 'currentColor' : 'none'"
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
                        <svg v-else class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                    </button>

                    <!-- Add to Cart Button -->
                    <button
                        @click.stop="addToCart(parfum.id)"
                        class="flex items-center rounded-full bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800"
                        :disabled="isAddingToCart === parfum.id"
                    >
                        <span v-if="isAddingToCart !== parfum.id">Adaugă</span>
                        <svg
                            v-else
                            class="h-5 w-5 animate-spin text-white"
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

                    <!-- View Details Button -->
                    <Link
                        :href="route('parfums.show', parfum.slug)"
                        class="flex items-center justify-center rounded-full p-2 text-gray-400 transition-colors hover:text-gray-600"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </template>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const isAddingToCart = ref<number | null>(null);
const isTogglingFavorite = ref<number | null>(null);
const cartCount = ref(0);
const cartItems = ref([]);

const props = defineProps({
    relatedParfumes: {
        type: Array,
        required: true,
        default: () => []
    }
});

const emit = defineEmits(['add-to-cart', 'toggle-favorite']);

const getGenderLabel = (sex: string): string => {
    return {
        male: 'Pentru El',
        female: 'Pentru Ea',
        unisex: 'Unisex'
    }[sex] || 'Unisex';
};

const fetchCart = async (): Promise<void> => {
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

const addToCart = async (productId: number): Promise<void> => {
    isAddingToCart.value = productId;
    try {
        const response = await axios.post(route('cart.add', { product: productId }), {
            quantity: 1
        });

        if (response.data && response.data.cart) {
            cartCount.value = response.data.cart.count;
            cartItems.value = response.data.cart.items;
        }

        await fetchCart();
        emit('add-to-cart', productId);
    } catch (error) {
        console.error('Error adding to cart:', error);
    } finally {
        isAddingToCart.value = null;
    }
};

const toggleFavorite = async (productId: number): Promise<void> => {
    isTogglingFavorite.value = productId;
    try {
        await axios.post(route('favorites.toggle', { product: productId }));
        emit('toggle-favorite', productId);
    } catch (error) {
        console.error('Error toggling favorite:', error);
    } finally {
        isTogglingFavorite.value = null;
    }
};
</script>

<style scoped>
.group-hover\:scale-105 {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

button {
    transition: all 0.2s ease-in-out;
}
</style>
