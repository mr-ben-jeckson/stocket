<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitesapce-nowrap mr-3">
                    Per Page
                </span>
                <select @change="getProducts(null)" v-model="perPage" class="appearance-none relative block w-20 px-3 py-2 border border-gray-300 placeholder-gray-500
                                                    text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                                    focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getProducts(null)" class="appearance-none relative block w-auto px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none
                                                    focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                    placeholder="Enter Keywords to search products">
            </div>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <TableHeadingColumns @click="sortProduct" class="border-b-2 p-2 text-right w-[10%]" field="id"
                        :sort-field="sortField" :sort-direction="sortDirection">
                        ID
                    </TableHeadingColumns>
                    <TableHeadingColumns @click="() => { return }" class="border-b-2 p-2 text-right w-[15%]" field=""
                        :sort-field="sortField" :sort-direction="sortDirection">
                        Image
                    </TableHeadingColumns>
                    <TableHeadingColumns @click="sortProduct" class="border-b-2 p-2 text-right w-[35%]" field="title"
                        :sort-field="sortField" :sort-direction="sortDirection">
                        Title
                    </TableHeadingColumns>
                    <TableHeadingColumns @click="sortProduct" class="border-b-2 p-2 text-right w-[15%]" field="price"
                        :sort-field="sortField" :sort-direction="sortDirection">
                        Price
                    </TableHeadingColumns>
                    <TableHeadingColumns @click="sortProduct" class="border-b-2 p-2 text-right w-[15%]" field="updated_at"
                        :sort-field="sortField" :sort-direction="sortDirection">
                        Last Updated
                    </TableHeadingColumns>
                    <TableHeadingColumns @click="() => { return }" class="border-b-2 p-2 text-right w-[10%]" field=""
                        :sort-field="sortField" :sort-direction="sortDirection">
                        Action
                    </TableHeadingColumns>
                </tr>
            </thead>
            <tbody v-if="products.loading">
                <tr>
                    <td colspan="6">
                        <Loader class="my-4" v-if="products.loading" />
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="product of products.data" :key="product.id">
                    <td class="border-b p-2">{{ product.id }}</td>
                    <td class="border-b p-2">
                        <img :src="product.images"
                            class="w-16 h-12 object-cover"
                            :alt="product.title">
                    </td>
                    <td class="border-b p-2 max-w-0 whitespace-nowrap
                            overflow-hidden text-ellipsis">
                        {{ product.title }}
                    </td>
                    <td class="border-b p-2">
                            {{ product.price }}
                    </td>
                    <td class="border-b p-2">
                             {{ product.updated_at }}
                    </td>
                    <td class="border-b p-2">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton class="inline-flex w-full justify-center rounded-md
                                            px-2 py-2 text-sm font-medium text-white hover:bg-black/25
                                            focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                                            focus-visible:ring-opacity-75">
                                    <EllipsisVerticalIcon class="h-5 w-5 text-blue-600" aria-hidden="true" />
                                </MenuButton>
                            </div>

                            <transition enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0">
                                <MenuItems
                                    class="absolute z-30 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md
                                                bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-blue-600 text-white' : 'text-gray-900',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="editProduct(product)">
                                            <PencilSquareIcon :active="active" class="mr-2 h-5 w-5 text-blue-400"
                                                aria-hidden="true" />
                                            Edit
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-blue-600 text-white' : 'text-gray-900',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="deleteProduct(product)">
                                            <TrashIcon :active="active" class="mr-2 h-5 w-5 text-blue-400"
                                                aria-hidden="true" />
                                            Delete
                                        </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="!products.loading" class="flex justify-between items-center mt-5 z-0 ">
                <span>
                    Showing from {{ products.from }} to {{ products.to }}
                </span>
                <nav v-if="products.total > products.limit"
                    class="relative inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" v-for="(link, i) of products.links" :key="i" :disabled="!link.url"
                        @click.prevent="getPage($event, link)" aria-current="page"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="[
                            link.active
                                ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                            i === 0 ? 'rounded-l-md' : '',
                            i === products.links.length - 1 ? 'rounded-r-md' : '',
                            !link.url ? 'bg-gray-100 text-gray-700' : ''
                        ]" v-html="link.label">
                    </a>
                </nav>
        </div>
    </div>
</template>
<script setup>
import Loader from '../../components/core/Loader.vue';
import { computed, onMounted, ref } from 'vue';
import store from '../../store';
import { PRODUCT_PER_PAGE } from '../../constants.js';
import TableHeadingColumns from '../../components/core/Table/TableHeadingColumns.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { EllipsisVerticalIcon, TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';

const perPage = ref(PRODUCT_PER_PAGE);
const search = ref('');
const products = computed(() => store.state.products);
const sortField = ref('updated_at');
const sortDirection = ref('desc');

const emit = defineEmits(['clickEdit', 'clickDelete'])

onMounted(() => {
    getProducts();
});

function getProducts(url = null) {
    store.dispatch('getProducts', {
        url,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
        search: search.value,
        perPage: perPage.value
    });
}

function getPage(ev, link) {
    if (!link.url || link.active) {
        return;
    }
    getProducts(link.url);
}

function sortProduct(field) {
    if (sortField.value === field) {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc'
        } else {
            sortDirection.value = 'asc'
        }
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }

    getProducts();
}

function editProduct(product) {
    emit('clickEdit', product);
}

function deleteProduct(product) {
    if (!confirm(`Are you sure to delete the product. You cannot restore`)) {
        return;
    }
    emit('clickDelete');
    store.dispatch('deleteProduct', product.id)
        .then(res => {
            // todo
            store.dispatch('getProducts');
        })
}
</script>
<style scoped></style>
