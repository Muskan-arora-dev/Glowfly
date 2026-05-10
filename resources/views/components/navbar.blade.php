<!-- Navbar -->

<style>
.profile {
  display: flex;
  align-items: center;
  gap: 10px;
  position: relative;
}

/* Avatar Styling */
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 0%, #f9f5f1 0%, #f0ebe6 35%, #f2ebe9 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #5a3e36;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(90, 62, 54, 0.3), 0 8px 15px rgba(90, 62, 54, 0.2), inset 0 -2px 4px rgba(255, 255, 255, 0.3);
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.avatar:hover {
  transform: scale(1.15);
  box-shadow: 0 6px 12px rgba(90,62,54,0.35), 0 12px 25px rgba(90,62,54,0.25), inset 0 -2px 4px rgba(255,255,255,0.35);
}

/* Dropdown Menu */
.dropdown {
  transform: translateY(-10px);
  opacity: 0;
  transition: all 0.3s ease;
  pointer-events: none;
}

.group:hover .dropdown {
  transform: translateY(0);
  opacity: 1;
  pointer-events: auto;
}

/* Scrollbar for long content */
.dropdown::-webkit-scrollbar {
  width: 6px;
}

.dropdown::-webkit-scrollbar-thumb {
  background-color: rgba(255, 211, 155, 0.5);
  border-radius: 3px;
}
</style>

<nav class="bg-[#654321] text-[#fdf9ef] dark:bg-gray-800 dark:text-gray-100 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <img class="h-16 sm:h-24 w-auto" src="{{ asset('images/img2.png') }}" alt="Logo">
                </a>
            </div>

            <!-- Desktop Search -->
            <div class="hidden md:flex flex-1 justify-center px-4 sm:px-10">
                <div class="flex w-full max-w-lg">
                    <input type="text" placeholder="Search products..."
                        class="flex-1 px-4 py-2 rounded-l-full text-[#654321] placeholder-[#401d07] bg-white focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] shadow-sm">
                    <button class="px-6 py-2 rounded-r-full bg-[#401d07] text-[#fdf9ef] font-medium transition shadow-sm">
                        Go
                    </button>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-3 sm:space-x-4">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305] transition">Home</a>
                <a href="{{ route('categories.all') }}" class="px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305] transition">Items</a>
                <a href="{{ route('orders.my') }}" class="px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305] transition">Orders</a>

                <!-- Become Delivery Partner -->
                @auth
                    @if(Auth::user())
                       <a href="{{ route('delivery.apply') }}" class="px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305]  transition">
                            Partner
                        </a>
                        @elseif(Auth::user()->delivery_status == 'pending')
                        <span>⏳ Under Review</span>
                    @endif
                @endauth

                <!-- Wishlist -->
                <a href="{{ route('wishlist.show') }}" class="relative px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305] transition flex items-center">
                    Wishlist
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 
                            4.5 0 116.364 6.364L12 21l-7.682-7.682a4.5 
                            4.5 0 010-6.364z"/>
                    </svg>
                    @auth
                        <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ \App\Models\Wishlist::where('user_id', Auth::id())->count() }}
                        </span>
                    @endauth
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.show') }}" class="relative px-3 py-2 rounded-md bg-[#401d07] hover:bg-[#2e1305] transition flex items-center">
                    Cart
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 inline-block">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.5 13.5a2 2 0 0 0 2 1.5h9a2 2 0 0 0 2-1.5L23 6H6"></path>
                    </svg>
                    @auth
                        <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ \App\Models\Cart::where('user_id', Auth::id())->count() }}
                        </span>
                    @endauth
                </a>

                <!-- Auth -->
                @guest
                    <a href="{{ route('login.page') }}" class="px-4 py-2 rounded-md bg-[#FFD39B] text-[#5A2E0A] font-semibold shadow hover:bg-[#f5c18a] transition">
                        Sign In
                    </a>
                @else
                    <div class="profile relative group">
                        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div class="dropdown absolute right-0 mt-2 w-52 bg-[#1c0f05] text-[#FFD39B] rounded-lg shadow-xl opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transform -translate-y-2 transition-all duration-300 z-50">
                            <div class="px-4 py-3 border-b border-[#FFD39B]/30">
                                <p class="font-semibold text-lg text-[#FFD39B]">{{ Auth::user()->name }}</p>
                                <p class="text-sm opacity-80 text-[#FFD39B]">{{ Auth::user()->email }}</p>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="w-full text-left px-4 py-2 hover:bg-[#FFD39B] hover:text-[#2e1305] rounded-b-md transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Toggle Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="focus:outline-none">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden max-h-0 overflow-hidden transition-all duration-500 ease-in-out" id="mobile-menu">
        <div class="px-4 pt-4 pb-4 space-y-2 bg-[#654321]">

            <!-- Mobile Search -->
            <div class="flex w-full mb-2">
                <input type="text" placeholder="Search products..." class="flex-1 px-4 py-2 rounded-l-full text-[#654321] placeholder-[#401d07] bg-white focus:outline-none focus:ring-2 focus:ring-[#F5DEB3] shadow-sm">
                <button class="px-4 py-2 rounded-r-full bg-[#401d07] text-[#fdf9ef] font-medium transition shadow-sm">Go</button>
            </div>

            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md hover:bg-[#401d07]">Home</a>
            <a href="{{ route('orders.my') }}" class="block px-3 py-2 rounded-md hover:bg-[#401d07]">Orders</a>
            <a href="{{ route('wishlist.show') }}" class="block px-3 py-2 rounded-md hover:bg-[#401d07]">Wishlist</a>
            <a href="{{ route('cart.show') }}" class="block px-3 py-2 rounded-md hover:bg-[#401d07]">Cart</a>

            @auth
                @if(Auth::user()->role != 'admin')
                    <a href="{{ url('/apply-delivery') }}" class="block px-3 py-2 rounded-md bg-[#401d07] text-[#fdf9ef] font-semibold hover:bg-[#f5c18a] transition">
                        Become a Delivery Partner
                    </a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login.page') }}" class="block px-3 py-2 rounded-md bg-[#FFD39B] text-[#5A2E0A] font-semibold hover:bg-[#f5c18a]">Sign In</a>
            @endguest

            @auth
                <div class="border-t border-[#FFD39B]/40 pt-2">
                    <p class="px-3 py-2 text-[#FFD39B] font-semibold">{{ Auth::user()->name }}</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md hover:bg-[#f5e6d3]">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    let isOpen = false;

    btn.addEventListener('click', () => {
        if (!isOpen) {
            menu.style.maxHeight = menu.scrollHeight + "px";
        } else {
            menu.style.maxHeight = "0";
        }
        isOpen = !isOpen;
    });
});
</script>
