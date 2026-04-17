@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $viewData['title'] }}</h4>
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">{{ __('collections.create') }}</a>
    </div>

    @if($viewData['collections']->isEmpty())
        <div class="alert alert-info">{{ __('collections.empty') }}</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
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
                                <a href="{{ route('admin.collections.edit', $collection->getId()) }}" class="btn btn-sm btn-warning">{{ __('collections.edit') }}</a>
                                <form action="{{ route('admin.collections.destroy', $collection->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm(&quot;{{ __('general.confirm_delete') }}&quot;)">
                                        {{ __('collections.delete') }}
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