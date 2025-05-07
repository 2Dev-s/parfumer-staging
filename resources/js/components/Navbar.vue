<template>
    <nav class="z-50 w-full border-b border-gray-100 bg-white/90 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center">
                    <Link :href="route('home')">
                        <span class="font-serif text-2xl font-bold tracking-tight text-gray-900">Parfumér</span>
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden items-center space-x-8 md:flex">
                    <Link
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        class="px-1 py-2 text-sm font-medium tracking-wider text-gray-700 uppercase transition-colors duration-300 hover:text-gray-900"
                        active-class="text-amber-600 border-b-2 border-amber-500"
                    >
                        {{ item.name }}
                    </Link>

                    <!-- Shopping Cart -->
                    <div class="relative ml-4">
                        <button @click="toggleCart" class="relative p-1 text-gray-600 transition-colors hover:text-gray-900 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                />
                            </svg>
                            <span
                                v-if="cartCount > 0"
                                class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-amber-600 text-xs font-bold text-white"
                            >
                                {{ cartCount }}
                            </span>
                        </button>

                        <!-- Cart Dropdown -->
                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-show="isCartOpen"
                                class="absolute right-0 z-50 mt-2 w-80 overflow-hidden rounded-lg border border-gray-100 bg-white shadow-xl"
                            >
                                <!-- Cart Header -->
                                <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-4 py-3">
                                    <h3 class="text-sm font-medium text-gray-900">Coșul tău ({{ cartCount }})</h3>
                                    <button @click="closeCart" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Cart Items -->
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Loading state -->
                                    <div v-if="isLoading" class="p-8 text-center">
                                        <svg
                                            class="mx-auto h-8 w-8 animate-spin text-amber-600"
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
                                        <p class="mt-2 text-sm text-gray-500">Incarcam cosul...</p>
                                    </div>

                                    <!-- Error state -->
                                    <div v-else-if="error" class="p-8 text-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="mx-auto h-8 w-8 text-red-500"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-900">Couldn't load your cart</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ error }}</p>
                                        <button
                                            @click="fetchCart"
                                            class="mt-2 text-sm font-medium text-amber-600 hover:text-amber-500 focus:outline-none"
                                        >
                                            Try again
                                        </button>
                                    </div>

                                    <!-- Empty state -->
                                    <div v-else-if="!isLoading && cartCount === 0" class="p-8 text-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="mx-auto h-12 w-12 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                            />
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h4>
                                        <p class="mt-1 text-sm text-gray-500">Start adding some beautiful fragrances</p>
                                    </div>

                                    <!-- Cart items -->
                                    <ul v-else class="divide-y divide-gray-100">
                                        <li v-for="item in cartItems" :key="item.id" class="flex p-4">
                                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                <img
                                                    :src="item.image || '/images/default-parfum.jpg'"
                                                    :alt="item.name"
                                                    class="h-full w-full object-cover object-center"
                                                    @error="handleImageError"
                                                />
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-sm font-medium text-gray-900">
                                                        <h3>{{ item.name }}</h3>
                                                        <p class="ml-4">{{ formatCurrency(item.price) }}</p>
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">{{ item.brand }}</p>
                                                    <p class="mt-1 text-xs text-gray-500">{{ item.size }}ml</p>
                                                </div>

                                                <div class="flex flex-1 items-end justify-between text-sm">
                                                    <div class="flex items-center rounded-md border border-gray-200">
                                                        <button
                                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                                            class="px-2 py-1 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none"
                                                            :disabled="item.quantity <= 1"
                                                            :class="{ 'cursor-not-allowed opacity-50': item.quantity <= 1 }"
                                                        >
                                                            -
                                                        </button>
                                                        <span class="px-2 text-black">{{ item.quantity }}</span>
                                                        <button
                                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                                            class="px-2 py-1 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none"
                                                        >
                                                            +
                                                        </button>
                                                    </div>

                                                    <button
                                                        @click="removeItem(item.id)"
                                                        type="button"
                                                        class="font-medium text-amber-600 transition-colors hover:text-amber-500 focus:outline-none"
                                                    >
                                                        Eliminăs
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Cart Footer -->
                                <div v-if="cartCount > 0" class="border-t border-gray-100 bg-gray-50 px-4 py-4">
                                    <div class="mb-4 flex justify-between text-sm font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p>{{ formatCurrency(cartTotal) }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <Link
                                            :href="route('cart.view')"
                                            class="flex-1 rounded-md border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none"
                                        >
                                            Vezi coșul
                                        </Link>
                                        <Link
                                            :href="route('checkout')"
                                            class="flex-1 rounded-md border border-transparent bg-amber-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none"
                                        >
                                            Plătește
                                        </Link>
                                    </div>
                                    <p class="mt-2 text-center text-xs text-gray-500">Livrare gratuită la comenzile mai mari de {{ formatCurrency(300) }}</p>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <!-- Account -->
                    <div class="relative ml-4">
                        <button class="flex items-center space-x-1 focus:outline-none">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-600 hover:text-gray-900"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                            <span class="hidden text-sm font-medium text-gray-700 lg:inline">Account</span>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button
                        @click="isOpen = !isOpen"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:text-gray-900 focus:outline-none"
                    >
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div v-show="isOpen" class="bg-white shadow-lg md:hidden">
                <div class="space-y-1 px-4 pt-2 pb-3">
                    <Link
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                        active-class=" bg-amber-50"
                    >
                        {{ item.name }}
                    </Link>
                </div>
                <div class="flex items-center justify-between border-t border-gray-200 px-4 pt-4 pb-3">
                    <div class="flex items-center space-x-3">
                        <button class="p-2 text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>
                        <button @click="toggleCart" class="relative p-1 text-gray-600 transition-colors hover:text-gray-900 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                />
                            </svg>
                            <span
                                v-if="cartCount > 0"
                                class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-amber-600 text-xs font-bold text-white"
                            >
                                {{ cartCount }}
                            </span>
                        </button>

                        <transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-150"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-show="isCartOpen"
                                class="fixed inset-0 z-50 overflow-y-auto bg-white"
                            >
                                <!-- Cart Header (Sticky) -->
                                <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-100 bg-white px-4 py-3 shadow-sm">
                                    <h3 class="text-lg font-medium text-gray-900">Cosul tau ({{ cartCount }})</h3>
                                    <button @click="closeCart" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Cart Content -->
                                <div class="min-h-screen pb-32">
                                    <!-- Loading state -->
                                    <div v-if="isLoading" class="flex h-64 items-center justify-center">
                                        <svg
                                            class="h-12 w-12 animate-spin text-amber-600"
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
                                    </div>

                                    <!-- Error state -->
                                    <div v-else-if="error" class="flex h-64 flex-col items-center justify-center p-6 text-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-12 w-12 text-red-500"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <h4 class="mt-4 text-lg font-medium text-gray-900">Nu am putut încărca coșul.</h4>
                                        <p class="mt-2 text-gray-500">{{ error }}</p>
                                        <button
                                            @click="fetchCart"
                                            class="mt-4 rounded-md bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 focus:outline-none"
                                        >
                                            Try again
                                        </button>
                                    </div>

                                    <!-- Empty state -->
                                    <div v-else-if="!isLoading && cartCount === 0" class="flex h-64 flex-col items-center justify-center p-6 text-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-16 w-16 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                            />
                                        </svg>
                                        <h4 class="mt-4 text-lg font-medium text-gray-900">Coșul tău este gol</h4>
                                        <p class="mt-2 text-gray-500">Începe să adaugi parfumuri frumoase</p>
                                        <button
                                            @click="closeCart"
                                            class="mt-4 rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 focus:outline-none"
                                        >
                                            Continuă cumpărăturile
                                        </button>
                                    </div>

                                    <!-- Cart items -->
                                    <ul v-else class="divide-y divide-gray-100">
                                        <li v-for="item in cartItems" :key="item.id" class="flex p-4">
                                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                <img
                                                    :src="item.image || '/images/default-parfum.jpg'"
                                                    :alt="item.name"
                                                    class="h-full w-full object-cover object-center"
                                                    @error="handleImageError"
                                                />
                                            </div>

                                            <div class="ml-4 flex flex-1 flex-col">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>{{ item.name }}</h3>
                                                        <p class="ml-4">{{ formatCurrency(item.price) }}</p>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500">{{ item.brand }}</p>
                                                    <p class="mt-1 text-sm text-gray-500">{{ item.size }}ml</p>
                                                </div>

                                                <div class="flex flex-1 items-end justify-between pt-4">
                                                    <div class="flex items-center rounded-md border border-gray-200">
                                                        <button
                                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                                            class="px-3 py-1 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none"
                                                            :disabled="item.quantity <= 1"
                                                            :class="{ 'cursor-not-allowed opacity-50': item.quantity <= 1 }"
                                                        >
                                                            -
                                                        </button>
                                                        <span class="px-3 text-black">{{ item.quantity }}</span>
                                                        <button
                                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                                            class="px-3 py-1 text-gray-500 transition-colors hover:text-gray-700 focus:outline-none"
                                                        >
                                                            +
                                                        </button>
                                                    </div>

                                                    <button
                                                        @click="removeItem(item.id)"
                                                        type="button"
                                                        class="font-medium text-amber-600 transition-colors hover:text-amber-500 focus:outline-none"
                                                    >
                                                        Elimină
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Sticky Footer -->
                                <div v-if="cartCount > 0" class="fixed bottom-0 left-0 right-0 border-t border-gray-100 bg-white px-4 py-4 shadow-lg">
                                    <div class="mb-4 flex justify-between text-lg font-medium text-gray-900">
                                        <p>Subtotal</p>
                                        <p>{{ formatCurrency(cartTotal) }}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <Link
                                            :href="route('cart.view')"
                                            class="flex-1 rounded-md border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none"
                                        >
                                            Vezi coșul
                                        </Link>
                                        <Link
                                            :href="route('checkout')"
                                            class="flex-1 rounded-md border border-transparent bg-amber-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-amber-700 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:outline-none"
                                        >
                                            Plătește
                                        </Link>
                                    </div>
                                    <p class="mt-3 text-center text-xs text-gray-500">Livrare gratuită la comenzile mai mari de {{ formatCurrency(300) }}</p>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <Link :href="route('home')" class="text-sm font-medium text-gray-700 hover:text-gray-900"> My Account </Link>
                </div>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const navigation = [
    { name: 'Femei', href: '/parfumuri?sex=female' },
    { name: 'Barbati', href: '/parfumuri?sex=male' },
    { name: 'Noi', href: '/parfumuri?sort=new_arrival' },
    { name: 'Luxury', href: '/parfumuri?category=1' },
    { name: 'Cadouri', href: '/gifts' },
];

