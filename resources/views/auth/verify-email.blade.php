<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Verify Email')" :description="__('Verify your email on Stocket')" />
    </x-slot>
    <div class="card md:w-1/2 sm:w-3/4 mx-auto my-auto py-20 px-10 shadow-sm rounded-sm m-3">
        <div class="mb-4 text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-yellow-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <div class="mt-4 md:flex items-center justify-between sm:flex-1">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="my-3">
                    <x-primary-button class="text-sm">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="my-3">
                    <x-secondary-button class="text-sm">
                        {{ __('Log Out') }}
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
