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
        <div class="alert alert-info">
            {{ __('cart.empty_message') }}
        </div>
    @else
        <div class="card shadow-sm mb-4">
            <div class="card-body table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('cart.product') }}</th>
                            <th>{{ __('cart.quantity') }}</th>
                            <th>{{ __('cart.subtotal') }}</th>
                            <th>{{ __('cart.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($viewData['cartItems'] as $pieceId => $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item['piece']->getName() }}</div>
                                    <small class="text-muted">{{ __('cart.currency') }}{{ number_format($item['piece']->getPrice(), 2) }}</small>
                                </td>
                                <td style="max-width: 120px;">
                                    <form action="{{ route('cart.update', $pieceId) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('cart.update') }}
                                        </button>
                                    </form>
                                </td>
                                <td>{{ __('cart.currency') }}{{ number_format($item['subtotal'], 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $pieceId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            {{ __('cart.remove') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-0">{{ __('cart.total') }}: {{ __('cart.currency') }}{{ number_format($viewData['total'], 2) }}</h4>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('cart.removeAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary">
                        {{ __('cart.clear') }}
                    </button>
                </form>

                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark">
                        {{ __('cart.checkout') }}
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection