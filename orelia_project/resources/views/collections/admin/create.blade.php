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
                    <form action="{{ route('admin.collections.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('collections.name') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('collections.description') }}</label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="3"
                            >{{ old('description') }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('collections.save') }}</button>
                            <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">{{ __('collections.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection