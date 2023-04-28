<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary bg-white text-yellow-600 border border-1 border-yellow-600 rounded-md hover:bg-yellow-600 hover:text-white active:border-yellow-700 w-full']) }}>
    {{ $slot }}
</button>
