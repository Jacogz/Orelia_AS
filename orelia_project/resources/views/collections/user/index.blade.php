@extends('layouts.app')

@section('title', 'Collections')

@section('content')
    <div class="mb-4">
        <h2>Our Collections</h2>
        <p class="text-muted">Explore our exclusive jewelry collections</p>
    </div>

    @if($collections->isEmpty())
        <div class="alert alert-info">No collections available at the moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($collections as $collection)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $collection->getName() }}</h5>
                            <p class="card-text text-muted">{{ $collection->getDescription() }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('pieces.index') }}" class="btn btn-outline-dark btn-sm">
                                Explore Collection
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection