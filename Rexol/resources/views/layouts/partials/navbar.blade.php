<nav
    class="bg-black text-white py-4 sticky top-0 z-50 transition-all duration-300 backdrop-blur-md bg-opacity-90 border-b border-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a class="text-2xl font-bold tracking-tighter hover:text-gray-300 transition" href="{{ url('/') }}">
                {{ config('app.name', 'REXOL') }}
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-sm font-bold uppercase tracking-wide hover:text-accent transition {{ request()->is('/') ? 'text-white' : 'text-gray-400' }}"
                    href="{{ url('/') }}">Home</a>
                <a class="text-sm font-bold uppercase tracking-wide hover:text-accent transition {{ request()->routeIs('products.*') ? 'text-white' : 'text-gray-400' }}"
                    href="{{ route('products.index') }}">Shop</a>
            </div>

            <!-- Icons & Mobile Toggle -->
            <div class="flex items-center space-x-6">
                <!-- Search -->
                <button onclick="toggleSearch(event)"
                    class="text-white hover:text-accent transition focus:outline-none">
                    <i class="fas fa-search text-lg"></i>
                </button>

                <!-- Wishlist -->
                <a class="relative text-white hover:text-accent transition" href="{{ route('wishlist.index') }}">
                    <i class="fas fa-heart text-lg"></i>
                    <span
                        class="wishlist-count-badge absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ (session('wishlist') && count(session('wishlist')) > 0) ? 'flex' : 'hidden' }}">
                        {{ session('wishlist') ? count(session('wishlist')) : 0 }}
                    </span>
                </a>

                <!-- Cart -->
                <a class="relative text-white hover:text-accent transition" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-bag text-lg"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <!-- Auth/Notifications -->
                @auth
                    <!-- Notifications Dropdown -->
                    <div class="relative group">
                        <button class="relative text-white hover:text-accent transition focus:outline-none"
                            onclick="markNotificationsRead(this)">
                            <i class="fas fa-bell text-lg"></i>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span
                                    class="badge absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 mt-2 w-80 bg-white text-black shadow-xl rounded-none hidden group-hover:block border border-gray-100 z-50">
                            <div
                                class="p-4 border-b border-gray-100 font-bold uppercase text-xs tracking-wider text-gray-500">
                                Notifications</div>
                            <div class="max-h-64 overflow-y-auto">
                                @forelse(Auth::user()->unreadNotifications as $notification)
                                    <a href="{{ $notification->data['action_url'] ?? '#' }}"
                                        class="block p-4 border-b border-gray-50 hover:bg-gray-50 transition">
                                        <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-gray-400 text-sm">No new notifications</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button
                            class="text-sm font-bold uppercase tracking-wide hover:text-accent transition flex items-center space-x-1 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-48 bg-white text-black shadow-xl rounded-none hidden group-hover:block border border-gray-100 z-50">
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-3 hover:bg-gray-50 text-sm hover:text-accent transition">Dashboard</a>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-3 hover:bg-gray-50 text-sm hover:text-accent transition">Admin
                                    Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-3 hover:bg-red-50 text-sm text-red-600 hover:text-red-700 transition">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-bold uppercase tracking-wide hover:text-accent transition">Login</a>
                    <a href="{{ route('register') }}"
                        class="hidden md:inline-block bg-white text-black px-4 py-2 text-sm font-bold uppercase tracking-wide hover:bg-gray-200 transition">Register</a>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white focus:outline-none"
                    onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-800">
            <a href="{{ url('/') }}"
                class="block py-3 text-sm font-bold uppercase tracking-wide text-gray-300 hover:text-white border-b border-gray-800">Home</a>
            <a href="{{ route('products.index') }}"
                class="block py-3 text-sm font-bold uppercase tracking-wide text-gray-300 hover:text-white border-b border-gray-800">Shop</a>
        </div>
    </div>

    <!-- Search Overlay -->
    <div id="search-bar"
        class="absolute top-full left-0 w-full bg-white shadow-lg py-6 px-4 transition-all duration-300 transform origin-top hidden z-40 border-t border-gray-100">
        <div class="container mx-auto max-w-3xl">
            <form action="{{ route('products.index') }}" method="GET"
                class="flex items-center border-b-2 border-black pb-2">
                <i class="fas fa-search text-gray-400 mr-4"></i>
                <input type="text" name="search"
                    class="w-full text-xl font-bold uppercase placeholder-gray-300 focus:outline-none"
                    placeholder="Search for products..." autofocus>
                <button type="button" onclick="toggleSearch(event)" class="text-gray-400 hover:text-black">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleSearch(e) {
            e.preventDefault();
            const searchBar = document.getElementById('search-bar');
            if (searchBar.classList.contains('hidden')) {
                searchBar.classList.remove('hidden');
                searchBar.querySelector('input').focus();
            } else {
                searchBar.classList.add('hidden');
            }
        }

        async function markNotificationsRead(element) {
            const badge = element.querySelector('.badge');
            if (!badge) return;

            try {
                await fetch('{{ route("notifications.markRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                badge.remove();
            } catch (error) {
                console.error('Error marking notifications read:', error);
            }
        }
    </script>
</nav>