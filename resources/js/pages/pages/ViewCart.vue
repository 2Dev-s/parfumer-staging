<template>
    <AppLayout>
        <!-- Luxury Background -->
        <div class="fixed inset-0 z-0"></div>

        <div class="relative z-10 mx-auto max-w-6xl px-6 py-16">
            <!-- Cart Header with Gold Accents -->
            <div class="mb-16 text-center">
                <div class="relative inline-block">
                    <h1 class="mb-4 font-serif text-4xl font-light tracking-wider text-gray-900">SELECȚIA TA DE LUX</h1>
                    <div class="absolute right-0 bottom-0 left-0 h-0.5 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>
                </div>
                <p class="mt-6 text-sm tracking-widest text-gray-500">SELECȚIONAT PENTRU CLIENTUL EXIGENT</p>
            </div>

            <!-- Luxury Cart Content -->
            <div v-if="cartItems.length > 0" class="space-y-12">
                <!-- Cart Items with Premium Styling -->
                <div class="bg-opacity-90 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg backdrop-blur-sm">
                    <div class="divide-y divide-gray-100">
                        <div v-for="item in cartItems" :key="item.id" class="p-8 transition-colors duration-300 ">
                            <div class="flex items-start space-x-8">
                                <!-- Premium Product Image -->
                                <div class="h-40 w-40 flex-shrink-0 overflow-hidden rounded-lg border-2 border-amber-100 shadow-inner">
                                    <img
                                        :src="item.product.main_image_url"
                                        :alt="item.product.name"
                                        class="h-full w-full transform object-cover object-center transition-transform duration-500 hover:scale-105"
                                    />
                                </div>

                                <!-- Luxury Product Details -->
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="font-serif text-xl font-light text-gray-900">{{ item.product.name }}</h3>
                                            <p class="mt-1 text-sm tracking-widest text-amber-600 uppercase">
                                                {{ item.product.brand.name }}
                                            </p>
                                            <p class="mt-2 text-xs tracking-wide text-gray-500">{{ item.size }}ml • Eau de Parfum</p>
                                        </div>
                                        <p class="text-xl font-medium text-gray-900">
                                            {{ formatCurrency(item.price) }}
                                        </p>
                                    </div>

                                    <!-- Exclusive Quantity Selector -->
                                    <div class="mt-8 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <button
                                                @click="updateQuantity(item.id, item.quantity - 1)"
                                                class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition-colors hover:bg-amber-100 hover:text-amber-800"
                                                :disabled="item.quantity <= 1"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="w-8 text-center text-lg font-medium text-gray-900">{{ item.quantity }}</span>
                                            <button
                                                @click="updateQuantity(item.id, item.quantity + 1)"
                                                class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition-colors hover:bg-amber-100 hover:text-amber-800"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Remove Button -->
                                        <button
                                            @click="removeItem(item.id)"
                                            class="text-xs hover:cursor-pointer tracking-widest text-gray-500 uppercase transition-colors hover:text-red-500"
                                        >
                                            Elimină
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Luxury Order Summary -->
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <!-- Personal Concierge Service -->
                        <div class="bg-opacity-90 rounded-xl border border-gray-100 bg-white p-8 shadow-lg backdrop-blur-sm">
                            <h3 class="mb-6 font-serif text-lg font-light text-gray-900">SERVICIU PERSONALIZAT DE CONCIERGE</h3>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="h-6 w-6 flex-shrink-0 text-amber-500">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="ml-3 text-sm text-gray-600">Împachetare cadou gratuită cu ambalaj de lux semnat</p>
                                </div>
                                <div class="flex items-start">
                                    <div class="h-6 w-6 flex-shrink-0 text-amber-500">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="ml-3 text-sm text-gray-600">Serviciu de livrare cu mănuși albe disponibil la cerere</p>
                                </div>
                                <div class="flex items-start">
                                    <div class="h-6 w-6 flex-shrink-0 text-amber-500">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <p class="ml-3 text-sm text-gray-600">Consultant dedicat pentru parfumuri, oferind recomandări personalizate</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exclusive Order Summary -->
                    <div class="bg-opacity-90 rounded-xl border border-gray-100 bg-white p-8 shadow-lg backdrop-blur-sm">
                        <h3 class="mb-6 font-serif text-lg font-light text-gray-900">ORDER SUMMARY</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-sm font-medium text-gray-900">{{ formatCurrency(cartTotal) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Livrare</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ cartTotal >= 300 ? 'GRATUITĂ' : formatCurrency(20) }}
                                </p>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-4">
                                <p class="text-base font-medium text-gray-900">Total</p>
                                <p class="text-base font-medium text-gray-900">
                                    {{ formatCurrency(cartTotal >= 300 ? cartTotal : cartTotal + 20) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <Link
                                :href="route('checkout')"
                                class="block w-full bg-amber-600 px-6 py-3 text-center text-sm font-medium tracking-widest text-white transition-colors duration-300 hover:bg-amber-700"
                            >
                                FINALIZEAZĂ COMANDA
                            </Link>
                            <Link
                                :href="route('parfumes')"
                                class="block w-full border border-amber-600 px-6 py-3 text-center text-sm font-medium tracking-widest text-amber-600 transition-colors duration-300 hover:bg-amber-50"
                            >
                                CONTINUĂ CUMPĂRĂTURILE
                            </Link>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-xs tracking-widest text-gray-500">LIVRARE GRATUITĂ PENTRU COMENZILE DE PESTE {{ formatCurrency(3000) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Luxury Cart -->
            <div v-else class="py-24 text-center">
                <div class="mx-auto h-32 w-32 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                </div>
                <h3 class="mt-8 font-serif text-2xl font-light text-gray-900">COȘUL TĂU ESTE GOL</h3>
                <p class="mt-4 text-sm tracking-widest text-gray-500">ÎNCEPE CĂLĂTORIA TA EXCLUSIVĂ ÎN LUMEA PARFUMURILOR</p>
                <div class="mt-8">
                    <Link
                        :href="route('parfumes')"
                        class="inline-flex items-center border border-transparent bg-amber-600 px-8 py-3 text-sm font-medium tracking-widest text-white transition-colors duration-300 hover:bg-amber-700"
                    >
                        DESCOPERĂ COLECȚIA
                        <svg xmlns="http://www.w3.org/2000/svg" class="-mr-1 ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    cartItems: Array,
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('ro-RO', {
        style: 'currency',
        currency: 'RON',
        minimumFractionDigits: 0,
    }).format(amount);
};

const cartTotal = computed(() => props.cartItems.reduce((total, item) => total + item.price * item.quantity, 0));

const updateQuantity = async (id, newQuantity) => {
    if (newQuantity < 1) return;
    await router.post(
        route('cart.update', id),
        { quantity: newQuantity },
        {
            preserveScroll: true,
        },
    );
};

const removeItem = (id) => {
    router.delete(route('cart.remove', id), {
        preserveScroll: true,
    });
};
</script>

<style scoped>
/* Custom scrollbar for luxury feel */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f5f5f5;
}

::-webkit-scrollbar-thumb {
    background: #d4a017;
    border-radius: 3px;
}
</style>
