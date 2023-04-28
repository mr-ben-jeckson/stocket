@props(['categories' => []])
<span class="font-bold">Categories</span>
@if ($categories->count() > 0)
    <p class="mt-3">
        @foreach ($categories->sortBy('nested') as $category)
            <a href="#" class="p-2 leading-10 bg-red-600 rounded-md shadow-sm text-xs text-white">{{$category->name}}</a>
        @endforeach
    </p>
@else
    <p class="mt-3 mx-auto">
        <span class="text-black text-xs">No Categories Attach</span>
    </p>
@endif

