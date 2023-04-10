<template>
    <div>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button @click="showCreateModal" type="submit" class="py-2 px-4 border border-transparent text-sm font-medium
                        rounded-md text-white bg-blue-600 hover:bg-blue-800
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add New Products
        </button>
    </div>
    <ProductModal v-model="isShowCreateModal" />
    <ProductTable />
    </div>
</template>
<script setup>
import ProductTable from './ProductTable.vue';
import ProductModal from './ProductModal.vue';
import { ref } from 'vue';

const isShowCreateModal = ref(false);

function showCreateModal() {
    isShowCreateModal.value = true;
}

</script>
<style scoped></style>
