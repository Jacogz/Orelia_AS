@extends('layouts.app')

@section('title', 'Collections')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Collections</h4>
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">Create Collection</a>
    </div>

    @if($collections->isEmpty())
        <div class="alert alert-info">No collections found.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                    <tr>
                        <td>{{ $collection->getId() }}</td>
                        <td>{{ $collection->getName() }}</td>
                        <td>{{ $collection->getDescription() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.collections.edit', $collection->getId()) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.collections.destroy', $collection->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this collection?')">
                                        Delete
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