<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [
            'title' => __('general.home'),
            'featuredPieces' => Piece::with('collection')
                ->where('stock', '>', 0)
                ->latest()
                ->take(8)
                ->get(),
            'collections' => Collection::all(),
        ];

        return view('user.home')->with('viewData', $viewData);
    }
}
