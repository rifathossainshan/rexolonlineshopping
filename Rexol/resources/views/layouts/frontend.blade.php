<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Rexol'))</title>
    <meta name="description" content="@yield('meta_description', 'Rexol - Premium E-commerce Shopping Experience')">
    <meta name="keywords" content="@yield('meta_keywords', 'ecommerce, shopping, fashion, electronics')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'Rexol'))">
    <meta property="og:description"
        content="@yield('meta_description', 'Rexol - Premium E-commerce Shopping Experience')">
    <meta property="og:image" content="@yield('og_image', asset('images/default-share.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', config('app.name', 'Rexol'))">
    <meta property="twitter:description"
        content="@yield('meta_description', 'Rexol - Premium E-commerce Shopping Experience')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/default-share.jpg'))">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex flex-col">
        @include('layouts.partials.navbar')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>

    <script>
        async function toggleWishlist(e, productId) {
            e.preventDefault();
            const btn = e.currentTarget;
            const icon = btn.querySelector('i');
            const originalHref = btn.href;

            try {
                const response = await fetch(originalHref, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update Badge (Assumes a Tailwind badge exists in navbar)
                    const badge = document.querySelector('.wishlist-count-badge');

                    if (badge) {
                        badge.textContent = data.count;
                        if (data.count === 0) badge.style.display = 'none';
                        else badge.style.display = 'flex';
                    }

                    // Update Icon
                    if (data.status === 'added') {
                        icon.className = 'fas fa-heart text-red-600';
                        btn.title = 'Remove from Wishlist';
                        if (originalHref.includes('wishlist/add')) {
                            btn.href = originalHref.replace('wishlist/add', 'wishlist/remove');
                        }
                    } else {
                        icon.className = 'far fa-heart text-black';
                        btn.title = 'Add to Wishlist';
                        if (originalHref.includes('wishlist/remove')) {
                            btn.href = originalHref.replace('wishlist/remove', 'wishlist/add');
                        }
                    }
                }
            } catch (error) {
                console.error('Error toggling wishlist:', error);
            }
        }
    </script>
</body>

</html>