<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use App\Models\User;
use Exception;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        try {
            $totalOrders = Order::count();
            $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
            $totalPieces = Piece::count();
            $totalUsers = User::where('role', 'client')->count();
            $totalCollections = Collection::count();
            $totalMaterials = Material::count();
            $recentOrders = Order::with('client')->latest()->take(5)->get();
            $topPieces = OrderItem::with('piece')
                ->selectRaw('piece_id, SUM(quantity) as total_sold')
                ->groupBy('piece_id')
                ->orderByDesc('total_sold')
                ->take(3)
                ->get();
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', __('dashboard.error'));
        }

        $viewData = [];
        $viewData['title'] = __('dashboard.title');
        $viewData['totalOrders'] = $totalOrders;
        $viewData['totalRevenue'] = $totalRevenue;
        $viewData['totalPieces'] = $totalPieces;
        $viewData['totalUsers'] = $totalUsers;
        $viewData['totalCollections'] = $totalCollections;
        $viewData['totalMaterials'] = $totalMaterials;
        $viewData['recentOrders'] = $recentOrders;
        $viewData['topPieces'] = $topPieces;

        return view('admin.dashboard', ['viewData' => $viewData]);
    }
}
