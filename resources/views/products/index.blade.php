<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('Products')" :description="__('Products on E store')" />
    </x-slot>
    <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
        @foreach ($products as $product)
            <!-- Product Item -->
            <div class="border border-1 shadow border-gray-200 hover:shadow-red-600 rounded-md hover:border-red-500 transition-colors bg-white animate-fade-in-down">
                <div class="p-2 rounded-lg">
                    <div class="relative w-full overflow-hidden bg-cover bg-no-repeat block aspect-w-4 aspect-h-3">
                        <a href="{{url('/product/'.$product->slug)}}">
                        <img
                          src="{{ json_decode($product->images)[0]->url }}"
                          class="w-full transition duration-300 ease-in-out hover:scale-110 object-cover"
                          alt="{{ $product->slug }}" />
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg">
                        <a href="/src/product.html">
                            {{ Str::limit($product->title, 130, '...') }}
                        </a>
                    </h3>
                    <h5 class="font-bold">${{ $product->price }}</h5>
                </div>
                <div class="flex justify-between py-3 px-4">
                    <button class="w-10 h-10 rounded-full border border-1 border-red-600 flex items-center justify-center hover:bg-red-600 text-red-600 hover:text-white active:bg-red-800 transition-colors">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                    {{-- <button class="btn-primary bg-red-600 hover:bg-red-500 active:bg-red-700">
                        Add to Cart
                    </button> --}}
                    <a href="#_" class="relative inline-flex items-center px-6 py-2 overflow-hidden text-yellow-600 border-2 border-yellow-600 rounded-lg hover:border-red-600 hover:text-white group hover:bg-gray-50">
                        <span class="absolute left-0 block w-full h-0 transition-all bg-red-600 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
                        <span class="absolute right-0 flex items-center justify-start w-5 h-5 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
                            <i class="fas fa-cart-plus"></i>
                        </span>
                        <span class="relative hover:text-white">Add to Cart</span>
                    </a>
                </div>
            </div>
            <!--/ Product Item -->
        @endforeach
    </div>
    {{ $products->links('vendor.pagination.tailwind') }}
</x-app-layout>
