<template>
    <div class="min-h-full bg-gray-200 flex">
        <!-- Sidebar -->
        <SideBar :class="{'hidden': !isOpenedSideBar}" />
        <!-- Sidbar -->

        <div class="flex-1">
            <!-- Header -->
            <NavBar @toggle-side-bar="toggleSideBar"/>
            <!-- Header -->

            <!-- Content -->
            <main class="p-6">
                <div class="py-4 px-4 rounded bg-white">
                    <router-view></router-view>
                </div>
            </main>
            <!-- Content -->
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import SideBar from './SideBar.vue';
import NavBar from './NavBar.vue';
import store from '../store';
 const { title } = defineProps({
    title: String
 });
 const isOpenedSideBar = ref(true);

 function toggleSideBar() {
    isOpenedSideBar.value = !isOpenedSideBar.value;
}

onMounted(() => {
    store.dispatch('getUser');
    handleSideBar();
    window.addEventListener('resize', handleSideBar);
})

onUnmounted(() => {
    window.removeEventListener('resize', handleSideBar);
})

function handleSideBar() {
    isOpenedSideBar.value = window.outerWidth > 768;
}
</script>
<style scoped></style>
