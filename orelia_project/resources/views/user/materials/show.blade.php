@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="text-center py-5 border-bottom mb-5">
        <p class="text-uppercase small text-muted mb-2">{{ $viewData['material']->getType() }}</p>
        <h2 class="text-uppercase">{{ $viewData['material']->getName() }}</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <p class="text-muted mb-4">{{ $viewData['material']->getDescription() }}</p>
            <p class="small text-uppercase mb-1 text-muted">{{ __('materials.color') }}</p>
            <p class="fw-semibold text-uppercase">{{ $viewData['material']->getColor() }}</p>

            <div class="mt-5">
                <a href="{{ route('materials.index') }}" class="btn btn-outline-dark btn-sm rounded-0">{{ __('materials.cancel') }}</a>
            </div>
        </div>
    </div>
@endsection