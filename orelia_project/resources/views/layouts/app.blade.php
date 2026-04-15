<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />
    <title>@yield('title', 'Orelia')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">ORELIA</a>

            <div class="d-flex align-items-center ms-auto">
                <a href="{{ route('pieces.index') }}">{{ __('general.pieces') }}</a>
                <a href="{{ route('materials.index') }}">{{ __('general.materials') }}</a>
                <a href="{{ route('collections.index') }}">{{ __('general.collections') }}</a>
                <a href="{{ route('cart.index') }}">{{ __('general.cart') }}</a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">{{ __('general.admin_dashboard') }}</a>
                        <a href="{{ route('admin.pieces.index') }}">{{ __('general.manage_pieces') }}</a>
                        <a href="{{ route('admin.materials.index') }}">{{ __('general.manage_materials') }}</a>
                        <a href="{{ route('admin.collections.index') }}">{{ __('general.manage_collections') }}</a>
                    @endif
                @endauth

                <div class="vr bg-white mx-2 d-none d-lg-block"></div>
                @guest
                    <a class="nav-link active" href="{{ route('login') }}">{{ __('general.login') }}</a>
                    <a class="nav-link active" href="{{ route('register') }}">{{ __('general.register') }}</a>
                @else
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        <a role="button" class="nav-link active" id="logout-button">{{ __('general.logout') }}</a>
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ __('general.success') }}:</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ __('general.error') }}:</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ __('general.validation_errors') }}:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('logout-button') &&
        document.getElementById('logout-button').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>
</body>
</html>