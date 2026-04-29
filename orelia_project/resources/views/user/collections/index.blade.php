@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4 text-center">
        <h2>{{ $viewData['title'] }}</h2>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('collections.index') }}" class="card p-3 mb-5 border-0 shadow-sm">
        <div class="row g-2 justify-content-center">
            <div class="col-md-5">
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="{{ __('collections.name') }}"
                    value="{{ request('name') }}"
                />
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
                <div class="col text-center">
                    <a href="{{ route('collections.show', $collection->getId()) }}" class="d-block text-uppercase small fw-semibold text-dark text-decoration-none mb-1">
                        {{ $collection->getName() }}
                    </a>
                    <p class="text-muted small">{{ $collection->getDescription() }}</p>
                </div>
            @endforeach
        </div>
    @endif
@endsection