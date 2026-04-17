@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4">
        <h2>{{ $viewData['title'] }}</h2>
        <p class="text-muted">{{ $viewData['subtitle'] }}</p>
    </div>

    @if($viewData['collections']->isEmpty())
        <div class="alert alert-info">{{ __('collections.empty_user') }}</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($viewData['collections'] as $collection)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $collection->getName() }}</h5>
                            <p class="card-text text-muted">{{ $collection->getDescription() }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('collections.show', $collection->getId()) }}" class="btn btn-outline-dark btn-sm">
                                {{ __('collections.explore') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection