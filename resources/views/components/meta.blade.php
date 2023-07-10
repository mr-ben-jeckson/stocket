@props(['title', 'description'])

<title>
    {{ $title ? $title : __('No title')}}
</title>
<!-- Primary Meta Tags -->
<meta name="title" content="{{ $title ? $title : __('No title')}}">
<meta name="description" content="{{ $description ? $description : __('No description')}}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ? $title : __('No title')}}">
<meta property="og:description" content="{{ $description ? $description : __('No title')}}">
<meta property="og:image" content="">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title ? $title : __('No title')}}">
<meta property="twitter:description" content="{{ $description ? $description: __('No description')}}">
<meta property="twitter:image" content="">

{{$slot}}
