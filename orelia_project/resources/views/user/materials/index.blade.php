@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4 text-center">
        <h2>{{ $viewData['title'] }}</h2>
    </div>

    <form method="GET" action="{{ route('materials.index') }}" class="text-center mb-5">
        @if(request('name'))
            <p class="text-uppercase small mb-3">{{ __('materials.results_for') }} &ldquo;{{ request('name') }}&rdquo;</p>
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

    @if($viewData['materials']->isEmpty())
        <div class="text-center text-muted py-5 text-uppercase small">{{ __('materials.empty_user') }}</div>
    @else
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($viewData['materials'] as $material)
                <div class="col text-center">
                    <a href="{{ route('materials.show', $material->getId()) }}" class="d-block text-uppercase small fw-semibold text-dark text-decoration-none mb-1">
                        {{ $material->getName() }}
                    </a>
                    <span class="d-block text-muted small">{{ $material->getType() }}</span>
                    <span class="d-block text-muted small">{{ $material->getColor() }}</span>
                </div>
            @endforeach
        </div>
    @endif
@endsection