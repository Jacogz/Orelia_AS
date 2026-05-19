@extends('layouts.app')

@section('title', $viewData['title'])
@section('content')
<div class="mb-4 text-center">
    <h2 class="text-uppercase">{{ $viewData['collection']->getName() }}</h2>
    <p class="text-muted">{{ $viewData['collection']->getDescription() }}</p>
</div>

@if($viewData['pieces']->isEmpty())
    <div class="text-center text-muted py-5 text-uppercase small">{{ __('collections.no_pieces') }}</div>
@else

    {{-- Currency selector --}}
    @if(isset($viewData['rates']) && $viewData['rates']['available'])
    <div class="d-flex align-items-center gap-2 mb-4">
        <span style="font-family: 'Lato', sans-serif; font-size: 0.75rem; letter-spacing: 0.1em; color: #6c757d; text-transform: uppercase;">
            {{ __('pieces.view_prices_in') }}:
        </span>
        <button class="currency-btn active" onclick="setCurrency('COP', this)">COP</button>
        <button class="currency-btn" onclick="setCurrency('USD', this)">USD</button>
        <button class="currency-btn" onclick="setCurrency('EUR', this)">EUR</button>
    </div>
    @endif

    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($viewData['pieces'] as $piece)
            <div class="col orelia-card">
                <div class="position-relative overflow-hidden d-flex align-items-center justify-content-center" style="background:#f7f7f5; aspect-ratio:1/1;">
                    <img src="{{ $piece->getImageUrl() }}"
                        alt="{{ $piece->getName() }}"
                        class="w-100 h-100"
                        style="object-fit:cover; display:block; position:absolute; top:0; left:0;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; align-items:center; justify-content:center; background:#f7f7f5;">
                        <i class="bi bi-gem" style="font-size: 2.5rem; color: var(--orelia-gold-light);"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 p-3 orelia-overlay">
                        @if($piece->getStock() > 0)
                            <form action="{{ route('cart.add', $piece->getId()) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark w-100 rounded-0 small text-uppercase">
                                    {{ __('pieces.add_to_cart') }}
                                </button>
                            </form>
                        @else
                            <span class="d-block text-center text-danger small text-uppercase">
                                {{ __('pieces.out_of_stock') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ route('pieces.show', $piece->getId()) }}"
                        class="d-block text-uppercase small fw-semibold text-dark text-decoration-none">
                        {{ $piece->getName() }}
                    </a>
                    <span class="d-block small piece-price"
                          data-cop="{{ $piece->getPrice() }}"
                          @if(isset($viewData['rates']) && $viewData['rates']['available'])
                          data-usd="{{ $viewData['rates']['USD'] }}"
                          data-eur="{{ $viewData['rates']['EUR'] }}"
                          @endif>
                        ${{ number_format($piece->getPrice(), 2) }} COP
                    </span>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="mt-4 text-center">
    <a href="{{ route('collections.index') }}" class="btn btn-outline-dark btn-sm rounded-0">
        {{ __('general.back') }}
    </a>
</div>
@endsection
