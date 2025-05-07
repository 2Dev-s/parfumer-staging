<template>
    <AppLayout>
        <!-- Hero Section -->
        <section
            class="h-screen-90 relative flex items-center justify-center overflow-hidden bg-cover bg-center"
            style="
                background-image: url('https://img.freepik.com/free-photo/attractive-seductive-sensual-stylish-woman-boho-dress-sitting-vintage-retro-cafe-holding-perfume_285396-6942.jpg?t=st=1746487707~exp=1746491307~hmac=aa370ef4e5e78146a8aca2da33d3ddf251006fe357d7d36a0b49c1de6bdcb8c5&w=996');
            "
        >
            <div class="absolute inset-0 z-10 bg-black/30"></div>
            <div class="relative z-20 mx-auto max-w-4xl px-6 text-center">
                <h1 class="mb-6 font-serif text-4xl leading-tight font-light text-white md:text-6xl lg:text-7xl">
                    Aroma <span class="font-bold">Lux</span>
                </h1>
                <p class="mx-auto mb-10 max-w-2xl text-xl font-light text-white/90 md:text-2xl">
                    Descoperă colecția noastră exclusivă de parfumuri artizanale care spun povestea ta unică
                </p>
                <div class="flex justify-center space-x-4">
                    <Link
                        v-for="gender in genders"
                        :key="gender.value"
                        :href="route('parfumes', { sex: gender.value })"
                        :class="getLinkClass(gender.value)"
                    >
                        {{ gender.label }}
                    </Link>
                </div>
            </div>
        </section>

        <!-- Perfume Collection -->
        <section class="bg-white py-20" id="parfumes" ref="parfumeCollection">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 font-serif text-3xl font-light text-gray-900 md:text-4xl"><span class="font-bold">Colecția</span> Noastră</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Carefully curated fragrances for every occasion and personality</p>
                </div>

                <!-- Sorting -->
                <form @submit.prevent="submit" class="mb-12 flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-4 sm:gap-y-3">
                    <!-- Search Input -->
                    <div class="w-full sm:min-w-[200px] sm:flex-1 lg:max-w-full">
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Căutare parfum..."
                            class="w-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 hover:border-gray-400 focus:ring-2 focus:ring-amber-500 focus:outline-none sm:py-2.5 sm:text-base"
                        />
                    </div>

                    <!-- Sort Select -->
                    <div class="w-full sm:min-w-[180px] sm:flex-1 lg:max-w-[220px]">
                        <select
                            v-model="filters.sort"
                            class="w-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 hover:border-gray-400 focus:ring-2 focus:ring-amber-500 focus:outline-none sm:py-2.5 sm:text-base"
                        >
                            <option value="">Sortează</option>
                            <option value="new_arrival">Cele mai noi</option>
                            <option value="price_asc">Preț: crescător</option>
                            <option value="price_desc">Preț: descrescător</option>
                        </select>
                    </div>

                    <!-- Sex Select -->
                    <div class="w-full sm:min-w-[180px] sm:flex-1 lg:max-w-[220px]">
                        <select
                            v-model="filters.sex"
                            class="w-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 hover:border-gray-400 focus:ring-2 focus:ring-amber-500 focus:outline-none sm:py-2.5 sm:text-base"
                        >
                            <option value="">Sortează după sex</option>
                            <option value="female">Femei</option>
                            <option value="male">Barbati</option>
                            <option value="unisex">Unisex</option>
                        </select>
                    </div>

                    <div class="w-full sm:min-w-[180px] sm:flex-1 lg:max-w-[220px]">
                        <select
                            v-model="filters.brand"
                            class="w-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 hover:border-gray-400 focus:ring-2 focus:ring-amber-500 focus:outline-none sm:py-2.5 sm:text-base"
                        >
                            <option value="">Brand</option>
                            <option v-for="brand in props.brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
                        </select>
                    </div>
                    <div class="w-full sm:min-w-[180px] sm:flex-1 lg:max-w-[220px]">
                        <select
                            v-model="filters.category"
                            class="w-full border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 hover:border-gray-400 focus:ring-2 focus:ring-amber-500 focus:outline-none sm:py-2.5 sm:text-base"
                        >
                            <option value="">Categorie</option>
                            <option v-for="category in props.categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button
                        type="submit"
                        class="w-full bg-black px-6 py-2.5 text-sm text-white transition-colors hover:scale-105 hover:cursor-pointer hover:bg-gray-800 sm:w-auto sm:text-base"
                    >
                        Caută
                    </button>
                </form>

                <!-- Perfume Grid -->
                <div v-if="parfumes.length === 0" class="py-20 text-center">
                    <p class="text-lg text-gray-500">Nu am găsit parfumuri. Te rugăm să încerci un alt filtru.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div
                        v-for="parfum in parfumes"
                        :key="parfum.id"
                        class="group relative overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-lg"
                    >
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
                                    {{ genderLabel(parfum.sex) }}
                                </span>

                                <!-- New Arrival Badge -->
                                <span
                                    v-if="filters.sort"
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
                                <span class="text-lg font-bold text-gray-900">{{ parfum.price }} RON</span>
                            </div>

                            <p class="mb-3 text-xs text-gray-500">{{ parfum.size }}ml</p>

                            <!-- Action Buttons - Always visible -->
                            <div class="flex items-center justify-between">
                                <!-- Favorite Button -->
                                <button
                                    @click.stop="toggleFavorite(parfum.id)"
                                    class="flex items-center justify-center rounded-full p-2 transition-colors"
                                    :class="parfum.is_favorite ? 'text-rose-500' : 'text-gray-400 hover:text-rose-500'"
                                    :disabled="isTogglingFavorite === parfum.id"
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
                            alt="Signature Scent"
                        />
                    </div>
                    <div class="md:w-1/2">
                        <span class="mb-2 block text-sm font-medium text-amber-600">AROMA NOASTRĂ SEMNĂTURĂ</span>
                        <h2 class="mb-6 font-serif text-3xl font-light text-gray-900 md:text-4xl">Élégance <span class="font-bold">Noir</span></h2>
                        <p class="mb-8 leading-relaxed text-gray-600">
                            Un amestec captivant de oud rar, trandafir catifelat și ambră caldă care creează o prezență de neuitat. Parfumul nostru
                            semnătură întruchipează eleganța atemporală pentru cei care caută distincția.
                        </p>
                        <button
                            class="rounded-full bg-gray-900 px-8 py-3 text-lg font-medium text-white transition-all duration-300 hover:bg-gray-800"
                        >
                            Descoperă acum
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="relative overflow-hidden bg-gray-900 py-28 text-white">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-1/4 left-1/4 h-64 w-64 rounded-full bg-amber-500 mix-blend-overlay blur-3xl"></div>
                <div class="absolute right-1/4 bottom-1/3 h-48 w-48 rounded-full bg-amber-400 mix-blend-overlay blur-3xl"></div>
            </div>

            <div class="relative z-10 mx-auto max-w-5xl px-6 text-center">
                <div class="mb-12">
                    <span class="mb-4 block text-sm font-medium tracking-widest text-amber-400">ACCES EXCLUSIV</span>
                    <h2 class="mb-6 font-serif text-4xl leading-tight font-light md:text-5xl">
                        Intră în <span class="font-bold">Cercul nostru de Parfumuri</span>
                    </h2>
                    <p class="mx-auto max-w-2xl text-lg leading-relaxed text-white/80">
                        Abonează-te pentru invitații private, povești despre parfumuri artizanale și privilegii doar pentru membri
                    </p>
                </div>

                <div class="mx-auto max-w-xl">
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <input
                            type="email"
                            placeholder="Adresa ta de email"
                            class="w-full rounded-full border border-white/10 bg-white/5 px-6 py-4 font-light text-white/90 placeholder-white/50 transition-all duration-300 hover:bg-white/10 focus:ring-2 focus:ring-amber-400 focus:outline-none"
                        />
                        <button
                            class="rounded-full bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-4 font-medium shadow-lg transition-all duration-300 hover:from-amber-600 hover:to-amber-700"
                        >
                            Abonează-te acum
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const filters = ref({
    search: '',
    sort: '',
    brand: '',
    sex: '',
    category: '',
});

