<template>
    <div v-if="isLoading" class="w-full">
        <Loader class="my-20" />
    </div>
    <div v-else class="card w-full">
        <h1 class="text-3xl font-semibold">Manage Product Inventory</h1>
        <div class="grid grid-cols-3 gap-2 max-sm:grid-cols-none my-5 py-5 px-3 bg-white rounded-md shadow-md">
            <div class="w-full border border-gray-200 rounded-md py-5 px-3">
                <p class="font-semibold">Title</p>
                <p class="text-gray-500">{{ product.title }}</p>
            </div>
            <div class="w-full border border-gray-200 rounded-md py-5 px-3">
                <p class="font-semibold">Category & Tag</p>
                <span v-for="(category, index) of product.category" :key="index" class="text-gray-500">
                    {{ category.name }}<span v-if="product.category.length !== index + 1">, </span>
                </span>
                <hr class="text-gray-500">
                <span v-for="(tag, index) of product.tag" :key="index" class="text-gray-500">
                    {{ tag.name }}<span v-if="product.tag.length !== index + 1">, </span>
                </span>
            </div>
            <div class="w-full border border-gray-200 rounded-md py-5 px-3">
                <p class="font-semibold">Price</p>
                <p class="text-gray-500 text-xl"> <span class="font-bold">$</span> {{ product.price }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 max-sm:grid-cols-none my-5 py-5 px-3 bg-white rounded-md shadow-md">
            <div class="w-full flex items-start">
                <div class="p-inputgroup flex-1">
                    <Button label="Search" />
                    <InputText placeholder="Size Name, Weight Name, Stock Amount" />
                </div>
            </div>
            <div class="w-full flex justify-end">
                <Button @click="isAddForm()" label="Add new stock" />
            </div>
        </div>
        <ProductStockForm v-if="isShowForm" v-model="isShowForm" :stock="stockModel" :price="Number(product.price)" />
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import ProductStockForm from "./ProductStockForm.vue";
import router from "../../router";
import store from "../../store";
import Loader from "../../components/core/Loader.vue";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
const route = useRoute();
const id = route.params.id;
const product = ref({});
const isLoading = ref(false);
const isShowForm = ref(false);
const defaultStock = {
    'productId': id,
    'size': '',
    'color': null,
    'type': '',
    'image': null,
    'plus': false,
    'stock': Number(1),
    'extraPlus': Number(1.00),
};

const stockModel = ref({
    ...defaultStock,
})

onMounted(() => {
    isProductExist(id);
})

const isProductExist = (id) => {
    isLoading.value = true
    store.dispatch('getProduct', id)
        .then(({ data }) => {
            product.value = data;
            isLoading.value = false;
        })
        .catch((err) => {
            isLoading.value = false;
            router.push({ name: 'app.dashboard' });
            throw new err;
        });
}

const isAddForm = () => {
    isShowForm.value = true;
    stockModel.value = { ...defaultStock };
}
</script>
