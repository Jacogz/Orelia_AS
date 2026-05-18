<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(Request $request): View
    {
        $query = Piece::with('collection');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('collection_id')) {
            $query->where('collection_id', $request->collection_id);
        }

        if ($request->filled('stock') && $request->stock === 'available') {
            $query->where('stock', '>', 0);
        }

        $viewData = [];
        $viewData['title'] = __('pieces.title');
        $viewData['subtitle'] = __('pieces.subtitle');
        $viewData['pieces'] = $query->get();
        $viewData['collections'] = Collection::all();
        $viewData['types'] = Piece::select('type')->distinct()->pluck('type');
        $viewData['rates'] = $this->exchangeRateService->getRates();

        return view('user.pieces.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $piece = Piece::with('collection', 'materials')->findOrFail($id);

        $viewData = [];
        $viewData['title'] = $piece->getName();
        $viewData['piece'] = $piece;

        return view('user.pieces.show')->with('viewData', $viewData);
    }
}
