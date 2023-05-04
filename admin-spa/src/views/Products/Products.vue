<template>
    <div class="w-full">
        <div class="flex justify-between mb-3">
            <h1 class="text-3xl font-semibold">Products</h1>
            <Button @click="showDropModelForm()" label="Add New Product"/>
        </div>
        <ProductForm :class="isDropModelForm ? 'block' : 'hidden'" v-model="isDropModelForm" :product="productModel" />
        <ProductTable @clickEdit="editProduct" @clickDelete="deleteProcess" />
    </div>
</template>
<script setup>
import ProductTable from './ProductTable.vue';
import ProductForm from './ProductForm.vue';
import Button from 'primevue/button';
import store from '../../store';
import { ref } from 'vue';

const isDropModelForm = ref(false);
const defaultModel = {
    id: '',
    title: '',
    images: [],
    description: '',
    price: Number(0.00),
    tag: [],
    category: [],
    published: true,
    features: [
        {
            head: '',
            text: '',
        }
    ]
}
const productModel = ref({
    ...defaultModel
});

function showDropModelForm() {
    productModel.value = { ...defaultModel };
    isDropModelForm.value = true;
}

function deleteProcess() {
    productModel.value = { ...defaultModel };
    isDropModelForm.value = false;
}

function editProduct(product) {
    store.dispatch('getProduct', product.id)
        .then(({ data }) => {
            productModel.value = data;
            isDropModelForm.value = false;
            isDropModelForm.value = true;
        })
}
</script>
<style scoped></style>
