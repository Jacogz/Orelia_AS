@extends('layouts.app')

@section('title', 'Materials')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Materials</h4>
        <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">Create Material</a>
    </div>

    @if($materials->isEmpty())
        <div class="alert alert-info">No materials found.</div>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>{{ $material->getId() }}</td>
                        <td>{{ $material->getName() }}</td>
                        <td>{{ $material->getType() }}</td>
                        <td>{{ $material->getDescription() }}</td>
                        <td>{{ $material->getColor() }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.materials.edit', $material->getId()) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.materials.destroy', $material->getId()) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this material?')">
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