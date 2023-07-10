<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Forgot Password')" :description="__('Stocket Reset Password Request')" />
    </x-slot>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>
    <div class="card max-w-[400px] md:w-1/2 sm:w-3/4 mx-auto my-auto py-20 px-10 shadow-sm rounded-sm m-3">
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
    </div>
</x-app-layout>
