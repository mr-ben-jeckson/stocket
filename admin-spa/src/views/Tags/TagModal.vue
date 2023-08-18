<template>
    <Dialog
        :visible="visible"
        maximizable
        modal
        header="Tag Management"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
    >
        <div class="container m-2 p-2">
            Tags
        </div>
    </Dialog>
</template>
<script setup>
import Dialog from 'primevue/dialog'

import { computed, ref } from 'vue'
const props = defineProps({
    modelValue: Boolean
})

const visible = computed({
    get: () => props.modelValue,
    set: value => emit('update:modelValue', value)
})

</script>
