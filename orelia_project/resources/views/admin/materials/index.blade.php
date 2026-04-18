@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $viewData['title'] }}</h4>
        <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">{{ __('materials.create') }}</a>
    </div>

    <form method="GET" action="{{ route('admin.materials.index') }}" class="card p-3 mb-4 border-0 shadow-sm">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="{{ __('materials.name') }}" value="{{ request('name') }}" />
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">{{ __('materials.all_types') }}</option>
                    @foreach ($viewData['types'] as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="color" class="form-control" placeholder="{{ __('materials.color') }}" value="{{ request('color') }}" />
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
            </div>
        </div>
    </form>

    @if($viewData['materials']->isEmpty())
        <div class="alert alert-info">{{ __('materials.empty') }}</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>{{ __('materials.name') }}</th>
                    <th>{{ __('materials.type') }}</th>
                    <th>{{ __('materials.description') }}</th>
                    <th>{{ __('materials.color') }}</th>
                    <th>{{ __('general.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['materials'] as $material)
                    <tr>
                        <td>{{ $material->getId() }}</td>
                        <td>{{ $material->getName() }}</td>
                        <td>{{ $material->getType() }}</td>
                        <td>{{ $material->getDescription() }}</td>
                        <td>{{ $material->getColor() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.materials.edit', $material->getId()) }}" class="btn btn-sm btn-warning">{{ __('materials.edit') }}</a>
                                <form action="{{ route('admin.materials.destroy', $material->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm(&quot;{{ __('general.confirm_delete') }}&quot;)">
                                        {{ __('materials.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection