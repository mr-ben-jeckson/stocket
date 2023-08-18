<template>
    <div class="container">
        <form @submit.prevent="onSubmit()">
            <div class="flex flex-col mb-5">
                <h3 v-if="category.id" class="font-bold mb-3">Edit Category</h3>
                <h3 v-else class="font-bold mb-3">Add Category</h3>
                <div v-if="!category.id" class="flex flex-col">
                    <div class="card">
                        <RadioButton name="categoryType" v-model="categoryType" inputId="Primary" value="0"
                            :disabled="isSaving" />
                        <label for="Primary" class="ml-2"> Primary </label>
                    </div>
                    <div class="card">
                        <RadioButton name="categoryType" v-model="categoryType" inputId="SubCategory" value="1"
                            :disabled="isSaving" />
                        <label for="SubCategory" class="ml-2">
                            Sub Category
                        </label>
                    </div>
                    <div class="card">
                        <RadioButton name="categoryType" v-model="categoryType" inputId="ChildCategory" value="2"
                            :disabled="isSaving" />
                        <label for="ChildCategory" class="ml-2">
                            Child Category
                        </label>
                    </div>
                </div>
                <div class="container">
                    <div class="grid grid-cols-3 max-sm:grid-cols-2 gap-3">
                        <div v-if="categoryType == 1 && !category.id" class="card my-3 pt-6">
                            <div class="p-float-label">
                                <Dropdown v-model="selectedCat" :options="categories.primary" optionLabel="name"
                                    placeholder="Primary Category" class="w-full md:w-14rem" inputId="primary" filter
                                    showClear :disabled="isSaving" />
                                <label for="primary">Select Primary</label>
                            </div>
                        </div>
                        <div v-if="categoryType == 2 && !category.id" class="card my-3 pt-6">
                            <div class="p-float-label">
                                <Dropdown v-model="selectedCat" :options="categories.sub" optionLabel="name"
                                    placeholder="Sub Category" class="w-full md:w-14rem" inputId="sub" filter showClear
                                    :disabled="isSaving" />
                                <label for="sub">Select Sub-category</label>
                            </div>
                        </div>
                        <div class="card my-3 pt-6">
                            <span class="p-float-label">
                                <InputText v-if="!category.id" id="category" v-model="newCategory" class="w-full"
                                    :disabled="isSaving" />
                                <InputText v-else id="category" v-model="category.name" class="w-full"
                                    :disabled="isSaving" />
                                <label for="category">Enter Category Name</label>
                            </span>
                        </div>
                        <div class="card my-3 pt-6">
                            <div class="flex justify-start">
                                <Button :disabled="isSaving || props.category.id && category.name == props.category.name"
                                    type="submit" icon="pi pi-check" aria-label="Submit" />
                                <span class="w-5"></span>
                                <Button @click="category = {}" v-if="category.id" :disabled="isSaving" type="button"
                                    icon="pi pi-times" aria-label="Cancel" class="p-button-secondary" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <Divider />
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'
import Divider from 'primevue/divider'

import { computed, onMounted, ref, watchEffect } from 'vue'
import { useToast } from 'primevue/usetoast'
import store from '../../store'

const selectedCat = ref()
const newCategory = ref()
const categoryType = ref('0')
const isSaving = ref(false)

const props = defineProps({
    category: {
        required: true,
        type: Object
    }
})

const category = ref({
    id: props.category.id,
    name: props.category.name,
    nested: props.category.nested,
    parent_id: props.category.parent_id
})

watchEffect(() => {
    category.value = {
        id: props.category.id,
        name: props.category.name,
        nested: props.category.nested,
        parent_id: props.category.parent_id
    }
})

const toast = useToast()

const categories = computed(() => store.state.categories)

onMounted(() => {
    getCategoryLists()
})

function getCategoryLists() {
    store.dispatch('getCategoryLists')
}

const onSubmit = () => {
    if (category.value.id) {
        isSaving.value = true;
        store
            .dispatch('updateCategory', category.value)
            .then(res => {
                if (res.status == 422) {
                    toast.add({
                        severity: 'error',
                        summary: 'Error',
                        detail: res.message,
                        life: 3000
                    })
                } else if (res.status == 200) {
                    toast.add({
                        severity: 'info',
                        summary: 'Updated',
                        detail: `"${props.category.name}" changed to "${res.data.name}"`,
                        life: 3000
                    })
                }
                isSaving.value = false;
                props.category.name = res.data.name;
            })
            .catch(err => {
                if (err.response.status == 422) {
                    toast.add({
                        severity: 'error',
                        summary: 'Error',
                        detail: err.response.data.message,
                        life: 3000
                    })
                }
                isSaving.value = false;
            })
            .finally(() => {
                getCategoryLists()
            })
    } else {
        if (categoryType.value == 0) {
            isSaving.value = true;
            store
                .dispatch('createCategory', {
                    name: newCategory.value,
                    nested: categoryType.value,
                    parent_id: null
                })
                .then(res => {
                    if (res.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: res.message,
                            life: 3000
                        })
                    } else if (res.status == 201) {
                        toast.add({
                            severity: 'success',
                            summary: 'Success',
                            detail: 'Category created',
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                })
                .catch(err => {
                    if (err.response.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: err.response.data.message,
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                })
                .finally(() => {
                    getCategoryLists()
                })
        } else if (categoryType.value == 1) {
            if (selectedCat.value == null) {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: 'Please select primary category',
                    life: 3000
                })
                return
            }
            isSaving.value = true;
            store
                .dispatch('createCategory', {
                    name: newCategory.value,
                    nested: categoryType.value,
                    parent_id: selectedCat.value.id
                })
                .then(res => {
                    if (res.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: res.message,
                            life: 3000
                        })
                    } else if (res.status == 201) {
                        toast.add({
                            severity: 'success',
                            summary: 'Success',
                            detail: 'Category created',
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                    selectedCat.value = null
                })
                .catch(err => {
                    if (err.response.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: err.response.data.message,
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                })
                .finally(() => {
                    getCategoryLists()
                })
        } else if (categoryType.value == 2) {
            if (selectedCat.value == null) {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: 'Please select sub category',
                    life: 3000
                })
                return
            }
            isSaving.value = true;
            store
                .dispatch('createCategory', {
                    name: newCategory.value,
                    nested: categoryType.value,
                    parent_id: selectedCat.value.id
                })
                .then(res => {
                    if (res.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: res.message,
                            life: 3000
                        })
                    } else if (res.status == 201) {
                        toast.add({
                            severity: 'success',
                            summary: 'Success',
                            detail: 'Category created',
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                    selectedCat.value = null
                })
                .catch(err => {
                    if (err.response.status == 422) {
                        toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: err.response.data.message,
                            life: 3000
                        })
                    }
                    isSaving.value = false
                    newCategory.value = ''
                })
                .finally(() => {
                    getCategoryLists()
                })
        }
    }
}
</script>
