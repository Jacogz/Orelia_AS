@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')

<div class="mb-4">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-weight: 400; color: var(--orelia-dark);">
        {{ $viewData['title'] }}
    </h1>
    <p style="font-family: 'Lato', sans-serif; color: #6c757d; font-size: 0.95rem;">
        {{ __('exchangerate.subtitle') }}
    </p>
</div>

@if($viewData['rates']['available'])

    {{-- Tasas de cambio --}}
    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width: 48px; height: 48px; background: var(--orelia-gold-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-currency-dollar" style="font-size: 1.4rem; color: var(--orelia-gold);"></i>
                    </div>
                    <div>
                        <p class="mb-0" style="font-size: 0.7rem; letter-spacing: 0.15em; color: var(--orelia-gold); text-transform: uppercase; font-family: 'Lato', sans-serif;">
                            {{ __('exchangerate.rate') }}
                        </p>
                        <h2 class="mb-0" style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; color: var(--orelia-dark);">
                            {{ __('exchangerate.usd') }}
                        </h2>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="mb-1" style="font-size: 1rem; font-family: 'Lato', sans-serif; color: #6c757d;">
                        1 {{ $viewData['rates']['base'] }} =
                        <span style="color: var(--orelia-gold); font-weight: 700;">
                            ${{ number_format($viewData['rates']['USD'], 6) }} USD
                        </span>
                    </p>
                    <p class="mb-0" style="font-size: 1.5rem; font-family: 'Cormorant Garamond', serif; color: var(--orelia-dark);">
                        1 USD = <span style="font-family: 'Lato', sans-serif; font-weight: 700; color: var(--orelia-gold);">${{ number_format(1 / $viewData['rates']['USD'], 2, '.', ',') }} COP</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width: 48px; height: 48px; background: var(--orelia-gold-muted); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-currency-euro" style="font-size: 1.4rem; color: var(--orelia-gold);"></i>
                    </div>
                    <div>
                        <p class="mb-0" style="font-size: 0.7rem; letter-spacing: 0.15em; color: var(--orelia-gold); text-transform: uppercase; font-family: 'Lato', sans-serif;">
                            {{ __('exchangerate.rate') }}
                        </p>
                        <h2 class="mb-0" style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; color: var(--orelia-dark);">
                            {{ __('exchangerate.eur') }}
                        </h2>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="mb-1" style="font-size: 1rem; font-family: 'Lato', sans-serif; color: #6c757d;">
                        1 {{ $viewData['rates']['base'] }} =
                        <span style="color: var(--orelia-gold); font-weight: 700;">
                            €{{ number_format($viewData['rates']['EUR'], 6) }} EUR
                        </span>
                    </p>
                    <p class="mb-0" style="font-size: 1.5rem; font-family: 'Cormorant Garamond', serif; color: var(--orelia-dark);">
                        1 EUR = <span style="font-family: 'Lato', sans-serif; font-weight: 700; color: var(--orelia-gold);">€{{ number_format(1 / $viewData['rates']['EUR'], 2, '.', ',') }} COP</span>
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Referencia práctica --}}
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h3 class="mb-1" style="font-family: 'Cormorant Garamond', serif; font-weight: 400; color: var(--orelia-dark);">
            {{ __('exchangerate.practical_title') }}
        </h3>
        <p class="mb-4" style="font-family: 'Lato', sans-serif; color: #6c757d; font-size: 0.875rem;">
            {{ __('exchangerate.practical_sub') }}
        </p>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('exchangerate.piece_example') }} (COP)</th>
                        <th>USD</th>
                        <th>EUR</th>
                    </tr>
                </thead>
                <tbody style="font-family: 'Lato', sans-serif; font-size: 0.9rem;">
                    @foreach([50000, 100000, 200000, 500000, 1000000] as $cop)
                    <tr>
                        <td style="color: var(--orelia-dark);">
                            ${{ number_format($cop, 0, ',', '.') }} COP
                        </td>
                        <td>
                            <span style="font-family: 'Lato', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--orelia-gold); letter-spacing: 0.03em;">
                                ${{ number_format($cop * $viewData['rates']['USD'], 2, '.', ',') }}
                            </span>
                        </td>
                        <td>
                            <span style="font-family: 'Lato', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--orelia-gold); letter-spacing: 0.03em;">
                                €{{ number_format($cop * $viewData['rates']['EUR'], 2, '.', ',') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-muted" style="font-size: 0.8rem; font-family: 'Lato', sans-serif;">
        <i class="bi bi-clock me-1"></i>{{ __('exchangerate.last_updated') }}
    </p>

@else

    <div class="alert" style="border: 1px solid var(--orelia-gold-muted); background: var(--orelia-cream); color: var(--orelia-dark);">
        <i class="bi bi-exclamation-circle me-2" style="color: var(--orelia-gold);"></i>
        {{ __('exchangerate.unavailable') }}
    </div>

@endif

@endsection