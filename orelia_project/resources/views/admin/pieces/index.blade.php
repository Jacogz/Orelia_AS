@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $viewData['title'] }}</h4>
        <a href="{{ route('admin.pieces.create') }}" class="btn btn-primary">{{ __('pieces.create') }}</a>
    </div>

    <form method="GET" action="{{ route('admin.pieces.index') }}" class="card p-3 mb-4 border-0 shadow-sm">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="{{ __('pieces.name') }}" value="{{ request('name') }}" />
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">{{ __('pieces.all_types') }}</option>
                    @foreach ($viewData['types'] as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="collection_id" class="form-select">
                    <option value="">{{ __('pieces.all_collections') }}</option>
                    @foreach ($viewData['collections'] as $collection)
                        <option value="{{ $collection->getId() }}" {{ request('collection_id') == $collection->getId() ? 'selected' : '' }}>
                            {{ $collection->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="number" name="min_price" class="form-control" placeholder="{{ __('pieces.min_price') }}" value="{{ request('min_price') }}" min="0" />
            </div>
            <div class="col-md-1">
                <input type="number" name="max_price" class="form-control" placeholder="{{ __('pieces.max_price') }}" value="{{ request('max_price') }}" min="0" />
            </div>
            <div class="col-md-2">
                <select name="stock" class="form-select">
                    <option value="">{{ __('pieces.all_stock') }}</option>
                    <option value="available" {{ request('stock') == 'available' ? 'selected' : '' }}>{{ __('pieces.in_stock') }}</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.pieces.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
            </div>
        </div>
    </form>

    @if($viewData['pieces']->isEmpty())
        <div class="alert alert-info">{{ __('pieces.empty') }}</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>{{ __('pieces.name') }}</th>
                    <th>{{ __('pieces.type') }}</th>
                    <th>{{ __('pieces.price') }}</th>
                    <th>{{ __('pieces.stock') }}</th>
                    <th>{{ __('pieces.collection') }}</th>
                    <th>{{ __('general.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['pieces'] as $piece)
                    <tr>
                        <td>{{ $piece->getId() }}</td>
                        <td>{{ $piece->getName() }}</td>
                        <td>{{ $piece->getType() }}</td>
                        <td>{{ $piece->getPrice() }}</td>
                        <td>{{ $piece->getStock() }}</td>
                        <td>{{ $piece->getCollection()->getName() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.pieces.edit', $piece->getId()) }}" class="btn btn-sm btn-warning">{{ __('pieces.edit') }}</a>
                                <form action="{{ route('admin.pieces.destroy', $piece->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm(&quot;{{ __('general.confirm_delete') }}&quot;)">
                                        {{ __('pieces.delete') }}
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