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
                    <div class="card my-3 pt-6">
                        <Dropdown
                            v-model="selectedCity"
                            :options="cities"
                            optionLabel="name"
                            placeholder="Select a City"
                            class="w-full md:w-14rem"
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
import store from '../../store'

const categories = computed(() => store.state.categories)
onMounted(() => {
    getCategoryLists()
})

function getCategoryLists() {
    store.dispatch('getCategoryLists');
}

const categoryType = ref('0')
</script>
