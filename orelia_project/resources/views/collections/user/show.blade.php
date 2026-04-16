@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4">
        <h2>{{ $viewData['title'] }}</h2>
        @if($viewData['collection'])
            <p class="text-muted">{{ $viewData['collection']->getDescription() }}</p>
        @endif
    </div>

    @if(!$viewData['collection'])
        <div class="alert alert-warning">{{ __('collections.collection_not_found') }}</div>
    @elseif($viewData['pieces']->isEmpty())
        <div class="alert alert-info">{{ __('collections.no_pieces') }}</div>
    @else
        <h4 class="mb-3">{{ __('collections.pieces') }}</h4>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($viewData['pieces'] as $piece)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $piece->getImageUrl() }}" class="card-img-top" alt="{{ $piece->getName() }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $piece->getName() }}</h5>
                            <p class="card-text">{{ $piece->getDescription() }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">${{ number_format($piece->getPrice(), 2) }}</span>
                                <span class="badge bg-secondary">{{ $piece->getType() }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            @if($piece->getStock() > 0)
                                <span class="text-success small">{{ __('pieces.in_stock') }} ({{ $piece->getStock() }})</span>
                            @else
                                <span class="text-danger small">{{ __('pieces.out_of_stock') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('collections.index') }}" class="btn btn-outline-secondary btn-sm">
            {{ __('collections.cancel') }}
        </a>
    </div>
@endsection