@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h4 class="fw-bold mb-0">{{ $viewData['title'] }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.pieces.update', $viewData['piece']->getId()) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('pieces.name') }}</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $viewData['piece']->getName()) }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('pieces.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $viewData['piece']->getDescription()) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">{{ __('pieces.price') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price" value="{{ old('price', $viewData['piece']->getPrice()) }}" min="0" step="0.01" required />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">{{ __('pieces.type') }}</label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type" name="type" required>
                            <option value="">{{ __('pieces.select_type') }}</option>
                            <option value="ring" {{ old('type', $viewData['piece']->getType()) == 'ring' ? 'selected' : '' }}>{{ __('pieces.type_ring') }}</option>
                            <option value="necklace" {{ old('type', $viewData['piece']->getType()) == 'necklace' ? 'selected' : '' }}>{{ __('pieces.type_necklace') }}</option>
                            <option value="bracelet" {{ old('type', $viewData['piece']->getType()) == 'bracelet' ? 'selected' : '' }}>{{ __('pieces.type_bracelet') }}</option>
                            <option value="earring" {{ old('type', $viewData['piece']->getType()) == 'earring' ? 'selected' : '' }}>{{ __('pieces.type_earring') }}</option>
                            <option value="brooch" {{ old('type', $viewData['piece']->getType()) == 'brooch' ? 'selected' : '' }}>{{ __('pieces.type_brooch') }}</option>
                            <option value="other" {{ old('type', $viewData['piece']->getType()) == 'other' ? 'selected' : '' }}>{{ __('pieces.type_other') }}</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">{{ __('pieces.image_url') }}</label>
                        <input type="url"
                               class="form-control @error('image_url') is-invalid @enderror"
                               id="image_url" name="image_url" value="{{ old('image_url', $viewData['piece']->getImageUrl()) }}" />
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">{{ __('pieces.stock') }}</label>
                        <input type="number"
                               class="form-control @error('stock') is-invalid @enderror"
                               id="stock" name="stock" value="{{ old('stock', $viewData['piece']->getStock()) }}" min="0" required />
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">{{ __('pieces.size') }}</label>
                        <input type="text"
                               class="form-control @error('size') is-invalid @enderror"
                               id="size" name="size" value="{{ old('size', $viewData['piece']->getSize()) }}" />
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="weight" class="form-label">{{ __('pieces.weight') }}</label>
                        <input type="number" step="0.01"
                               class="form-control @error('weight') is-invalid @enderror"
                               id="weight" name="weight" value="{{ old('weight', $viewData['piece']->getWeight()) }}" min="0" />
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="collec