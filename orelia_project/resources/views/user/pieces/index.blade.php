@extends('layouts.app')

@section('title', $viewData['title'])

@push('styles')
<style>
    .orelia-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .orelia-card:hover .orelia-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="mb-4 text-center">
    <h2>{{ $viewData['title'] }}</h2>
</div>

<form method="GET" action="{{ route('pieces.index') }}" class="card p-3 mb-5 border-0 shadow-sm">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control"
                placeholder="{{ __('pieces.name') }}" value="{{ request('name') }}" />
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">{{ __('pieces.all_types') }}</option>
                @foreach ($viewData['types'] as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="collection_id" class="form-select">
                <option value="">{{ __('pieces.all_collections') }}</option>
                @foreach ($viewData['collections'] as $collection)
                    <option value="{{ $collection->getId() }}" {{ request('collection_id') == $collection->getId() ? 'selected' : '' }}>
                        {{ $collection->getName() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="min_price" class="form-control"
                placeholder="{{ __('pieces.min_price') }}" value="{{ request('min_price') }}" min="0" />
        </div>
        <div class="col-md-1">
            <input type="number" name="max_price" class="form-control"
                placeholder="{{ __('pieces.max_price') }}" value="{{ request('max_price') }}" min="0" />
        </div>
        <div class="col-md-2">
            <select name="stock" class="form-select">
                <option value="">{{ __('pieces.all_stock') }}</option>
                <option value="available" {{ request('stock') == 'available' ? 'selected' : '' }}>
                    {{ __('pieces.in_stock') }}
                </option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('pieces.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
        </div>
    </div>
</form>

@if($viewData['pieces']->isEmpty())
    <div class="text-center text-muted py-5 text-uppercase small">{{ __('pieces.empty_user') }}</div>
@else
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($viewData['pieces'] as $piece)
            <div class="col orelia-card">
                <div class="position-relative overflow-hidden" style="background:#f7f7f5">
                    <img src="{{ $piece->getImageUrl() }}" alt="{{ $piece->getName() }}"
                        class="w-100" style="aspect-ratio:1/1; object-fit:cover; display:block">
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 orelia-overlay">
                        @if($piece->getStock() > 0)
                            <form action="{{ route('cart.add', $piece->getId()) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark w-100 rounded-0 small text-uppercase">
                                    {{ __('pieces.add_to_cart') }}
                                </button>
                            </form>
                        @else
                            <span class="d-block text-center text-danger small text-uppercase">
                                {{ __('pieces.out_of_stock') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ route('pieces.show', $piece->getId()) }}"
                        class="d-block text-uppercase small fw-semibold text-dark text-decoration-none">
                        {{ $piece->getName() }}
                    </a>
                    <span class="d-block text-muted small">{{ $piece->getCollection()->getName() }}</span>
                    <span class="d-block small">${{ number_format($piece->getPrice(), 2) }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection