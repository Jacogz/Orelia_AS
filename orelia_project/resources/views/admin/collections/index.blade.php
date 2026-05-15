@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">{{ $viewData['title'] }}</h4>
    <a href="{{ route('admin.collections.create') }}" class="btn btn-dark">{{ __('collections.create') }}</a>
</div>

<form method="GET" action="{{ route('admin.collections.index') }}" class="card p-3 mb-4 border-0 shadow-sm">
    <div class="row g-2">
        <div class="col-md-5">
            <input type="text" name="name" class="form-control" placeholder="{{ __('collections.name') }}" value="{{ request('name') }}" />
        </div>
        <div class="col-md-5">
            <input type="text" name="description" class="form-control" placeholder="{{ __('collections.description') }}" value="{{ request('description') }}" />
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-dark w-100">{{ __('general.filter') }}</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-secondary w-100">{{ __('general.clear') }}</a>
        </div>
    </div>
</form>

@if($viewData['collections']->isEmpty())
    <div class="alert alert-info">{{ __('collections.empty') }}</div>
@else
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('collections.name') }}</th>
                    <th>{{ __('collections.description') }}</th>
                    <th>{{ __('general.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['collections'] as $collection)
                    <tr>
                        <td>{{ $collection->getId() }}</td>
                        <td>{{ $collection->getName() }}</td>
                        <td>{{ $collection->getDescription() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.collections.edit', $collection->getId()) }}" class="btn btn-sm btn-outline-dark">{{ __('collections.edit') }}</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-action="{{ route('admin.collections.destroy', $collection->getId()) }}">
                                    {{ __('collections.delete') }}
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