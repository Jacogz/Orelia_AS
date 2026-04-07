@extends('layouts.app')

@section('title', 'Materials')

@section('content')
    <div class="mb-4">
        <h2>Our Materials</h2>
        <p class="text-muted">Discover the finest materials used in our jewelry</p>
    </div>

    @if($materials->isEmpty())
        <div class="alert alert-info">No materials available at the moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($materials as $material)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $material->getName() }}</h5>
                                <span class="badge bg-dark">{{ $material->getType() }}</span>
                            </div>
                            <p class="card-text text-muted">{{ $material->getDescription() }}</p>
                        </div>
                        <div class="card-footer bg-transparent d-flex align-items-center gap-2">
                            <span class="text-muted small">{{ $material->getColor() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection