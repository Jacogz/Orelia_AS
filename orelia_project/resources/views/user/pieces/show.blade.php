@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    @if(!$viewData['piece'])
        <div class="alert alert-warning">{{ __('pieces.empty') }}</div>
    @else
        <div class="row g-4">
            <div class="col-md-5">
                <img src="{{ $viewData['piece']->getImageUrl() }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $viewData['piece']->getName() }}"
                     style="width: 100%; object-fit: cover; max-height: 420px;">
            </div>

            <div class="col-md-7">
                <h2>{{ $viewData['piece']->getName() }}</h2>
                <p class="text-muted mb-1">
                    <a href="{{ route('collections.show', $viewData['piece']->getCollectionId()) }}">
                        {{ $viewData['piece']->getCollection()->getName() }}
                    </a>
                </p>
                <span class="badge bg-secondary mb-3">{{ $viewData['piece']->getType() }}</span>

                <p>{{ $viewData['piece']->getDescription() }}</p>

                <h4 class="fw-bold my-3">${{ number_format($viewData['piece']->getPrice(), 2) }}</h4>

                <ul class="list-unstyled text-muted small mb-3">
                    @if($viewData['piece']->getSize())
                        <li>{{ __('pieces.size') }}: {{ $viewData['piece']->getSize() }}</li>
                    @endif
                    @if($viewData['piece']->getWeight())
                        <li>{{ __('pieces.weight') }}: {{ $viewData['piece']->getWeight() }}g</li>
                    @endif
                </ul>

                @if($viewData['piece']->getMaterials()->isNotEmpty())
                    <p class="mb-1"><strong>{{ __('pieces.materials') }}:</strong></p>
                    <div class="mb-3">
                        @foreach($viewData['piece']->getMaterials() as $material)
                            <span class="badge bg-light text-dark border me-1">{{ $material->getName() }}</span>
                        @endforeach
                    </div>
                @endif

                @if($viewData['piece']->getStock() > 0)
                    <p class="text-success small">{{ __('pieces.in_stock') }} ({{ $viewData['piece']->getStock() }})</p>
                    <form action="{{ route('cart.add', $viewData['piece']->getId()) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-dark mt-2">Add to cart</button>
                    </form>
                @else
                    <p class="text-danger small">{{ __('pieces.out_of_stock') }}</p>
                @endif

                <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary btn-sm mt-2">
                    {{ __('pieces.cancel') }}
                </a>
            </div>
        </div>
    @endif
@endsection