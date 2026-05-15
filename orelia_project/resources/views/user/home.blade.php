@extends('layouts.app')

@section('title', __('general.home'))

@section('content')

{{-- Hero Section --}}
<section class="py-5 mb-5" style="background: var(--orelia-dark); min-height: 420px; display: flex; align-items: center;">
    <div class="container text-center">
        <p class="mb-2" style="color: var(--orelia-gold); font-family: 'Lato', sans-serif; letter-spacing: 0.25em; font-size: 0.8rem; text-transform: uppercase;">
            {{ __('home.hero_tagline') }}
        </p>
        <h1 class="display-4 mb-3" style="color: var(--orelia-cream); font-family: 'Cormorant Garamond', serif; font-weight: 300;">
            {{ __('home.hero_title') }}
        </h1>
        <p class="mb-4" style="color: rgba(249, 246, 240, 0.65); font-family: 'Lato', sans-serif; max-width: 520px; margin: 0 auto 1.5rem;">
            {{ __('home.hero_subtitle') }}
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('pieces.index') }}"
                class="btn px-4 py-2"
                style="background: var(--orelia-gold); color: #fff; border: none; font-family: 'Lato', sans-serif; letter-spacing: 0.05em; font-size: 0.9rem;">
                {{ __('home.cta_explore') }}
            </a>
            <a href="{{ route('collections.index') }}"
                class="btn px-4 py-2"
                style="border: 1px solid var(--orelia-gold); color: var(--orelia-gold); background: transparent; font-family: 'Lato', sans-serif; font-size: 0.9rem;">
                {{ __('home.cta_collections') }}
            </a>
        </div>
    </div>
</section>

{{-- Featured Pieces --}}
@if(!empty($viewData['featuredPieces']) && $viewData['featuredPieces']->count())
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family: 'Cormorant Garamond', serif; font-weight: 400; color: var(--orelia-dark);">
            {{ __('home.featured_pieces') }}
        </h2>
        <a href="{{ route('pieces.index') }}"
            class="text-decoration-none"
            style="color: var(--orelia-gold); font-family: 'Lato', sans-serif; font-size: 0.875rem;">
            {{ __('home.see_all') }} <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row g-4">
        @foreach($viewData['featuredPieces'] as $piece)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 2px;">
                @if($piece->getImageUrl() !== \App\Models\Piece::DEFAULT_IMAGE)
                <img src="{{ $piece->getImageUrl() }}"
                    class="card-img-top"
                    alt="{{ $piece->getName() }}"
                    style="height: 220px; object-fit: cover;">
                @else
                <div class="d-flex align-items-center justify-content-center"
                    style="height: 220px; background: var(--orelia-cream);">
                    <i class="bi bi-gem" style="font-size: 2.5rem; color: var(--orelia-gold-light);"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <p class="mb-1" style="font-size: 0.7rem; letter-spacing: 0.15em; color: var(--orelia-gold); text-transform: uppercase; font-family: 'Lato', sans-serif;">
                        {{ $piece->getCollection()?->getName() ?? __('home.no_collection') }}
                    </p>
                    <h3 class="card-title mb-1" style="font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 500; color: var(--orelia-dark);">
                        {{ $piece->getName() }}
                    </h3>
                    <p class="mb-3" style="font-family: 'Lato', sans-serif; font-size: 0.875rem; color: #6c757d;">
                        ${{ number_format($piece->getPrice(), 2) }}
                    </p>
                    <a href="{{ route('pieces.show', $piece->getId()) }}"
                        class="btn btn-sm mt-auto w-100"
                        style="border: 1px solid var(--orelia-gold); color: var(--orelia-gold); background: transparent; font-family: 'Lato', sans-serif; font-size: 0.8rem; border-radius: 1px;">
                        {{ __('home.view_piece') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Collections Grid --}}
@if(!empty($viewData['collections']) && $viewData['collections']->count())
<section style="background: var(--orelia-cream);" class="py-5 mb-5">
    <div class="container">
        <h2 class="text-center mb-4" style="font-family: 'Cormorant Garamond', serif; font-weight: 400; color: var(--orelia-dark);">
            {{ __('home.our_collections') }}
        </h2>
        <div class="row g-3 justify-content-center">
            @foreach($viewData['collections'] as $collection)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('collections.show', $collection->getId()) }}"
                    class="text-decoration-none d-block text-center p-4"
                    style="background: #fff; border: 1px solid var(--orelia-border); transition: border-color 0.2s;"
                    onmouseover="this.style.borderColor='var(--orelia-gold)'"
                    onmouseout="this.style.borderColor='var(--orelia-border)'">
                    <i class="bi bi-stars d-block mb-2" style="font-size: 1.5rem; color: var(--orelia-gold);"></i>
                    <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; color: var(--orelia-dark);">
                        {{ $collection->getName() }}
                    </span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Value Props --}}
<section class="container mb-5">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <i class="bi bi-shield-check mb-3 d-block" style="font-size: 2rem; color: var(--orelia-gold);"></i>
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 500; color: var(--orelia-dark);">
                {{ __('home.value_quality_title') }}
            </h3>
            <p class="text-muted" style="font-family: 'Lato', sans-serif; font-size: 0.875rem;">
                {{ __('home.value_quality_text') }}
            </p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-box-seam mb-3 d-block" style="font-size: 2rem; color: var(--orelia-gold);"></i>
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 500; color: var(--orelia-dark);">
                {{ __('home.value_shipping_title') }}
            </h3>
            <p class="text-muted" style="font-family: 'Lato', sans-serif; font-size: 0.875rem;">
                {{ __('home.value_shipping_text') }}
            </p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-hand-thumbs-up mb-3 d-block" style="font-size: 2rem; color: var(--orelia-gold);"></i>
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 500; color: var(--orelia-dark);">
                {{ __('home.value_handmade_title') }}
            </h3>
            <p class="text-muted" style="font-family: 'Lato', sans-serif; font-size: 0.875rem;">
                {{ __('home.value_handmade_text') }}
            </p>
        </div>
    </div>
</section>

@endsection