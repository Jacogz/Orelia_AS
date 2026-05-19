<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Piece;
use App\Services\ExchangeRateService;
use App\Services\GuestProductsService;
use Illuminate\View\View;

class HomeController extends Controller
{
    private ExchangeRateService $exchangeRateService;

    private GuestProductsService $guestProductsService;

    public function __construct(
        ExchangeRateService $exchangeRateService,
        GuestProductsService $guestProductsService
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->guestProductsService = $guestProductsService;
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
        $viewData['guestProducts'] = $this->guestProductsService->getProducts();

        return view('user.home')->with('viewData', $viewData);
    }
}
