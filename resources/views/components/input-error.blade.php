@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'bg-red-600 my-2 rounded py-3 px-3 text-white text-sm']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
