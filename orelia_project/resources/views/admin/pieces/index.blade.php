@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">{{ $viewData['title'] }}</h4>
    <a href="{{ route('admin.pieces.create') }}" class="btn btn-dark">{{ __('pieces.create') }}</a>
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
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                        <td>${{ number_format($piece->getPrice(), 0) }}</td>
                        <td>{{ $piece->getStock() }}</td>
                        <td>{{ $piece->getCollection()->getName() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.pieces.edit', $piece->getId()) }}" class="btn btn-sm btn-outline-dark">{{ __('pieces.edit') }}</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-action="{{ route('admin.pieces.destroy', $piece->getId()) }}">
                                    {{ __('pieces.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('general.confirm_delete_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ __('general.confirm_delete') }}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('general.cancel') }}</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('general.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        document.getElementById('deleteForm').action = e.relatedTarget.dataset.action;
    });
</script>
@endsection