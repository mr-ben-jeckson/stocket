<x-app-layout>
    <form method="POST" action="{{ route('login') }}" class="w-[400px] mx-auto p-6 my-16">
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
        <button class="btn-primary bg-red-600 hover:bg-red-500 active:bg-red-700 w-full">
            Login
        </button>
    </form>
</x-app-layout>
