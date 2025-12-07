<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rexol') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #f8f9fa;
            --accent-color: #FF4400;
            --text-color: #333;
            --bg-color: #fcfcfc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5 {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 0;
            padding: 10px 25px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #333;
            border-color: #333;
            transform: translateY(-2px);
        }

        .btn-outline-dark {
            border-radius: 0;
            text-transform: uppercase;
            font-weight: 600;
        }

        .btn-white {
            background-color: #fff !important;
            color: #000 !important;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-white:hover {
            background-color: #f8f9fa !important;
            transform: scale(1.1);
        }

        .rounded-circle {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Forms */
        .form-control,
        .form-select {
            border-radius: 0;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0;
            background-color: white;
        }
    </style>
</head>

<body>

    @include('layouts.partials.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                    // Update Badge
                    const badge = document.querySelector('.navbar .badge');
                    if (badge) {
                        badge.textContent = data.count;
                        if (data.count === 0) badge.remove();
                    } else if (data.count > 0) {
                        // Create badge if it doesn't exist
                        const navLink = document.querySelector('.navbar .fa-heart').closest('.nav-link');
                        const newBadge = document.createElement('span');
                        newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                        newBadge.style.fontSize = '0.6rem';
                        newBadge.textContent = data.count;
                        navLink.appendChild(newBadge);
                    }

                    // Update Icon and Link
                    if (data.status === 'added') {
                        icon.className = 'fas fa-heart text-danger';
                        btn.title = 'Remove from Wishlist';
                        // Construct remove URL
                        if (originalHref.includes('wishlist/add')) {
                            btn.href = originalHref.replace('wishlist/add', 'wishlist/remove');
                        }
                    } else if (data.status === 'removed') {
                        icon.className = 'far fa-heart';
                        btn.title = 'Add to Wishlist';
                        // Construct add URL
                        if (originalHref.includes('wishlist/remove')) {
                            btn.href = originalHref.replace('wishlist/remove', 'wishlist/add');
                        }
                    } else if (data.status === 'exists') {
                        // Edge case: UI thinks we can add, but backend says exists. 
                        // Update UI to match backend reality (remove mode).
                        icon.className = 'fas fa-heart text-danger';
                        btn.title = 'Remove from Wishlist';
                        if (originalHref.includes('wishlist/add')) {
                            btn.href = originalHref.replace('wishlist/add', 'wishlist/remove');
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