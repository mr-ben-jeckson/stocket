@props(['tags' => []])
<span class="font-bold">Tags</span>
@if ($tags->count() > 0)
    <p class="mt-3">
        @foreach ($tags->sortBy('name') as $tag)
            <a href="#" class="p-2 leading-10 bg-yellow-600 rounded-md shadow-sm text-xs text-white">{{$tag->name}}</a>
        @endforeach
    </p>
@else
    <p class="mt-3 mx-auto">
        <span class="text-black text-xs">No Tags Attach</span>
    </p>
@endif

