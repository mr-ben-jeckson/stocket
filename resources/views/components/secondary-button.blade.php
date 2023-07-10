<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary bg-yellow-600 hover:bg-yellow-500 active:bg-yellow-700 w-full']) }}>
    {{ $slot }}
</button>
