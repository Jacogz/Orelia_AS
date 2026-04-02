@extends('layouts.app')

@section('title', 'Pieces')

@section('content')
    <div class="mb-4">
        <h2>Our Pieces</h2>
        <p class="text-muted">Discover our exclusive luxury jewelry pieces</p>
    </div>

    @if($pieces->isEmpty())
        <div class="alert alert-info">No pieces available at the moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($pieces as $piece)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($piece->getImageUrl())
                            <img src="{{ $piece->getImageUrl() }}" class="card-img-top" alt="{{ $piece->getName() }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-muted">No image available</span>
                            </div>
                        @endif
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
                                <span class="text-success small">In stock ({{ $piece->getStock() }})</span>
                            @else
                                <span class="text-danger small">Out of stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection