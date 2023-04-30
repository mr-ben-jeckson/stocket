<header x-data="{
    mobileMenuOpen: false,
    cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }} }"
    @cart-change.window="cartItemsCount = $event.detail.count"
    class="flex justify-between bg-white max-sm:shadow text-black">
    <div class="max-sm:hidden">
        <a href="/src" class="block py-navbar-item pl-5"> +959 -73496871 </a>
    </div>
    <div class="max-sm:block min-[641px]:hidden">
        <a href="/src" class="block py-navbar-item pl-5"> Mobile Logo </a>
    </div>
    <!-- Responsive Menu -->
    <div class="block fixed z-10 top-0 bottom-0 height h-full w-[220px] transition-all bg-white text-red-600 shadow md:hidden overflow-y-auto"
        :class="mobileMenuOpen ? 'left-0' : '-left-[220px]'">
        <ul class="grid grid-flow-row items-center">
            <li>
                <a href="{{ route('home') }}" class="flex justify-center items-center py-3">
                    <x-logo-layout />
                </a>
            </li>
            <li x-data="{ open: true }" class="relative">
                <a @click="open = !open"
                    class="cursor-pointer flex justify-between items-center py-2 px-3 mx-2 rounded hover:bg-red-600 hover:text-white">
                    <span class="flex items-center">
                        <i class="fas fa-list-ul mx-2 my-auto"></i>
                        Menu
                    </span>
                    <i x-show="open" class="fa fa-chevron-down mx-2 my-auto"></i>
                    <i x-show="!open" class="fa fa-chevron-right mx-2 my-auto"></i>
                </a>
                <ul x-show="open" x-transition class="z-10 right-0 bg-red-600 rounded mx-2 text-white py-2">
                    <li class="hover:bg-black/10 px-3 py-2">
                        <div x-data="{ show: false, menu: false, sub: false }" class="overflow-x-auto">
                            <a href="#" x-on:click="show = ! show">Categories</a>
                            <div class="relative">
                                <div class="bg-red-600 rounded-md p-3 w-full relative z-10" x-show="show" x-cloak
                                    @click.away="show = false" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95">
                                    <ul
                                        class="[&>li]:text-white [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]">
                                        @foreach ($categories as $main)
                                            <li
                                                @if (!empty($main->children)) class="flex items-center justify-between" @endif>
                                                <a href="">{{ $main->name }}</a>
                                                @if (!empty($main->children))
                                                    <i x-on:click="menu = !menu"
                                                        :class="menu ? 'fa fa-minus' : 'fa fa-plus'"></i>
                                                @endif
                                            </li>
                                            @if (!empty($main->children))
                                                <div class="bg-red-600 rounded-md w-full relative" x-show="menu"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95">
                                                    @foreach ($main->children as $key => $child)
                                                        <div x-data="{ sub: false }"
                                                            class="[&>li]:text-white [&>li]:text-sm [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]">
                                                            <li
                                                                @if (!empty($child->children)) class="flex items-center justify-between" @endif>
                                                                <a href="#"> <i
                                                                        class="fas fa-circle-chevron-right text-sm"></i>
                                                                    {{ $child->name }} </a>
                                                                @if (!empty($child->children))
                                                                    <i x-on:click="sub = !sub"
                                                                        :class="sub ? 'fa fa-minus' : 'fa fa-plus'"
                                                                        @click.away="sub = false" class="text-sm"></i>
                                                                @endif
                                                            </li>
                                                            @if (!empty($child->children))
                                                                <div class="bg-red-600 rounded-md w-full relative [&>li]:text-white [&>li]:text-sm [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]"
                                                                    x-show="sub"
                                                                    x-transition:enter="transition ease-out duration-100"
                                                                    x-transition:enter-start="transform opacity-0 scale-95">
                                                                    @foreach ($child->children as $item)
                                                                        <li><a href="#">
                                                                                <i
                                                                                    class="fas fa-circle-chevron-right text-sm"></i>
                                                                                <i
                                                                                    class="fas fa-circle-chevron-right text-sm"></i>
                                                                                {{ $item->name }}</a></li>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="hover:bg-black/10">
                        <a href="{{ route('products') }}" class="flex items-center px-3 py-2">
                            Products
                        </a>
                    </li>
                    <li class="hover:bg-black/10">
                        <a href="#" class="flex items-center px-3 py-2">
                            Blogs
                        </a>
                    </li>
                    <li class="hover:bg-black/10">
                        <a href="#" class="flex items-center px-3 py-2">
                            About us
                        </a>
                    </li>
                    <li class="hover:bg-black/10">
                        <a href="#" class="flex items-center px-3 py-2">
                            Contact
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul>
            <li>
                <a href="#"
                    class="relative flex items-center justify-between py-2 px-3 mx-2 rounded transition-colors hover:bg-red-600 hover:text-white">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart px-2 my-auto"></i>
                        Cart
                    </div>
                    <!-- Cart Items Counter -->
                    <small
                        x-show="cartItemsCount"
                        x-transition
                        x-cloak
                        x-text="cartItemsCount"
                        class="absolute z-[100] my-auto right-0 py-[2px] px-[8px] rounded-full bg-yellow-600 text-white text-xs"
                    ></small>
                    <!--/ Cart Items Counter -->
                </a>
            </li>
            <li x-data="{ open: false }" class="relative">
                <a @click="open = !open"
                    class="cursor-pointer transition-colors flex justify-between items-center py-2 px-2 mx-2 rounded hover:bg-red-600 hover:text-white">
                    <span class="flex items-center mx-2">
                        <i class="fas fa-user mx-2 my-auto"></i>
                        My Account
                    </span>
                    <i x-show="open" class="fa fa-chevron-down mx-2 my-auto"></i>
                    <i x-show="!open" class="fa fa-chevron-right mx-2 my-auto"></i>
                </a>
                <ul x-show="open" x-transition class="z-10 right-0 bg-red-600 py-2 mx-2 rounded text-white">
                    <li>
                        <a href="#" class="flex items-center px-3 py-2 transition-colors hover:bg-black/10">
                            <i class="fas fa-user my-auto mx-2"></i>
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-3 py-2 transition-colors hover:bg-black/10">
                            <i class="fas fa-heart my-auto mx-2"></i>
                            Watchlist
                            {{-- <small x-show="$store.header.watchlistItems" x-transition
                                x-text="$store.header.watchlistItems"
                                class="py-[2px] px-[8px] rounded-full bg-red-500"></small> --}}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-3 py-2 transition-colors hover:bg-black/10">
                            <i class="fas fa-box-open my-auto mx-2"></i>
                            My Orders
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center px-3 py-2 transition-colors hover:bg-black/10">
                                <i class="fas fa-right-from-bracket my-auto mx-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('login') }}"
                    class="flex items-center py-2 px-3 mx-2 rounded transition-colors hover:bg-red-600 hover:text-white">
                    <i class="fas fa-key mx-2 my-auto"></i>
                    Login
                </a>
            </li>
            <li class="px-3 py-3">
                <a href="{{ route('register') }}"
                    class="block text-center text-white bg-red-600 py-2 px-3 rounded shadow-md hover:bg-red-700 active:bg-red-500 transition-colors w-full">
                    Create Account
                </a>
            </li>
        </ul>
    </div>
    <!--/ Responsive Menu -->
    <nav class="hidden md:block">
        <ul class="grid grid-flow-col items-center">
            <li>
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center py-navbar-item px-navbar-item hover:bg-black/10 hover:rounded-xl hover:py-3">
                    <i class="fas fa-cart-shopping mx-2 text-red-600"></i>
                    Cart
                    <small x-show="cartItemsCount"
                        x-transition
                        x-cloak
                        x-text="cartItemsCount"
                        class="absolute z-[100] my-auto -right-3 py-[2px] px-[8px] rounded-full bg-yellow-600 text-white text-xs">
                    </small>
                </a>
            </li>
            <li x-data="{ open: false }" class="relative">
                <a @click="open = !open"
                    class="cursor-pointer flex items-center py-navbar-item px-navbar-item pr-5 hover:bg-black/10">
                    <span class="flex items-center">
                        <i class="fas fa-user mx-2 text-red-600"></i>
                        My Account
                    </span>
                    <i class="fas fa-chevron-down text-red-600 ml-2"></i>
                </a>
                <ul @click.outside="open = false" x-show="open" x-transition x-cloak
                    class="absolute z-30 right-0 bg-white w-48 shadow">
                    <li>
                        <a href="/src/profile.html" class="flex px-3 py-2 hover:bg-black/10">
                            <i class="fas fa-user mx-2 text-red-600 my-auto"></i>
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a href="/src/watchlist.html"
                            class="flex items-center justify-between px-3 py-2 hover:bg-black/10">
                            <div class="flex items-center">
                                <i class="fas fa-heart mx-2 text-red-600 my-auto"></i>
                                Watchlist
                            </div>

                            {{-- <small x-show="$store.header.watchlistItems" x-transition
                                x-text="$store.header.watchlistItems"
                                class="py-[2px] px-[8px] rounded-full bg-red-500"></small> --}}
                        </a>
                    </li>
                    <li>
                        <a href="/src/orders.html" class="flex px-3 py-2 hover:bg-black/10">
                            <i class="fas fa-folder mx-2 text-red-600 my-auto"></i>
                            My Orders
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex px-3 py-2 hover:bg-black/10 w-full">
                                <i class="fas fa-right-from-bracket text-red-600 mx-2 my-auto"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="flex px-3 py-2 hover:bg-black/10">
                            <i class="fas fa-key text-red-600 mx-2 my-auto"></i>
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="flex px-3 py-2 hover:bg-black/10">
                            <i class="fas fa-user-plus text-red-600 mx-2 my-auto"></i>
                            Create Account
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li>
      <a
        href="/src/login.html"
        class="flex items-center py-navbar-item px-navbar-item hover:bg-emerald-600"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 mr-2"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
          />
        </svg>
        Login
      </a>
    </li>
    <li>
      <a
        href="/src/signup.html"
        class="inline-flex items-center text-white bg-emerald-600 py-2 px-3 rounded shadow-md hover:bg-emerald-700 active:bg-emerald-800 transition-colors mx-5"
      >
        Register now
      </a>
    </li> --}}
        </ul>
    </nav>
    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-4 block md:hidden">
        <i x-show="!mobileMenuOpen" class="fas fa-bars"></i>
        <i x-show="mobileMenuOpen" class="fas fa-xmark"></i>
    </button>
