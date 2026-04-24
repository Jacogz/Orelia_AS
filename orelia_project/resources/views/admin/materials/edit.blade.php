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
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $viewData['material']->getName()) }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('materials.type') }}</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $viewData['material']->getType()) }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('materials.description') }}</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $viewData['material']->getDescription()) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">{{ __('materials.color') }}</label>
                            <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $viewData['material']->getColor()) }}" required />
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('materials.update') }}</button>
                            <a href="{{ route('admin.materials.index') }}" class="btn btn-secondary">{{ __('materials.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection