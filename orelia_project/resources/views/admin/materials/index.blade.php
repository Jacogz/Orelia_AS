@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">{{ $viewData['title'] }}</h4>
    <a href="{{ route('admin.materials.create') }}" class="btn btn-dark">{{ __('materials.create') }}</a>
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
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                                <a href="{{ route('admin.materials.edit', $material->getId()) }}" class="btn btn-sm btn-outline-dark">{{ __('materials.edit') }}</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-action="{{ route('admin.materials.destroy', $material->getId()) }}">
                                    {{ __('materials.delete') }}
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