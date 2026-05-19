@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $viewData['title'] }}</h2>
        <p class="text-muted mb-0">{{ $viewData['subtitle'] }}</p>
    </div>
    <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary">
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

    <div class="table-responsive mb-4">
        <table class="table align-middle">
            <thead class="table-light">
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
                                     class="rounded">
                                <div>
                                    <a href="{{ route('pieces.show', $item['piece']->getId()) }}">
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

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
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
                <button type="submit" class="btn btn-dark">{{ __('cart.checkout') }}</button>
            </form>
        </div>
    </div>
@endif
@endsection