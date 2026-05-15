@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="mb-4 text-center">
    <h2>{{ $viewData['title'] }}</h2>
</div>

<form method="GET" action="{{ route('collections.index') }}" class="card p-3 mb-5 border-0 shadow-sm">
    <div class="row g-2 justify-content-center">
        <div class="col-md-5">
            <input type="text" name="name" class="form-control"
                placeholder="{{ __('collections.name') }}" value="{{ request('name') }}" />
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('collections.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
        </div>
    </div>
</form>

@if($viewData['collections']->isEmpty())
    <div class="text-center text-muted py-5 text-uppercase small">{{ __('collections.empty_user') }}</div>
@else
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($viewData['collections'] as $collection)
            <div class="col">
                <a href="{{ route('collections.show', $collection->getId()) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 px-3">
                        <div class="card-body">
                            <i class="bi bi-gem fs-3 mb-2 d-block" style="color: var(--orelia-gold)"></i>
                            <p class="fw-semibold text-uppercase small mb-1">{{ $collection->getName() }}</p>
                            <p class="text-muted small mb-0">{{ $collection->getDescription() }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection