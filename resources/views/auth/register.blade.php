<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Register')" :description="__('Register Form on Stocket')" />
    </x-slot>
    <div class="card max-w-[400px] md:w-1/2 sm:w-3/4 mx-auto my-auto py-20 px-10 shadow-sm rounded-sm m-3">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
            <p class="text-center text-gray-500 mb-3">
                or
                <a href="{{ route('login') }}" class="text-sm text-yellow-600 hover:text-black">login with existing
                    account</a>
            </p>
            <div class="mb-4">
                <x-text-input placeholder="Your name" type="text" name="name" :value="old('name')"
                    {{-- x-model="form.name" @input="validateName()"
                :class="errors.name ? errorClasses : (form.name ? successClasses : defaultClasses)" />
        <small x-show="errors.name" x-text="errors.name" class="text-red-600"></small> --}} />
            </div>
            </p>
            <div class="mb-4">
                <x-text-input placeholder="Your Email" type="email" name="email" :value="old('email')"
                    {{-- x-model="form.email" @input="validateEmail()"
                :class="errors.email ? errorClasses : (form.email ? successClasses : defaultClasses)" />
        <small x-show="errors.email" x-text="errors.email" class="text-red-600"></small> --}} />
            </div>
            <div class="mb-4">
                <x-text-input placeholder="Password" type="password" name="password" {{-- x-model="form.password" @input="validatePassword()"
                :class="errors.password ? errorClasses : (form.password ? successClasses : defaultClasses)" />
        <small x-show="errors.password" x-text="errors.password" class="text-red-600"></small> --}} />
            </div>
            <div class="mb-4">
                <x-text-input placeholder="Repeat Password" type="password" name="password_confirmation"
                    {{-- x-model="form.password_repeat" @input="validatePasswordRepeat()"
                        :class="errors.password_repeat ? errorClasses : (form.password_repeat ? successClasses : defaultClasses)" />
                <small x-show="errors.password_repeat" x-text="errors.password_repeat" class="text-red-600"></small> --}} />
            </div>
            <x-primary-button>
                Signup
            </x-primary-button>
        </form>
    </div>

</x-app-layout>
