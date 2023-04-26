@props(['disabled' => false, 'errors', 'label' => false])

@php
    $errorClasses = 'border-red-600 focus:border-red-600 ring-1 ring-red-600 focus:ring-red-600';
    $defaultClasses = '';
    $successClasses = 'border-blue-600 focus:border-blue-600 ring-1 ring-blue-600 focus:ring-blue-600'
@endphp

@if ($label)
    <label>{{ $label }}</label>
@endif

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-yellow-600
focus:outline-none focus:ring-yellow-600 rounded-md w-full '.($errors->has($attributes['name']) ? $errorClasses : (old($attributes['name']) ? $successClasses : $defaultClasses))
]) !!}>

@error($attributes['name'])
    <small class="text-red-600">{{ $message }}</small>
@enderror
