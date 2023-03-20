<script setup>
import { ref } from 'vue'

defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
  <div>
    <h1>{{ msg }}</h1>
    <div class="bg-purple-500">
        Hello world
    </div>
  </div>
</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
