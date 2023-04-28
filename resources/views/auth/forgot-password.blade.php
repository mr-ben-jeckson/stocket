<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Forgot Password')" :description="__('Stocket Reset Password Request')" />
    </x-slot>
    <div class="card max-w-[400px] md:w-1/2 sm:w-3/4 mx-auto my-auto py-20 px-10 shadow-sm rounded-sm m-3">
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <h2 class="text-2xl font-semibold text-center mb-5">
            Enter your Email to reset password
            </h2>
            <p class="text-center text-gray-500 mb-6">
            or
            <a
                href="{{ route('login') }}"
                class="text-yellow-600 hover:text-black"
                >login with existing account</a
            >
            </p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <div class="mb-3">
            <x-text-input
                type="email"
                name="email"
                :value="old('email')"
                placeholder="Your email address"
                autofocus
                required
            />
            </div>
            <x-primary-button>
                Confirm Email
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
