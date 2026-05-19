<?php

namespace App\Http\Controllers\User;

use App\Filters\PieceFilter;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PieceController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    private PieceFilter $pieceFilter;

    public function __construct(
        ExchangeRateService $exchangeRateService,
        PieceFilter $pieceFilter
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->pieceFilter = $pieceFilter;
    }

    public function index(Request $request): View
    {
        $query = Piece::with('collection');
        $this->pieceFilter->apply($query, $request);

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
