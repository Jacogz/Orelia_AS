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

    <form method="GET" action="{{ route('materials.index') }}" class="card p-3 mb-5 border-0 shadow-sm">
        <div class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="{{ __('materials.name') }}"
                    value="{{ request('name') }}"
                />
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">{{ __('materials.all_types') }}</option>
                    @foreach ($viewData['types'] as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input
                    type="text"
                    name="color"
                    class="form-control"
                    placeholder="{{ __('materials.color') }}"
                    value="{{ request('color') }}"
                />
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
            </div>
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