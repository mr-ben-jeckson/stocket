<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary bg-red-600 hover:bg-red-500 active:bg-red-700 w-full']) }}>
    {{ $slot }}
</button>
