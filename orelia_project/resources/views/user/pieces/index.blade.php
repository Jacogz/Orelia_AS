@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="mb-4 text-center">
        <h2>{{ $viewData['title'] }}</h2>
    </div>

    <form method="GET" action="{{ route('pieces.index') }}" class="text-center mb-5">
        @if(request('name'))
            <p class="text-uppercase small letter-spacing mb-3">{{ __('pieces.results_for') }} &ldquo;{{ request('name') }}&rdquo;</p>
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

    @if($viewData['pieces']->isEmpty())
        <div class="text-center text-muted py-5 text-uppercase small">{{ __('pieces.empty_user') }}</div>
    @else
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($viewData['pieces'] as $piece)
                <div class="col">
                    <div class="position-relative overflow-hidden" style="background:#f7f7f5">
                        <img
                            src="{{ $piece->getImageUrl() }}"
                            alt="{{ $piece->getName() }}"
                            class="w-100"
                            style="aspect-ratio:1/1; object-fit:cover; display:block"
                        >
                        {{-- Button revealed on hover to keep grid uncluttered --}}
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 orelia-overlay">
                            @if($piece->getStock() > 0)
                                <form action="{{ route('cart.add', $piece->getId()) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-dark w-100 rounded-0 small text-uppercase">{{ __('pieces.add_to_cart') }}</button>
                                </form>
                            @else
                                <span class="d-block text-center text-danger small text-uppercase">{{ __('pieces.out_of_stock') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('pieces.show', $piece->getId()) }}" class="d-block text-uppercase small fw-semibold text-dark text-decoration-none">{{ $piece->getName() }}</a>
                        <span class="d-block text-muted small">{{ $piece->getCollection()->getName() }}</span>
                        <span class="d-block small">${{ number_format($piece->getPrice(), 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .orelia-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .col:hover .orelia-overlay {
            opacity: 1;
        }
    </style>
@endsection