<template>
    <header class="flex justify-between items-center p-4 h-14 shadow bg-white">
      <button @click="emit('toggle-side-bar')" class="flex items-center rounded transition-colors w-8 h-8 hover:bg-black/20 justify-center text-blue-700 ">
          <Bars3Icon class="w-6 " />
      </button>
    <Menu as="div" class="relative inline-block text-left">
      <MenuButton
      class="flex items-center"
      >
      <img src="https://randomuser.me/api/portraits/women/49.jpg" class="rounded-full w-8 mr-2" alt="profile img">
      <small>{{ loginUser.name }}</small>
      <ChevronDownIcon
          class="h-5 w-5 text-blue-700 hover:text-blue-400"
          aria-hidden="true"
      />
      </MenuButton>
      <transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
              <MenuItems
                class="absolute z-20 right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <div class="px-1 py-1">
                  <MenuItem v-slot="{ active }">
                    <button
                      :class="[
                        active ? 'bg-blue-700 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                    >
                      <UserCircleIcon
                        :active="active"
                        class="mr-2 h-5 w-5 text-blue-400"
                        aria-hidden="true"
                      />
                      Profile
                    </button>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <button
                      @click="logout"
                      :class="[
                        active ? 'bg-blue-700 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                    >
                      <ArrowRightOnRectangleIcon
                        :active="active"
                        class="mr-2 h-5 w-5 text-blue-400"
                        aria-hidden="true"
                      />
                      Log Out
                    </button>
                  </MenuItem>
                </div>
              </MenuItems>
      </transition>
    </Menu>
    </header>
</template>
<script setup>
import { Bars3Icon, ArrowRightOnRectangleIcon, UserCircleIcon } from '@heroicons/vue/24/outline';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import store from '../store';
import router from '../router';
import { computed } from 'vue';

const emit = defineEmits(['toggle-side-bar']);

const loginUser = computed(() => store.state.user.data);

function logout() {
    store.dispatch('logout')
        .then(() => {
            router.push({ name: 'login'});
        });
}
</script>
