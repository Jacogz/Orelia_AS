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
                <form action="{{ route('admin.materials.update', $viewData['material']->getId()) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('materials.name') }}</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $viewData['material']->getName()) }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">{{ __('materials.type') }}</label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type" name="type" required>
                            <option value="">{{ __('materials.select_type') }}</option>
                            <option value="metal" {{ old('type', $viewData['material']->getType()) == 'metal' ? 'selected' : '' }}>{{ __('materials.type_metal') }}</option>
                            <option value="gemstone" {{ old('type', $viewData['material']->getType()) == 'gemstone' ? 'selected' : '' }}>{{ __('materials.type_gemstone') }}</option>
                            <option value="leather" {{ old('type', $viewData['material']->getType()) == 'leather' ? 'selected' : '' }}>{{ __('materials.type_leather') }}</option>
                            <option value="textile" {{ old('type', $viewData['material']->getType()) == 'textile' ? 'selected' : '' }}>{{ __('materials.type_textile') }}</option>
                            <option value="other" {{ old('type', $viewData['material']->getType()) == 'other' ? 'selected' : '' }}>{{ __('materials.type_other') }}</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('materials.description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3" required>{{ old('description', $viewData['material']->getDescription()) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">{{ __('materials.color') }}</label>
                        <input type="text"
                               class="form-control @error('color') is-invalid @enderror"
                               id="color" name="color" value="{{ old('color', $viewData['material']->getColor()) }}" required />
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">{{ __('materials.update') }}</button>
                        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary">{{ __('materials.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection