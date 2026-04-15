@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $viewData['title'] }}</h4>
        <a href="{{ route('admin.pieces.create') }}" class="btn btn-primary">{{ __('pieces.create') }}</a>
    </div>

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