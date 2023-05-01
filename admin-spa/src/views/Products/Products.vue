<template>
    <div class="w-full">
    <div class="flex items-center mb-3">

        <!-- <button @click="showCreateModal" type="submit" class="py-2 px-4 border border-transparent text-sm font-medium
                        rounded-md text-white bg-blue-600 hover:bg-blue-800
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add New Products
        </button> -->

        <div class="row-auto">
            <div class="grid grid-cols-2">
                <div class="w-full">
                    <h1 class="text-3xl font-semibold">Products</h1>
                </div>
                <div class="w-full">
                    <button @click="showDropModalForm" type="submit" class="py-2 px-4 border border-transparent text-sm font-medium
                        rounded-md text-white bg-blue-600 hover:bg-blue-800
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Product
                    </button>
                </div>
            </div>
        </div>
    </div>
    <ProductForm  :class="isDropModelForm ? 'block' : 'hidden'" v-model="isDropModelForm" :product="productModel" />
    <ProductModal v-model="isShowCreateModal" :product="productModel" />
    <ProductTable @clickEdit="editProduct" @clickDelete="deleteProcess" />
    </div>
</template>
<script setup>
import ProductTable from './ProductTable.vue';
import ProductModal from './ProductModal.vue';
import ProductForm from './ProductForm.vue';
import store from '../../store';
import { computed, ref } from 'vue';

const isShowCreateModal = ref(false);
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

function showCreateModal() {
    isShowCreateModal.value = true;
}

function showDropModalForm() {
    productModel.value = {...defaultModel};
    isDropModelForm.value = true;
}

function deleteProcess() {
    productModel.value = {...defaultModel};
    isDropModelForm.value = false;
}

function editProduct(product) {
    store.dispatch('getProduct', product.id)
            .then(({data}) => {
                productModel.value = data;
                isDropModelForm.value = false;
                isDropModelForm.value = true;
            })
}
</script>
<style scoped>
</style>