const isAddingToCart = ref(null);
const isTogglingFavorite = ref(null);
const cartCount = ref(0);
const cartItems = ref([]);

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

const addToCart = async (productId) => {
    isAddingToCart.value = productId;
    try {
        const response = await axios.post(route('cart.add', { product: productId }), {
            quantity: 1,
        });

        // Update local cart state with the response data
        if (response.data && response.data.cart) {
            cartCount.value = response.data.cart.count;
            cartItems.value = response.data.cart.items;
        }

        fetchCart();
        // Show success notification
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
        const productIndex = props.parfumes.findIndex((p) => p.id === productId);
        if (productIndex !== -1) {
            props.parfumes[productIndex].is_favorite = !props.parfumes[productIndex].is_favorite;
        }
    } catch (error) {
        console.error('Error toggling favorite:', error);
    } finally {
        isTogglingFavorite.value = null; // Reset when done
    }
};

onMounted(() => {
    const query = new URLSearchParams(window.location.search);
    filters.value.search = query.get('search') || '';
    filters.value.sort = query.get('sort') || '';
    filters.value.brand = query.get('brand') || '';
    filters.value.sex = query.get('sex') || '';
    filters.value.category = query.get('category') || '';

    fetchCart();
});

const form = useForm(filters.value);
const parfumeCollection = ref<HTMLElement | null>(null);

