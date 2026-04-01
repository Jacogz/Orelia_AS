@extends('layouts.app')

@section('title', 'Pieces')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Pieces</h4>
        <a href="{{ route('admin.pieces.create') }}" class="btn btn-primary">Create Piece</a>
    </div>

    @if($pieces->isEmpty())
        <div class="alert alert-info">No pieces found.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Collection</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pieces as $piece)
                    <tr>
                        <td>{{ $piece->getId() }}</td>
                        <td>{{ $piece->getName() }}</td>
                        <td>{{ $piece->getType() }}</td>
                        <td>{{ $piece->getPrice() }}</td>
                        <td>{{ $piece->getStock() }}</td>
                        <td>{{ $piece->getCollection()->getName() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.pieces.edit', $piece->getId()) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.pieces.destroy', $piece->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this piece?')">
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