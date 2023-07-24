<template>
    <div class="container">
        <div class="flex flex-col mb-5">
            <h3 class="font-bold mb-3">Add New Category</h3>
            <div class="flex flex-col">
                <div class="card">
                    <RadioButton
                        name="categoryType"
                        v-model="categoryType"
                        inputId="Primary"
                        value="0"
                    />
                    <label for="Primary" class="ml-2"> Primary </label>
                </div>
                <div class="card">
                    <RadioButton
                        name="categoryType"
                        v-model="categoryType"
                        inputId="SubCategory"
                        value="1"
                    />
                    <label for="SubCategory" class="ml-2"> Sub Category </label>
                </div>
                <div class="card">
                    <RadioButton
                        name="categoryType"
                        v-model="categoryType"
                        inputId="ChildCategory"
                        value="2"
                    />
                    <label for="ChildCategory" class="ml-2">
                        Child Category
                    </label>
                </div>
            </div>
            <div class="container">
                <div class="grid grid-cols-3 max-sm:grid-cols-2 gap-3">
                    <div v-if="categoryType == 1" class="card my-3 pt-6">
                        <Dropdown
                            v-model="selectedCat"
                            :options="categories.primary"
                            optionLabel="name"
                            placeholder="Primary Category"
                            class="w-full md:w-14rem"
                            filter
                            showClear
                        />
                    </div>
                    <div v-if="categoryType == 2" class="card my-3 pt-6">
                        <Dropdown
                            v-model="selectedSubCat"
                            :options="categories.sub"
                            optionLabel="name"
                            placeholder="Sub Catgegory"
                            class="w-full md:w-14rem"
                            filter
                            showClear
                        />
                    </div>
                    <div class="card my-3 pt-6">
                        <span class="p-float-label">
                            <InputText
                                id="newCategory"
                                v-model="newCategory"
                                class="w-full"
                            />
                            <label for="newCategory">Enter Category Name</label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import InputText from 'primevue/inputtext'
import RadioButton from 'primevue/radiobutton'
import Dropdown from 'primevue/dropdown'

import { computed, onMounted, ref } from 'vue'
import { useToast } from 'primevue/usetoast'
import store from '../../store'

const selectedCat = ref()
const selectedSubCat = ref()
const newCategory = ref()
const categoryType = ref('0')

const toast = useToast()

const categories = computed(() => store.state.categories)

onMounted(() => {
    getCategoryLists()
})

function getCategoryLists () {
    store.dispatch('getCategoryLists')
}
</script>