const submit = () => {
    // Create clean query params object
    const cleanParams = Object.entries(filters.value).reduce((acc, [key, value]) => {
        if (value && value !== '') {
            acc[key] = value;
        }
        return acc;
    }, {});

    // Build URL with only active filters
    const queryParams = new URLSearchParams(cleanParams).toString();
    const url = queryParams ? `${route('parfumes')}?${queryParams}` : route('parfumes');

    form.post(url, {
        onSuccess: () => {
            if (parfumeCollection.value) {
                parfumeCollection.value.scrollIntoView({ behavior: 'smooth' });
            }
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};

const props = defineProps({
    parfumes: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    brands: {
        type: Array,
        default: () => [],
    },
    sex: String,
});

const genders = [
    { value: 'male', label: 'Pentru El' },
    { value: 'female', label: 'Pentru Ea' },
    { value: 'unisex', label: 'Toate Parfumurile' },
];

const getLinkClass = (targetSex) => {
    const baseClass = 'px-6 py-2 rounded-full font-medium transition-all duration-300';
    return props.sex === targetSex
        ? `${baseClass} border-1 border-white/20 bg-white text-gray-900 hover:bg-gray-100`
        : `${baseClass} border-1 border-white/20 text-white hover:bg-white/10 hover:border-white/30`;
};

const genderBadgeClass = (sex) => {
    return {
        male: 'bg-blue-100 text-blue-800',
        female: 'bg-pink-100 text-pink-800',
        unisex: 'bg-purple-100 text-purple-800',
    }[sex];
};

const genderLabel = (sex) => {
    return {
        male: 'For Him',
        female: 'For Her',
        unisex: 'Unisex',
    }[sex];
};
</script>

<style scoped>
html {
    scroll-behavior: smooth;
    overflow: auto;
}

.h-screen-90 {
    height: 50vh;
}

/* Smooth transitions for hover effects */
button,
.group-hover\:scale-105 {
    transition: all 0.3s ease;
}
</style>
