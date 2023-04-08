<template>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Products</h1>
            <button type="submit"
                class="py-2 px-4 border border-transparent text-sm font-medium
                rounded-md text-white bg-blue-600 hover:bg-blue-800
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Add New Products
            </button>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex justify-between border-b-2 pb-3">
                <div class="flex items-center">
                    <span class="whitesapce-nowrap mr-3">
                        Per Page
                    </span>
                    <select @change="getModals(null)" v-model="perPage"
                        class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500
                         text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500
                         focus:z-10 sm:text-sm"
                    >
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                <div>
                    <input v-model="search" @change="getProducts(null)"
                        class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none
                         focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="Enter Keywords to search products"
                    >
                </div>
                </div>
            </div>
        </div>
        <Loader v-if="products.loading" />
        <template v-else>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="border-b-2 p-2 text-right">
                            ID
                        </th>
                        <th class="border-b-2 p-2 text-right">
                            Image
                        </th>
                        <th class="border-b-2 p-2 text-right">
                            Title
                        </th>
                        <th class="border-b-2 p-2 text-right">
                            Price
                        </th>
                        <th class="border-b-2 p-2 text-right">
                            Last Updated
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product of products.data">
                        <td class="border-b p-2">{{ product.id }}</td>
                        <td class="border-b p-2">
                            <img :src="product.images" class="w-16 h-16 object-cover" :alt="product.title">
                        </td>
                        <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                            {{ product.title }}
                        </td>
                        <td class="border-b p-2">{{ product.price }}</td>
                        <td class="border-b p-2">{{ product.updated_at }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-5">
                <span>
                    Showing from {{ products.from }} to {{ products.to }}
                </span>
                <nav v-if="products.total > products.limit"
                    class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                    aria-label="Pagination"
                >
                    <a href="#"
                        v-for="(link, i) of products.links"
                        :key="i"
                        :disabled="!link.url"
                        @click.prevent="getPage($event, link)"
                        aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                        :class="[
                            link.active
                            ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            i === 0 ? 'rounded-l-md' : '',
                            i === products.links.length - 1 ? 'rounded-r-md' : '',
                            !link.url ? 'bg-gray-100 text-gray-700' : ''
                        ]"
                        v-html="link.label">
                    </a>
                </nav>
            </div>
        </template>
</template>
<script setup>
import Loader from '../components/core/Loader.vue';
import { computed, onMounted, ref } from 'vue';
import store from '../store';
import { PRODUCT_PER_PAGE } from '../constants.js';

const perPage = ref(PRODUCT_PER_PAGE);
const search = ref('');
const products = computed(() => store.state.products);

onMounted(() => {
    getProducts();
});

function getProducts(url=null) {
    store.dispatch('getProducts', {url});
}

function getPage(ev, link) {
    if(!link.url || link.active) {
        return;
    }
    getProducts(link.url);
}
</script>
<style scoped>

</style>
