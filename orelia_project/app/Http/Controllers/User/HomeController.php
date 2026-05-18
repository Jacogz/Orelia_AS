<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use App\Services\ExchangeRateService;
use Illuminate\View\View;

class HomeController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('general.home');
        $viewData['featuredPieces'] = Piece::with('collection')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        $viewData['collections'] = Collection::all();
        $viewData['rates'] = $this->exchangeRateService->getRates();

        return view('user.home')->with('viewData', $viewData);
    }
}
