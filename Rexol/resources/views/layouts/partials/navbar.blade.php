<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase fs-4" href="{{ url('/') }}" style="letter-spacing: -1px;">
            {{ config('app.name', 'Rexol') }}
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-uppercase fw-bold px-3 {{ request()->is('/') ? 'text-white' : 'text-white-50' }}"
                        href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase fw-bold px-3 {{ request()->routeIs('products.*') ? 'text-white' : 'text-white-50' }}"
                        href="{{ route('products.index') }}">Shop</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-4">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="toggleSearch(event)"><i
                            class="fas fa-search fs-5"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"
                        onclick="alert('Wishlist feature coming soon!'); return false;"><i
                            class="fas fa-heart fs-5"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-bag fs-5 text-white"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.6rem;">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase fw-bold text-white" href="#" role="button"
                            data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-0 mt-3 p-0 overflow-hidden">
                            <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}">My Dashboard</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light rounded-0 text-uppercase fw-bold px-4 pt-2"
                            href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>

    <!-- Search Overlay -->
    <div id="search-bar" class="w-100 bg-white py-3 border-bottom position-absolute start-0 top-100 shadow-sm"
        style="display: none; z-index: 1000;">
        <div class="container">
            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control border-0 form-control-lg"
                    placeholder="SEARCH PRODUCTS..." autofocus>
                <button type="submit" class="btn btn-white"><i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>

    <script>
        function toggleSearch(e) {
            e.preventDefault();
            const searchBar = document.getElementById('search-bar');
            if (searchBar.style.display === 'none') {
                searchBar.style.display = 'block';
                searchBar.querySelector('input').focus();
            } else {
                searchBar.style.display = 'none';
            }
        }
    </script>
</nav>