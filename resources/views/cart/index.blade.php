<x-app-layout>
    <x-slot name="meta">
        <x-meta :title="__('My Cart')" :description="__('My Cart on Stocket')" />
    </x-slot>
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Shopping Cart</h1>

        <div x-data="{
            cartItems: {{ json_encode(
                $products->map(
                    fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'title' => $product->title,
                        'image' => json_decode($product->images)[0]->url,
                        'price' => $product->price,
                        'quantity' => $cartItems[$product->id]['quantity'],
                        'href' => route('product.detail', $product->slug),
                        'removeUrl' => route('cart.remove', $product),
                        'updateQuantityUrl' => route('cart.update.quantity', $product),
                    ],
                ),
            ) }},
            get total() {
                return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2);
            }
        }" class="bg-white p-4 rounded-lg shadow">
            <!-- Product Items -->
            <template x-if="cartItems.length">
                <div>
                    <!-- Product Item -->
                    <template x-for="(product, index) of cartItems" :key="product.id">
                        <div x-data="productItem(product), cartItems">
                            <div class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1">
                                <a :href="product.href"
                                    class="w-36 h-32 flex items-center justify-center overflow-hidden">
                                    <img :src="product.image" class="object-cover" alt="" />
                                </a>
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="flex justify-between mb-3">
                                        <h3 x-text="product.title" class="text-gray-500"></h3>
                                        <span class="text-lg font-semibold text-yellow-600">
                                            $<span x-text="product.price"></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            Qty:
                                            <input type="number" min="1" x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="ml-3 py-1 border-gray-200 focus:border-yellow-600 focus:ring-yellow-600 w-16" />
                                        </div>
                                        <a href="#" @click.prevent="removeItemFromCart()"
                                            class="text-red-600 hover:text-yellow-600"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Item -->
                            <hr x-show="!index == cartItems.length - 1" class="my-5" />
                            <p x-show="index == cartItems.length - 1" class="py-5" /></p>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <div class="border-t border-gray-300 pt-4">
                        <div class="flex justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span id="cartTotal" class="text-xl" x-text="`$${total}`"></span>
                        </div>
                        <p class="text-gray-500 mb-6">
                            Shipping and taxes calculated at checkout.
                        </p>

                        <form action="#" method="post">
                            @csrf
                            <x-primary-button>
                                Process to Checkout
                            </x-primary-button>
                        </form>
                    </div>
                </div>
                <!--/ Product Items -->
            </template>
            <template x-if="!cartItems.length">
                <div class="text-center py-8 text-gray-500">
                    You don't have any items in shopping cart
                </div>
            </template>
        </div>
    </div>
</x-app-layout>
