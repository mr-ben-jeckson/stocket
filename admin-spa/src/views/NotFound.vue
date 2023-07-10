<template>
    <div class="flex justify-center items-center min-h-full min-w-full">
        <div class="text-blue-800 text-9xl px-8 font-bold border-r border-r-black"> 404 </div>
        <div class="px-8">
            <h1 class="text-4xl font-bold py-2">Page Not Found</h1>
            <p class="text-sm text-gray-500">The url doesn't match. Please check back and try again</p>
            <div class="py-4">
                <router-link :to="{ name: 'app.dashboard'}"
                    class="justify-center transition-all rounded-md bg-white py-2 px-3
                    text-sm font-semibold text-black hover:text-white hover:bg-black
                    focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                  focus-visible:outline-black ring-1 ring-black focus:ring-gray-500">
                    Go back home
                </router-link>
            </div>
        </div>
    </div>
</template>
<script setup>

</script>
<style scoped>

</style>