</header>
{{-- Laptop Tablet and Large Screen Nav --}}
<header class="max-sm:hidden md:block relative bg-white z-10 ">
    <div class="flex justify-center items-center w-full">
        <a href="{{ route('home') }}">
            <x-logo-layout />
        </a>
    </div>
    <nav class="flex justify-center items-center overflow-x-auto bg-red-600 text-white mx-5 my-2 shadow">
        <ul class="grid grid-flow-col items-center py-2">
            <li>
                <a href="#" class="relative inline-flex items-center px-5 py-2 hover:bg-black/10"> Home </a>
            </li>
            <li>
                <div x-data="{ show: false, menu: false, sub: false }" class="overflow-x-auto">
                    <a class="relative cursor-pointer inline-flex items-center text-white px-5 py-2 hover:bg-black/10"
                        x-on:click="show = ! show">Categories</a>
                    <div class="absolute">
                        <div class="bg-red-600 rounded-md p-3 min-w-[240px] top-1 w-full absolute z-10" x-show="show"
                            x-cloak @click.away="show = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95">
                            <ul
                                class="[&>li]:text-white [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]">
                                @foreach ($categories as $main)
                                    <li
                                        @if ($main->children->count() > 0) class="flex items-center justify-between" @endif>
                                        <a href="">{{ $main->name }}</a>
                                        @if ($main->children->count() > 0)
                                            <i x-on:click="menu = !menu"
                                                :class="menu ? 'fa fa-minus' : 'fa fa-plus'"></i>
                                        @endif
                                    </li>
                                    @if ($main->children->count() > 0)
                                        <div class="bg-red-600 rounded-md max-w-[240px] w-full relative"
                                            x-show="menu" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95">
                                            @foreach ($main->children as $key => $child)
                                                <div x-data="{ sub: false }"
                                                    class="[&>li]:text-white [&>li]:text-sm [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]">
                                                    <li
                                                        @if ($child->children->count() > 0) class="flex items-center justify-between" @endif>
                                                        <a href="#"> <i
                                                                class="fas fa-circle-chevron-right text-sm"></i>
                                                            {{ $child->name }} </a>
                                                        @if ($child->children->count() > 0)
                                                            <i x-on:click="sub = !sub"
                                                                :class="sub ? 'fa fa-minus' : 'fa fa-plus'"
                                                                @click.away="sub = false" class="text-sm"></i>
                                                        @endif
                                                    </li>
                                                    @if ($child->children->count() > 0)
                                                        <div class="bg-red-600 rounded-md max-w-[220px] w-full relative [&>li]:text-white [&>li]:text-sm [&>li]:cursor-pointer [&>li]:px-2 [&>li]:py-1 [&>li]:rounded-md [&>li]:transition-all hover:[&>li]:bg-black/10 active:[&>li]:bg-black/10 active:[&>li]:scale-[0.99]"
                                                            x-show="sub"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95">
                                                            @foreach ($child->children as $item)
                                                                <li><a href="#">
                                                                        <i
                                                                            class="fas fa-circle-chevron-right text-sm"></i>
                                                                        <i
                                                                            class="fas fa-circle-chevron-right text-sm"></i>
                                                                        {{ $item->name }}</a></li>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="{{ route('products') }}"
                    class="relative inline-flex items-center px-5 py-2 hover:bg-black/10"> Products
                </a>
            </li>
            <li>
                <a href="#" class="relative inline-flex items-center px-5 py-2 hover:bg-black/10"> Blogs </a>
            </li>
            <li>
                <a href="#" class="relative inline-flex items-center px-5 py-2 hover:bg-black/10"> About us </a>
            </li>
            <li>
                <a href="#" class="relative inline-flex items-center px-5 py-2 hover:bg-black/10"> Contact </a>
            </li>
        </ul>
    </nav>
</header>
