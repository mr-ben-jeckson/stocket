<template>
    <div v-if="currentUser.id" class="min-h-full bg-gray-200 flex">
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
    <div v-else class="min-h-full bg-gray-200 flex items-center justify-center">
        <div class="flex flex-col items-center">
            <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-700"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="mt-2">
                Please wait ...
            </span>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import SideBar from './SideBar.vue';
import NavBar from './NavBar.vue';
import store from '../store';

const { title } = defineProps({
    title: String
});

const isOpenedSideBar = ref(true);

const currentUser = computed(() => store.state.user.data );

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
