<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="$product->title" description="{!! Str::limit($product->description, 120) !!}" />
    </x-slot>
    <div class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
            <div class="lg:col-span-3 bg-gray-200 py-5">
                <div x-data="{
                    images:  {{ Js::from(json_decode($product->images)) }}.map(item => item.url),
                    activeImage: null,
                    prev() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === 0)
                            index = this.images.length;
                        this.activeImage = this.images[index - 1];
                    },
                    next() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === this.images.length - 1)
                            index = -1;
                        this.activeImage = this.images[index + 1];
                    },
                    init() {
                        this.activeImage = this.images.length > 0 ? this.images[0] : null
                    }
                }">
                    <div class="relative">
                        <template x-for="image in images">
                            <div x-show="activeImage === image" class="aspect-w-3 aspect-h-2">
                                <img :src="image" alt="" class="w-auto mx-auto" />
                            </div>
                        </template>
                        <a @click.prevent="prev"
                            class="cursor-pointer bg-black/30 text-white absolute left-0 top-1/2 -translate-y-1/2">
                            <i class="fas fa-chevron-left 2xl px-4 py-4"></i>
                        </a>
                        <a @click.prevent="next"
                            class="cursor-pointer bg-black/30 text-white absolute right-0 top-1/2 -translate-y-1/2">
                            <i class="fas fa-chevron-right 2xl px-4 py-4"></i>
                        </a>
                    </div>
                    <div class="flex overflow-x-auto bg-black/25 mt-5">
                        <template x-for="image in images">
                            <a @click.prevent="activeImage = image"
                                class="cursor-pointer w-[80px] border border-gray-300 hover:border-yellow-600 flex items-center justify-center"
                                :class="{ 'border-yellow-600': activeImage === image }">
                                <img :src="image" alt="" class="w-auto max-auto max-h-full" />
                            </a>
                        </template>
                    </div>
                </div>
                <div class="md:block hidden p-5">
                    <div class="my-3">
                        <x-product-category :categories="$product->categories"/>
                    </div>
                    <div class="my-3">
                        <x-product-tag :tags="$product->tags" />
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <h1 class="text-lg font-semibold">
                    {{$product->title}}
                </h1>
                <div class="text-xl text-yellow-600 font-bold mb-6">$ {{ $product->price }}</div>
                {{-- To Do Review & Reviewers --}}
                {{-- <div class="flex items-center mb-6">
                    <div class="flex items-center text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <a href="#" class="ml-3 font-normal text-purple-600 hover:text-purple-500">
                        67 reviews
                    </a>
                </div> --}}
                <div class="flex items-center justify-between mb-5">
                    <label for="quantity" class="block font-bold mr-4">
                        Quantity
                    </label>
                    <x-text-input type="number" name="quantity" x-ref="quantityEl" value="1"
                        class="w-32 focus:border-yellow-600 focus:outline-none rounded max-w-[110px]" />
                </div>
                <button @click="addToCart(id, $refs.quantityEl.value)"
                    class="btn-primary bg-red-600 py-4 hover:bg-yellow-600 text-lg flex justify-center min-w-0 w-full mb-6">
                    <i class="fas fa-shopping-cart my-auto mr-3"></i>
                    Add to Cart
                </button>
                <div class="mb-6" x-data="{ expanded: false }">
                    <div x-show="expanded" x-collapse.min.120px class="text-gray-500 wysiwyg-content">
                        {{-- To make stock here --}}
                        {{-- <table>
                            <tbody>
                                <tr>
                                    <td>Connectivity Technology</td>
                                    <td>USB</td>
                                </tr>
                                <tr>
                                    <td>Recommended Uses For Product</td>
                                    <td>Gaming</td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>Logitech G</td>
                                </tr>
                                <tr>
                                    <td>Compatible Devices</td>
                                    <td>Personal Computer</td>
                                </tr>
                                <tr>
                                    <td>Series</td>
                                    <td>Logitech G502 HERO High Performance Gaming Mouse</td>
                                </tr>
                            </tbody>
                        </table> --}}
                        <p class="text-gray-500">
                            {{ $product->description }}
                        </p>
                    </div>
                    <p class="text-right">
                        <a @click="expanded = !expanded" href="javascript:void(0)"
                            class="text-yelow-600 hover:text-gray-500"
                            x-text="expanded ? 'Read Less' : 'Read More'"></a>
                    </p>
                </div>
                <div class="block md:hidden">
                    <div class="my-3">
                        <x-product-category :categories="$product->categories"/>
                    </div>
                    <div class="my-3">
                        <x-product-tag :tags="$product->tags" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
