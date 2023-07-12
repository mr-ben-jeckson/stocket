<template>
    <Dialog
        :visible="visible"
        maximizable
        modal
        header="Category Management"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
    >
        <div class="container m-2 p-2">
            <CategoryForm />
            <CategoryLists/>
        </div>
    </Dialog>
</template>
<script setup>
import Dialog from 'primevue/dialog'
import CategoryLists from './CategoryLists.vue'
import CategoryForm from './CategoryForm.vue'

import { computed } from 'vue'
const props = defineProps({
    modelValue: Boolean
})

const visible = computed({
    get: () => props.modelValue,
    set: value => emit('update:modelValue', value)
})
</script>
