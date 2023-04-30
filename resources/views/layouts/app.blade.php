<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="/dist/output.css" rel="stylesheet" /> --}}
    {{ $meta }}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <x-navigation />
    <main class="p-5">
        {{ $slot }}
    </main>
    <!-- Toast -->
    <div x-data="toast" x-show="visible" x-transition x-cloak @notify.window="show($event.detail.message)"
        class="fixed z-40 w-[400px] left-1/2 -ml-[200px] bottom-16 py-2 px-4 pb-4 bg-yellow-600 text-white shadow-md rounded-md">
        <div class="font-semibold" x-text="message"></div>
        <button @click="close"
            class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors text-white">
            <i class="fas fa-xmark text-white"></i>
        </button>
        <!-- Progress -->
        <div>
            <div class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10" :style="{ 'width': `${percent}%` }"></div>
        </div>
    </div>
    <!--/ Toast -->
</body>
</html>
