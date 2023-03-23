<template>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Set a new password</h2>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required=""
                            class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            placeholder="New Password" />
                    </div>
                    <div>
                        <label for="password-repeat" class="sr-only">Repeat Password</label>
                        <input id="password-repeat" name="password_confirm" type="password" required=""
                            class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                            placeholder="Repeat Password" />
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <router-link :to="{ name: 'login'}" class="font-medium text-blue-600 hover:text-blue-500">Go back to Login?</router-link>
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="group relative flex w-full justify-center rounded-md bg-blue-600 py-2 px-3 text-sm font-semibold text-white hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <LockClosedIcon class="h-5 w-5 text-blue-500 group-hover:text-blue-400"
                                aria-hidden="true" />
                        </span>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid'
</script>
