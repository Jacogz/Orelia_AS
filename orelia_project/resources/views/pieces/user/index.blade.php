@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4">
        <h2>{{ $viewData['title'] }}</h2>
        <p class="text-muted">{{ $viewData['subtitle'] }}</p>
    </div>

    @if($viewData['pieces']->isEmpty())
        <div class="alert alert-info">{{ __('pieces.empty_user') }}</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($viewData['pieces'] as $piece)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $piece->getImageUrl() }}" class="card-img-top" alt="{{ $piece->getName() }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $piece->getName() }}</h5>
                            <p class="card-text text-muted small">{{ $piece->getCollection()->getName() }}</p>
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
@endsection