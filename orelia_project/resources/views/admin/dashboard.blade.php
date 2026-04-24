@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-0">{{ $viewData['title'] }}</h2>
    <p class="text-muted">{{ __('dashboard.subtitle') }}</p>
</div>

<div class="row g-3 mb-5">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.orders') }}</p>
                <h3 class="fw-bold mb-0">{{ $viewData['totalOrders'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.revenue') }}</p>
                <h3 class="fw-bold mb-0">${{ number_format($viewData['totalRevenue'], 0) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.pieces') }}</p>
                <h3 class="fw-bold mb-0">{{ $viewData['totalPieces'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.clients') }}</p>
                <h3 class="fw-bold mb-0">{{ $viewData['totalUsers'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.collections') }}</p>
                <h3 class="fw-bold mb-0">{{ $viewData['totalCollections'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm text-center py-3">
            <div class="card-body">
                <p class="text-muted small mb-1">{{ __('dashboard.materials') }}</p>
                <h3 class="fw-bold mb-0">{{ $viewData['totalMaterials'] }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h5 class="fw-bold">{{ __('dashboard.recent_orders') }}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('dashboard.order_id') }}</th>
                        <th>{{ __('dashboard.client') }}</th>
                        <th>{{ __('dashboard.total') }}</th>
                        <th>{{ __('dashboard.status') }}</th>
                        <th>{{ __('dashboard.payment_status') }}</th>
                        <th>{{ __('dashboard.payment_method') }}</th>
                        <th>{{ __('dashboard.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['recentOrders'] as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->getClient()->getFullName() }}</td>
                        <td>${{ number_format($order->total, 0) }}</td>
                        <td>
                            <span class="badge
                                @if($order->status === 'completed') bg-success
                                @elseif($order->status === 'pending') bg-warning text-dark
                                @elseif($order->status === 'cancelled') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge
                                @if($order->payment_status === 'paid') bg-success
                                @elseif($order->payment_status === 'pending') bg-warning text-dark
                                @else bg-secondary
                                @endif">
                                {{ $order->payment_status }}
                            </span>
                        </td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            {{ __('dashboard.empty') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h5 class="fw-bold">{{ __('dashboard.top_pieces') }}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('dashboard.piece_name') }}</th>
                        <th>{{ __('dashboard.units_sold') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['topPieces'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->getPiece()->name }}</td>
                        <td>{{ $item->total_sold }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            {{ __('dashboard.empty') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <h5 class="fw-bold mb-3">{{ __('dashboard.quick_links') }}</h5>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.pieces.index') }}" class="btn btn-outline-dark w-100">
            {{ __('dashboard.manage_pieces') }}
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-dark w-100">
            {{ __('dashboard.manage_materials') }}
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-dark w-100">
            {{ __('dashboard.manage_collections') }}
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.pieces.create') }}" class="btn btn-dark w-100">
            {{ __('dashboard.new_piece') }}
        </a>
    </div>
</div>
@endsection