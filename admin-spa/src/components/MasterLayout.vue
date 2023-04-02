<template>
    <div class="min-h-full flex">
        <!-- Sidebar -->
        <SideBar />
        <!-- Sidbar -->

        <div class="flex-1">
            <!-- Header -->
            <NavBar/>
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
import NavBar from './NavBar.vue';
 const { title } = defineProps({
    title: String
 });
</script>
<style scoped></style>
