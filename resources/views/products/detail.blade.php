<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="$product->title" description="{!! Str::limit($product->description, 120) !!}" />
    </x-slot>
    <div class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
            <div class="lg:col-span-3 bg-gray-200 py-5">
                <div x-data="{
                    images: {{ Js::from(json_decode($product->images)) }}.map(item => item.url),
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
                        <x-product-category :categories="$product->categories" />
                    </div>
                    <div class="my-3">
                        <x-product-tag :tags="$product->tags" />
                    </div>
                </div>
            </div>
            <div x-data="{ price: {{ $product->price }}, defaultPrice: {{ $product->price }} }" class="lg:col-span-2">
                <h1 class="text-lg font-semibold">
                    {{ $product->title }}
                </h1>
                <div class="text-xl text-yellow-600 font-bold mb-6" x-text="`$${price}`"></div>
                <div class="flex items-center justify-start mb-5">
                    @if (!empty($sizes))
                        <div x-data="{
                            setSize: '{{json_decode($sizes)[0]->size}}',
                            colors: {{$colors}},
                            getSizeColors() {
                                return this.colors.filter((item) => item.size === this.setSize)
                            },
                            setColor: JSON.parse({{\App\Helpers\SizeColor::getDefaultColorFromSize($product->id, json_decode($sizes)[0]->size)->color}}).name
                            }"
                            @if (json_decode($sizes)[0]->plus)
                            x-init="price = defaultPrice + {{json_decode($sizes)[0]->extraPlus}}"
                            @endif
                            class="relative overflow-x-auto">
                            <div>
                                <div class="flex text-sm font-semibold">
                                    Available Sizes
                                </div>
                                <div class="inline-flex mt-3">
                                    @foreach (json_decode($sizes) as $size)
                                        <div class="px-3 py-2 ml-2 text-sm font-semibold cursor-pointer"
                                            x-on:click="[
                                                            setSize = '{{$size->size}}',
                                                            setColor = JSON.parse({{\App\Helpers\SizeColor::getDefaultColorFromSize($product->id, $size->size)->color}}).name,
                                                            price = defaultPrice + {{$size->extraPlus}}
                                                        ]"
                                            :class="setSize === '{{ $size->size }}' ? ' bg-yellow-600 text-white' :
                                                'bg-gray-500 text-white'">
                                            {{ $size->size }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <div class="flex mt-3 text-sm font-semibold">
                                    Available Colors
                                </div>
                                <div class="inline-flex mt-3">
                                    <template x-for="color in getSizeColors">
                                        <div class="w-[40px] h-[40px] px-2 py-2 ml-2 cursor-pointer"
                                            x-on:click="setColor = JSON.parse(color.color).name"
                                            :class="setColor === JSON.parse(color.color).name ? 'border-2 border-red-600' : 'border-2 border-gray-500'"
                                            :style="`background: ${JSON.parse(color.color).hex}`"></div>
                                    </template>
                                </div>
                                <div class="flex mt-3 text-sm font-semibold">
                                    Selected Options
                                </div>
                                <div class="flex text-xs mt-3">
                                    <span class="font-semibold ml-2">Size : </span>
                                    <span class="text-red-600 text-sm font-bold ml-2" x-text="setSize"></span>
                                    <span class="font-semibold ml-2">Color Family : </span>
                                    <span class="text-red-600 text-sm font-bold ml-2" x-text="setColor"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center justify-between mb-5">
                    <label for="quantity" class="block font-bold mr-4">
                        Quantity
                    </label>
                    <x-text-input type="number" name="quantity" x-ref="quantityEl" value="1"
                        class="w-32 focus:border-yellow-600 focus:outline-none rounded max-w-[110px]" />
                </div>
                <button @click="addToCart( {{ $product->id }}, $refs.quantityEl.value)"
                    class="btn-primary bg-red-600 py-4 hover:bg-yellow-600 text-lg flex justify-center min-w-0 w-full mb-6">
                    <i class="fas fa-shopping-cart my-auto mr-3"></i>
                    Add to Cart
                </button>
                <div class="my-3">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td colspan="2" class="w-full">
                                    <h2 class="text-lg font-bold text-black">Features</h2>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($product->features) as $feature)
                                <tr class="border-b border-b-gray-200">
                                    <td class="font-semibold w-[50%]">{{ $feature->head }}</td>
                                    <td class="text-gray-500 w-[50%]">{{ $feature->text }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mb-6" x-data="{ expanded: false }">
                    <div x-show="expanded" x-collapse.min.120px class="text-gray-500 wysiwyg-content">
                        <p class="text-gray-500">
                        <h2 class="text-lg font-bold text-black">About Product</h2>
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
                        <x-product-category :categories="$product->categories" />
                    </div>
                    <div class="my-3">
                        <x-product-tag :tags="$product->tags" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
