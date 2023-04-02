<template>
    <div class="min-h-full flex">
        <!-- Sidebar -->
        <SideBar />
        <!-- Sidbar -->

        <div class="flex-1">
            <!-- Header -->
            <header class="h-8 shadow bg-white">
                Header
            </header>
            <!-- Header -->

            <!-- Content -->
            <main>
                <router-view></router-view>
            </main>
            <!-- Content -->
        </div>
    </div>
</template>

<script setup>
import SideBar from './SideBar.vue';
 const { title } = defineProps({
    title: String
 });
</script>
<style scoped></style>
