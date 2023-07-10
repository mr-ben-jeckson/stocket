@props(['statistics'=> false , 'mobile' => false])
@php
    $defaultStyle = 'w-[150px] h-[110px] object-cover';
    $mobileStyle = '';
@endphp

@if ($statistics)
    <img src="{{$logo}}" class="logo" alt="{{config('app.name')}}">
@else
<img src="{{$logo}}" {!! $attributes->merge(['class' => $mobile ? $mobileStyle : $defaultStyle ]) !!} alt="">
@endif
