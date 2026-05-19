@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">{{ $viewData['subtitle'] }}</h2>
    <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary btn-sm">
        {{ __('cart.back_to_pieces') }}
    </a>
</div>

@if(empty($viewData['cartItems']))
    <div class="alert alert-info">{{ __('cart.empty_message') }}</div>
    <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary">{{ __('pieces.title') }}</a>
@else

    {{-- Currency selector --}}
    @if(isset($viewData['rates']) && $viewData['rates']['available'])
    <div class="d-flex align-items-center gap-2 mb-4">
        <span style="font-family: 'Lato', sans-serif; font-size: 0.75rem; letter-spacing: 0.1em; color: #6c757d; text-transform: uppercase;">
            {{ __('pieces.view_prices_in') }}:
        </span>
        <button class="currency-btn active" onclick="setCartCurrency('COP', this)">COP</button>
        <button class="currency-btn" onclick="setCartCurrency('USD', this)">USD</button>
        <button class="currency-btn" onclick="setCartCurrency('EUR', this)">EUR</button>
    </div>
    @endif

    {{-- Desktop table --}}
    <div class="d-none d-md-block mb-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('cart.product') }}</th>
                    <th>{{ __('cart.quantity') }}</th>
                    <th>{{ __('cart.subtotal') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['cartItems'] as $pieceId => $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $item['piece']->getImageUrl() }}"
                                     alt="{{ $item['piece']->getName() }}"
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     class="rounded"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display:none; width:60px; height:60px; align-items:center; justify-content:center; background: var(--orelia-cream); border-radius: 0.375rem;">
                                    <i class="bi bi-gem" style="font-size: 1.2rem; color: var(--orelia-gold-light);"></i>
                                </div>
                                <div>
                                    <a href="{{ route('pieces.show', $item['piece']->getId()) }}" class="fw-semibold text-dark text-decoration-none">
                                        {{ $item['piece']->getName() }}
                                    </a>
                                    <small class="d-block text-muted cart-price"
                                        data-cop="{{ $item['piece']->getPrice() }}"
                                        @if(isset($viewData['rates']) && $viewData['rates']['available'])
                                        data-usd="{{ $viewData['rates']['USD'] }}"
                                        data-eur="{{ $viewData['rates']['EUR'] }}"
                                        @endif>
                                        ${{ number_format($item['piece']->getPrice(), 2) }} COP
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td style="width: 160px;">
                            <form action="{{ route('cart.update', $item['piece']->getId()) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['piece']->getStock() }}" class="form-control form-control-sm" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('cart.update') }}</button>
                            </form>
                        </td>
                        <td>
                            <span class="cart-subtotal"
                                data-cop="{{ $item['subtotal'] }}"
                                @if(isset($viewData['rates']) && $viewData['rates']['available'])
                                data-usd="{{ $viewData['rates']['USD'] }}"
                                data-eur="{{ $viewData['rates']['EUR'] }}"
                                @endif>
                                ${{ number_format($item['subtotal'], 2) }} COP
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $item['piece']->getId()) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('cart.remove') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile cards --}}
    <div class="d-md-none mb-4">
        @foreach($viewData['cartItems'] as $pieceId => $item)
        <div class="card border-0 shadow-sm mb-3 p-3">
            <div class="d-flex gap-3 mb-3">
                <img src="{{ $item['piece']->getImageUrl() }}"
                     alt="{{ $item['piece']->getName() }}"
                     style="width: 70px; height: 70px; object-fit: cover;"
                     class="rounded"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display:none; width:70px; height:70px; align-items:center; justify-content:center; background: var(--orelia-cream); border-radius: 0.375rem;">
                    <i class="bi bi-gem" style="font-size: 1.2rem; color: var(--orelia-gold-light);"></i>
                </div>
                <div class="flex-grow-1">
                    <a href="{{ route('pieces.show', $item['piece']->getId()) }}" class="fw-semibold text-dark text-decoration-none d-block">
                        {{ $item['piece']->getName() }}
                    </a>
                    <small class="text-muted cart-price"
                        data-cop="{{ $item['piece']->getPrice() }}"
                        @if(isset($viewData['rates']) && $viewData['rates']['available'])
                        data-usd="{{ $viewData['rates']['USD'] }}"
                        data-eur="{{ $viewData['rates']['EUR'] }}"
                        @endif>
                        ${{ number_format($item['piece']->getPrice(), 2) }} COP
                    </small>
                    <div class="fw-semibold mt-1 cart-subtotal"
                        data-cop="{{ $item['subtotal'] }}"
                        @if(isset($viewData['rates']) && $viewData['rates']['available'])
                        data-usd="{{ $viewData['rates']['USD'] }}"
                        data-eur="{{ $viewData['rates']['EUR'] }}"
                        @endif>
                        {{ __('cart.subtotal') }}: ${{ number_format($item['subtotal'], 2) }} COP
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('cart.update', $item['piece']->getId()) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    @method('PUT')
                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['piece']->getStock() }}" class="form-control form-control-sm" style="width: 70px;">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">{{ __('cart.update') }}</button>
                </form>
                <form action="{{ route('cart.remove', $item['piece']->getId()) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('cart.remove') }}</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <form action="{{ route('cart.removeAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">{{ __('cart.clear') }}</button>
        </form>
        <div class="text-end">
            <p class="fs-5 fw-bold mb-3">
                {{ __('cart.total') }}:
                <span class="cart-total"
                    data-cop="{{ $viewData['total'] }}"
                    @if(isset($viewData['rates']) && $viewData['rates']['available'])
                    data-usd="{{ $viewData['rates']['USD'] }}"
                    data-eur="{{ $viewData['rates']['EUR'] }}"
                    @endif>
                    ${{ number_format($viewData['total'], 2) }} COP
                </span>
            </p>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark w-100">{{ __('cart.checkout') }}</button>
            </form>
        </div>
    </div>
@endif
@endsection