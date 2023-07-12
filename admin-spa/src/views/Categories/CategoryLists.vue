<template>
    <div class="container">
        <Loader v-if="categories.loading" />
        <div v-else class="grid grid-cols-3 max-sm:grid-cols-2 gap-3">
            <div
                class="border-2 border-blue-500 rounded-lg p-2"
                v-for="(category, index) in categories.data"
                :key="index"
            >
                <div class="flex justify-between items-center align-middle">
                    <a
                        href="#"
                        class="text-sm text-blue-500 hover:text-black"
                        title="click to edit"
                    >
                        {{ category.name }}
                    </a>
                    <Button
                        @click="deleteConfrim(category.id)"
                        icon="pi pi-trash"
                        severity="danger"
                        text
                        aria-label="Delete"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import store from '../../store'
import Loader from '../../components/core/Loader.vue'
import Button from 'primevue/button'

import { computed, onMounted } from 'vue'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'
const categories = computed(() => store.state.categories)
onMounted(() => {
    getCategoryLists()
})

const confirm = useConfirm()
const toast = useToast()

function getCategoryLists () {
    store.dispatch('getCategoryLists')
}

const deleteConfrim = id => {
    confirm.require({
        message: 'Do you want to delete this category?',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        acceptClass: 'p-button-danger',
        accept: () => {
            store.dispatch('deleteCategory', id).then(res => {
                toast.add({
                    severity: 'info',
                    summary: 'Confirmed',
                    detail: 'Record deleted',
                    life: 3000
                })
                getCategoryLists()
            })
        },
        reject: () => {
            toast.add({
                severity: 'error',
                summary: 'Rejected',
                detail: 'Operation Cancel',
                life: 3000
            })
        }
    })
}
</script>