const isCartOpen = ref(false);
const isOpen = ref(false);
const cartItems = ref([]);
const isLoading = ref(false);
const error = ref(null);
let cartPollingInterval = null;

// Computed properties
const cartCount = computed(() => cartItems.value.reduce((total, item) => total + item.quantity, 0));
const cartTotal = computed(() => cartItems.value.reduce((total, item) => total + item.price * item.quantity, 0));

// Watch for cart open state changes
watch(isCartOpen, (newVal) => {
    if (newVal) {
        // When cart opens, stop polling and fetch immediately
        stopCartPolling();
        fetchCart();
    } else {
        // When cart closes, restart polling
        startCartPolling();
    }
});

// Cart methods
const toggleCart = () => {
    isCartOpen.value = !isCartOpen.value;
};

const closeCart = () => {
    isCartOpen.value = false;
};

const fetchCart = async () => {
    try {
        if (!isCartOpen.value) {
            isLoading.value = true;
        }
        const response = await axios.get(route('cart.index'));
        cartItems.value = response.data.cartItems || [];
        error.value = null;
    } catch (err) {
        error.value = err.response?.data?.message || 'Failed to load cart items';
        console.error('Error fetching cart items:', err);
    } finally {
        isLoading.value = false;
    }
};

const updateQuantity = async (id, newQuantity) => {
    try {
        const quantity = Math.max(1, newQuantity);
        const response = await axios.post(route('cart.update', { cartItem: id }), { quantity });

        if (response.data.success) {
            const itemIndex = cartItems.value.findIndex((item) => item.id === id);
            if (itemIndex !== -1) {
                cartItems.value[itemIndex].quantity = quantity;
            }
        }
    } catch (err) {
        console.error('Error updating quantity:', err);
    }
};

