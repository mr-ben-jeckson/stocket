<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Login')" :description="__('Login Form')" />
    </x-slot>
    <div class="card max-w-[400px] md:w-1/2 sm:w-3/4 mx-auto my-auto py-20 px-10 shadow-sm rounded-sm m-3">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
            Login to your account
        </h2>
        <p class="text-center text-gray-500 mb-6">
            or
            <a href="{{ route('register') }}" class="text-sm text-yellow-600 hover:text-yellow-600">create new account</a>
        </p>
        <div class="mb-4">
            <x-text-input id="loginEmail"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="Your email address"
                :errors="$errors"
            />
        </div>
        <div class="mb-4">
            <x-text-input id="password"
                type="password"
                name="password"
                placeholder="Password"
                :errors="$errors"
            />
        </div>

        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center">
                <input id="loginRememberMe"
                    type="checkbox"
                    name="remember"
                    class="mr-3 rounded border-gray-300
                    text-red-600 focus:ring-yellow-600"
                />
                <label for="loginRememberMe">Remember Me</label>
            </div>
            <a href="{{ route('password.request')}}" class="text-sm text-yellow-600 hover:text-black">Forgot
                Password?</a>
        </div>
        <x-primary-button>
            Login
        </x-primary-button>
    </form>
    </div>
</x-app-layout>
