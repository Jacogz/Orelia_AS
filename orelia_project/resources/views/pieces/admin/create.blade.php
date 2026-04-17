@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ $viewData['title'] }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pieces.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('pieces.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('pieces.description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('pieces.price') }}</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" required />
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('pieces.type') }}</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">{{ __('pieces.image_url') }}</label>
                            <input type="url" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}" />
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">{{ __('pieces.stock') }}</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" min="0" required />
                        </div>
                        <div class="mb-3">
                            <label for="size" class="form-label">{{ __('pieces.size') }}</label>
                            <input type="text" class="form-control" id="size" name="size" value="{{ old('size') }}" />
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">{{ __('pieces.weight') }}</label>
                            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight') }}" min="0" />
                        </div>
                        <div class="mb-3">
                            <label for="collection_id" class="form-label">{{ __('pieces.collection') }}</label>
                            <select class="form-select" id="collection_id" name="collection_id" required>
                                <option value="">{{ __('pieces.select_collection') }}</option>
                                @foreach($viewData['collections'] as $collection)
                                    <option value="{{ $collection->getId() }}" {{ old('collection_id') == $collection->getId() ? 'selected' : '' }}>
                                        {{ $collection->getName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('pieces.save') }}</button>
                            <a href="{{ route('admin.pieces.index') }}" class="btn btn-secondary">{{ __('pieces.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection