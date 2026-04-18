@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4 text-center">
        <h2>{{ $viewData['title'] }}</h2>
    </div>

    <form method="GET" action="{{ route('collections.index') }}" class="text-center mb-5">
        @if(request('name'))
            <p class="text-uppercase small mb-3">{{ __('collections.results_for') }} &ldquo;{{ request('name') }}&rdquo;</p>
        @endif
        <div class="d-inline-flex border-bottom border-dark" style="width: 480px">
            <input
                type="text"
                name="name"
                class="form-control border-0 shadow-none"
                value="{{ request('name') }}"
                placeholder="{{ $viewData['subtitle'] }}"
                autocomplete="off"
            />
            <button type="submit" class="btn btn-dark rounded-0 px-4">{{ __('general.search') }}</button>
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