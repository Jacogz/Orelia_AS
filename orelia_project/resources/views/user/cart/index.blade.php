@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4">
        <h2>{{ $viewData['subtitle'] }}</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(empty($viewData['cartItems']))
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary">Browse pieces</a>
    @else
        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Piece</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($viewData['cartItems'] as $pieceId => $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $item['piece']->getImageUrl() }}" alt="{{ $item['piece']->getName() }}"
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                    <a href="{{ route('pieces.show', $item['piece']->getId()) }}">
                                        {{ $item['piece']->getName() }}
                                    </a>
                                </div>
                            </td>
                            <td>${{ number_format($item['piece']->getPrice(), 2) }}</td>
                            <td style="width: 160px;">
                                <form action="{{ route('cart.update', $item['piece']->getId()) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['piece']->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
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
                <button type="submit" class="btn btn-outline-danger btn-sm">Clear cart</button>
            </form>

            <div class="text-end">
                <p class="fs-5 fw-bold mb-3">Total: ${{ number_format($viewData['total'], 2) }}</p>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark">Checkout</button>
                </form>
            </div>
        </div>
    @endif
@endsection
