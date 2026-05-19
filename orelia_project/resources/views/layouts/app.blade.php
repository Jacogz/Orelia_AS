<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <title>@yield('title', 'Orelia')</title>
    <style>
        :root {
            --orelia-gold:       #B8962E;
            --orelia-gold-light: #C9A94E;
            --orelia-gold-muted: rgba(184, 150, 46, 0.25);
            --orelia-dark:       #1A1A1A;
            --orelia-dark-soft:  #2C2C2C;
            --orelia-cream:      #F9F6F0;
            --orelia-text:       #2E2E2E;
            --orelia-border:     rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: var(--orelia-cream);
            color: var(--orelia-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main { flex: 1; }

        h1, h2, .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
        }

        .orelia-navbar {
            background-color: var(--orelia-dark);
            border-bottom: 1px solid var(--orelia-gold-muted);
        }

        .orelia-navbar .navbar-brand {
            color: var(--orelia-gold) !important;
            font-size: 1.75rem;
            letter-spacing: 5px;
            font-weight: 700;
            text-decoration: none;
        }

        .orelia-navbar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.78rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            padding: 0.5rem 0.85rem !important;
            transition: color 0.2s ease;
        }

        .orelia-navbar .nav-link:hover,
        .orelia-navbar .nav-link.active {
            color: var(--orelia-gold) !important;
        }

        .orelia-navbar .navbar-toggler {
            border-color: var(--orelia-gold-muted);
        }

        .orelia-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28184%2C150%2C46%2C1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .orelia-navbar .dropdown-menu {
            background-color: var(--orelia-dark-soft);
            border: 1px solid var(--orelia-gold-muted);
        }

        .orelia-navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
            padding: 0.55rem 1.2rem;
        }

        .orelia-navbar .dropdown-item:hover {
            background-color: var(--orelia-gold-muted);
            color: var(--orelia-gold);
        }

        .orelia-navbar .dropdown-divider {
            border-color: var(--orelia-gold-muted);
        }

        .btn-dark {
            background-color: var(--orelia-dark);
            border-color: var(--orelia-dark);
        }

        .btn-dark:hover {
            background-color: var(--orelia-dark-soft);
            border-color: var(--orelia-dark-soft);
        }

        .card {
            border: 1px solid var(--orelia-border);
            border-radius: 0.5rem;
            background-color: #fff;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid var(--orelia-border);
        }

        .table thead th {
            background-color: var(--orelia-dark);
            color: #fff;
            font-size: 0.78rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 400;
            border-color: var(--orelia-dark);
        }

        .table tbody tr:hover {
            background-color: rgba(184, 150, 46, 0.05);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--orelia-gold);
            box-shadow: 0 0 0 0.2rem rgba(184, 150, 46, 0.2);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 0.35rem;
        }

        .orelia-footer {
            background-color: var(--orelia-dark);
            border-top: 1px solid var(--orelia-gold-muted);
            color: rgba(255, 255, 255, 0.65);
        }

        .orelia-footer .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            color: var(--orelia-gold);
            font-size: 1.6rem;
            letter-spacing: 5px;
            font-weight: 700;
        }

        .orelia-footer .footer-heading {
            font-size: 0.7rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
        }

        .orelia-footer a {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .orelia-footer a:hover { color: var(--orelia-gold); }

        .orelia-footer .footer-divider {
            border-color: var(--orelia-gold-muted);
            margin: 2rem 0 1.5rem;
        }

        .orelia-footer .footer-copy {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .orelia-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .orelia-card:hover .orelia-overlay {
            opacity: 1;
        }

        .currency-btn {
            font-family: 'Lato', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            padding: 0.3rem 0.8rem;
            border: 1px solid var(--orelia-gold);
            color: var(--orelia-gold);
            background: transparent;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .currency-btn.active {
            background: var(--orelia-gold);
            color: #fff;
        }

        .currency-btn:hover {
            background: var(--orelia-gold);
            color: #fff;
        }
    </style>
    @stack('styles')
</head>

<body>

<nav class="navbar navbar-expand-lg orelia-navbar py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">ORELIA</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="{{ __('general.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pieces.*') && !request()->routeIs('admin.*') ? 'active' : '' }}"
                       href="{{ route('pieces.index') }}">{{ __('general.pieces') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('materials.*') && !request()->routeIs('admin.*') ? 'active' : '' }}"
                       href="{{ route('materials.index') }}">{{ __('general.materials') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('collections.*') && !request()->routeIs('admin.*') ? 'active' : '' }}"
                       href="{{ route('collections.index') }}">{{ __('general.collections') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('exchangerate.*') ? 'active' : '' }}"
                       href="{{ route('exchangerate.index') }}">{{ __('general.converter') }}</a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-lg-center gap-lg-1">
                <li class="nav-item d-flex align-items-center gap-1 me-2">
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="nav-link py-0 px-1"
                       style="{{ app()->getLocale() === 'en' ? 'color: var(--orelia-gold) !important;' : '' }}">EN</a>
                    <span style="color: rgba(255,255,255,0.3); font-size: 0.7rem;">|</span>
                    <a href="{{ route('lang.switch', 'es') }}"
                       class="nav-link py-0 px-1"
                       style="{{ app()->getLocale() === 'es' ? 'color: var(--orelia-gold) !important;' : '' }}">ES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}"
                       href="{{ route('cart.index') }}">
                        <span class="position-relative">
                            <i class="bi bi-bag me-1"></i>{{ __('general.cart') }}
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                      style="background: var(--orelia-gold); font-size: 0.6rem; padding: 0.25em 0.45em;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </span>
                    </a>
                </li>

                @auth
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-shield-check me-1"></i>{{ __('general.admin') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-grid me-2"></i>{{ __('general.admin_dashboard') }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.pieces.index') }}">
                                        <i class="bi bi-gem me-2"></i>{{ __('general.manage_pieces') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.materials.index') }}">
                                        <i class="bi bi-layers me-2"></i>{{ __('general.manage_materials') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.collections.index') }}">
                                        <i class="bi bi-collection me-2"></i>{{ __('general.manage_collections') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link border-0 shadow-none p-0 px-2">
                                <i class="bi bi-box-arrow-right me-1"></i>{{ __('general.logout') }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">{{ __('general.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                           href="{{ route('register') }}">{{ __('general.register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>{{ __('general.success') }}:</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('general.close') }}"></button>
        </div>
    @endif

    @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>{{ __('general.error') }}:</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('general.close') }}"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="orelia-footer py-5 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="footer-brand mb-2">ORELIA</div>
                <p class="small mb-0">{{ __('general.footer_tagline') }}</p>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="footer-heading">{{ __('general.footer_shop') }}</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('pieces.index') }}">{{ __('general.pieces') }}</a></li>
                    <li class="mb-2"><a href="{{ route('collections.index') }}">{{ __('general.collections') }}</a></li>
                    <li class="mb-2"><a href="{{ route('materials.index') }}">{{ __('general.materials') }}</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="footer-heading">{{ __('general.footer_account') }}</h6>
                <ul class="list-unstyled mb-0">
                    @auth
                        <li class="mb-2"><a href="{{ route('cart.index') }}">{{ __('general.cart') }}</a></li>
                    @else
                        <li class="mb-2"><a href="{{ route('login') }}">{{ __('general.login') }}</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}">{{ __('general.register') }}</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <h6 class="footer-heading">{{ __('general.footer_contact') }}</h6>
                <p class="small mb-0">{{ __('general.footer_contact_info') }}</p>
            </div>
        </div>

        <hr class="footer-divider">

        <p class="footer-copy mb-0">&copy; {{ date('Y') }} Orelia. {{ __('general.footer_rights') }}</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    function setCurrency(currency, btn) {
        document.querySelectorAll('.currency-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.piece-price').forEach(el => {
            const cop = parseFloat(el.dataset.cop);
            const usd = parseFloat(el.dataset.usd);
            const eur = parseFloat(el.dataset.eur);

            if (currency === 'COP') {
                el.textContent = '$' + cop.toLocaleString('es-CO', {minimumFractionDigits: 2}) + ' COP';
            } else if (currency === 'USD') {
                el.textContent = '$' + (cop * usd).toLocaleString('en-US', {minimumFractionDigits: 2}) + ' USD';
            } else if (currency === 'EUR') {
                el.textContent = '€' + (cop * eur).toLocaleString('de-DE', {minimumFractionDigits: 2}) + ' EUR';
            }
        });
    }

    function setCartCurrency(currency, btn) {
        document.querySelectorAll('.currency-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.cart-price, .cart-subtotal, .cart-total').forEach(el => {
            const cop = parseFloat(el.dataset.cop);
            const usd = parseFloat(el.dataset.usd);
            const eur = parseFloat(el.dataset.eur);

            if (currency === 'COP') {
                el.textContent = '$' + cop.toLocaleString('es-CO', {minimumFractionDigits: 2}) + ' COP';
            } else if (currency === 'USD') {
                el.textContent = '$' + (cop * usd).toLocaleString('en-US', {minimumFractionDigits: 2}) + ' USD';
            } else if (currency === 'EUR') {
                el.textContent = '€' + (cop * eur).toLocaleString('de-DE', {minimumFractionDigits: 2}) + ' EUR';
            }
        });
    }
</script>

@yield('scripts')

</body>
</html>