const removeItem = async (id) => {
    try {
        const response = await axios.delete(`/cos/sterge/${id}`);
        if (response.data.success) {
            cartItems.value = cartItems.value.filter((item) => item.id !== id);
        }
    } catch (err) {
        console.error('Error removing item:', err);
    }
};


const handleImageError = (e) => {
    e.target.src = '/images/default-parfum.jpg';
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('ro-RO', {
        style: 'currency',
        currency: 'RON',
        minimumFractionDigits: 0,
    }).format(amount);
};

// Start polling for cart updates
const startCartPolling = () => {
    if (!cartPollingInterval) {
        cartPollingInterval = setInterval(fetchCart, 1000); // Fetch every second
    }
};

// Stop polling
const stopCartPolling = () => {
    if (cartPollingInterval) {
        clearInterval(cartPollingInterval);
        cartPollingInterval = null;
    }
};

// Initialize cart and start polling on mount
onMounted(() => {
    fetchCart();
    startCartPolling();
});

// Clean up polling when component is unmounted
onUnmounted(() => {
    stopCartPolling();
});

// Listen for custom events to update cart
window.addEventListener('cart-updated', fetchCart);
</script>

<style scoped>
.cart-item-enter-active,
.cart-item-leave-active {
    transition: all 0.3s ease;
}

.cart-item-enter-from,
.cart-item-leave-to {
    opacity: 0;
    transform: translateX(20px);
}
</style>
