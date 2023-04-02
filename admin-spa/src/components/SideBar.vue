<template>
    <div class="min-w-[160px] w-[160px]  transition-all bg-blue-800 text-white py-4 px-2">
        <router-link :to="{ name: 'app.dashboard'}"
            class="flex items-center p-2 rounded transition-colors hover:bg-black/30 mb-2"
        >
            <span class="mr-2 text-gray-300">
                <HomeIcon class="w-5"/>
            </span>
            <span class="text-xs">
                Dashboard
            </span>
        </router-link>
        <router-link :to="{ name: 'app.users'}"
            class="flex items-center p-2 rounded transition-colors hover:bg-black/30 mb-2"
        >
            <span class="mr-2 text-gray-300">
                <UserGroupIcon class="w-5"/>
            </span>
            <span class="text-xs">
                Users
            </span>
        </router-link>
        <router-link :to="{ name: 'app.users'}"
            class="flex items-center p-2 rounded transition-colors hover:bg-black/30 mb-2"
        >
            <span class="mr-2 text-gray-300">
                <QueueListIcon class="w-5"/>
            </span>
            <span class="text-xs">
                Products
            </span>
        </router-link>
        <router-link :to="{ name: 'app.inventories'}"
            class="flex items-center p-2 rounded transition-colors hover:bg-black/30 mb-2"
        >
            <span class="mr-2 text-gray-300">
                <BriefcaseIcon class="w-5"/>
            </span>
            <span class="text-xs">
                Inventories
            </span>
        </router-link>
        <router-link :to="{ name: 'app.users'}"
            class="flex items-center p-2 rounded transition-colors hover:bg-black/30 mb-2"
        >
            <span class="mr-2 text-gray-300">
                <ChartBarIcon class="w-5"/>
            </span>
            <span class="text-xs">
                Reports
            </span>
        </router-link>
    </div>
</template>

<script setup>
 import {HomeIcon, UserGroupIcon, UsersIcon, QueueListIcon, BriefcaseIcon, ChartBarIcon} from '@heroicons/vue/24/outline';
 const { title } = defineProps({
    title: String
 });
</script>
<style scoped></style>
